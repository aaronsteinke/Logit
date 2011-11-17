<?php

class IndexController extends Zend_Controller_Action
{

	public function init()
	{
		 
	}


	public function indexAction()
	{
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()){
			$this->_redirect(map);
		}
	}

	public function loginFormAction()
	{
		$this->_helper->layout()->disableLayout();
		$arrRequest = $this->getRequest()->getParams();


		if (isset($arrRequest['inputSubmit'])){
			$auth = Zend_Auth::getInstance();
				
			//Zend_Session::regenerateId();
				
			$strUsername = $this->getRequest()->getParam('inputUsername');
			$strPassword = $this->getRequest()->getParam('inputPassword');
				
			$adapter = new Application_Model_Adapter_Authdb();
			$adapter->setIdentity($strUsername)
			->setCredential($strPassword);
			$adapter->authenticate();
				
			$result = $auth->authenticate($adapter);
				
			switch ($result->getCode()){
				case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
					$this->view->error = true;
					break;
						
				case Zend_Auth_Result::SUCCESS:
					$this->view->redirekt = true;
					break;
						
			}
		}
	}


	public function logoutAction(){
		$this->_helper->viewRenderer->setNoRender(true);

		$auth = Zend_Auth::getInstance();

		$auth->clearIdentity();

		$this->_redirect(index);
	}


	public function createUserFormAction(){
		$this->_helper->layout()->disableLayout();
		
		$arrRequest = $this->getRequest()->getParams();
		$this->view->usernameHeadline = '<p>Benutzername:</p>';
		$this->view->eMailHeadline = '<p>E-Mail:</p>';
		$this->view->eMail2Headline = '<p>E-Mail bestätigen:</p>';
		$this->view->passwordHeadline = '<p>Passwort:</p>';

		// testen ob das formular übermittelt wurde
		if (isset($arrRequest['formType'])){
			$obUsers = new Application_Model_UserMapper();
				
			// values der view übergeben
			$this->view->inputUsername = $arrRequest['inputUsername'];
			$this->view->inputEMail = $arrRequest['inputEMail'];
			$this->view->inputEMail2 = $arrRequest['inputEMail2'];
				
			$boolBreak = false;
				
			// testen ob emails nicht überein stimmen
			if($arrRequest['inputEMail'] != $arrRequest['inputEMail2']){
				$this->view->eMailHeadline = '<p class="red"> Die Mail-Adressen stimmen nicht über ein!</p>';
				$this->view->eMailHeadline2 = '<p>E-Mail bestätigen:</p>';
				$boolBreak = true;
			}
				
				
			// testen ob email und username bereits vergeben wurden
			$obUser = $obUsers->getOneByUsername($arrRequest['inputUsername']);
			$obUser2 = $obUsers->getOneByEMail($arrRequest['inputEMail']);
				
			if(!empty($obUser)){
				$this->view->usernameHeadline = '<p class="red"> Der Username ist bereits vergeben!</p>';
				$boolBreak = true;
			}
			if(!empty($obUser2)){
				$this->view->eMailHeadline = '<p class="red"> Die Mail-Adresse ist bereits vergeben!</p>';
				$boolBreak = true;
			}
				
			// testen ob emails wirklich emails sind
			$validator = new Zend_Validate_EmailAddress();
			if (!$validator->isValid($arrRequest['inputEMail'])) {
				$this->view->eMailHeadline = '<p class="red"> Das ist keine gültige Mail-Adresse!</p>';
				$boolBreak = true;
			}
			if (!$validator->isValid($arrRequest['inputEMail2'])) {
				$this->view->eMail2Headline = '<p class="red"> Das ist keine gültige Mail-Adresse!</p>';
				$boolBreak = true;
			}

			// testen ob felder nicht gesetzt wurden
			if($arrRequest['inputUsername'] == ''){
				$this->view->usernameHeadline = '<p class="red"> Du musst einen Benutzernamen eingeben!</p>';
				$boolBreak = true;
			}

			if($arrRequest['inputEMail'] == ''){
				$this->view->eMailHeadline = '<p class="red"> Du musst deine Mail-Adresse angeben!</p>';
				$boolBreak = true;
			}

			if( $arrRequest['inputEMail2'] == ''){
				$this->view->eMail2Headline = '<p class="red"> Hier musst du noch deine Mail-Adresse bestätigen!</p>';
				$boolBreak = true;
			}

			if( $arrRequest['inputPassword'] == ''){
				$this->view->passwordHeadline = '<p class="red"> Bitte gib hier ein Passwort an!</p>';
				$boolBreak = true;
			}
				
				
			// abbrechen falls eine der überprüfungen fehlgeschlagen ist
			if($boolBreak){
				return 0;
			}
				
				
			// eintrag in die datenbank
			$obUsers->create(	$arrRequest['inputUsername'],
			$arrRequest['inputEMail'],
			md5($arrRequest['inputPassword']),
			$arrRequest['birth']['year'] . '-' .
			$arrRequest['birth']['month'] . '-' .
			$arrRequest['birth']['day']);
			// formular ausblenden
			$this->view->success = true;

		}

	}

}

