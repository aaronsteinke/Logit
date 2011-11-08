<?php

class AjaxController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout()->disableLayout();
    }

   
	public function loginFormAction()
	{
		$this->_helper->viewRenderer->setNoRender(true);
		
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
				
				echo 'Username bzw. Password wurde nicht gefunden';
				break;
				
			case Zend_Auth_Result::SUCCESS:
				echo 'Anmeldung erfolgreich!';
				/*$obUser = $auth->getIdentity();
				if ($obUser->getFirstName() == null){
					return $this->_redirect(user);
				} else {
					return $this->_redirect(index);
				}*/
				break;
				
			default:
				echo 'Bitte loggen Sie sich ein';
				break;
		}
	}
	
	public function logoutAction(){
		$this->_helper->viewRenderer->setNoRender(true);
		
		$auth = Zend_Auth::getInstance();
		
		$auth->clearIdentity();
	}
	public function createUserFormAction(){
		
		$arrRequest = $this->getRequest()->getParams();
		$this->view->usernameHeadline = 'Benutzername:';
		$this->view->eMailHeadline = 'E-Mail:';
		$this->view->eMail2Headline = 'E-Mail bestätigen:';
		$this->view->passwordHeadline = 'Passwort:';
		
		
		if (isset($arrRequest['formType'])){
			
			$boolBreak = false;
			
			switch ('') {
				case $arrRequest['inputUsername']:
				$this->view->usernameHeadline = '<p class="red"> Du musst einen Benutzernamen eingeben!</p>';
				$boolBreak = true;
				
				case $arrRequest['inputEMail']:
				$this->view->eMailHeadline = '<p class="red"> Du musst deine Mail-Adresse angeben!</p>';
				$boolBreak = true;
				
				case $arrRequest['inputEMail2']:
				$this->view->eMail2Headline = '<p class="red"> Hier musst du noch deine Mail-Adresse bestätigen!</p>';
				$boolBreak = true;
				
				case $arrRequest['inputPassword']:
				$this->view->passwordHeadline = '<p class="red"> Bitte gib hier ein Passwort an!</p>';
				$boolBreak = true;
			}
			
			if($arrRequest['inputEMail'] != $arrRequest['inputEMail2']){
				$this->view->eMailHeadline = '<p class="red"> Die Mail-Adressen stimmen nicht über ein!</p>';
			}
			
			if($boolBreak){
				return 0;
			}
			// falsche parameter 
			$obUsers = new Application_Model_UserMapper();
			
			$obUsers->create(	$arrRequest['inputUsername'],
								$arrRequest['inputEMail'],
								$arrRequest['inputPassword'], 
								md5($arrRequest['test']));
			
		}
		/*
		$this->view->inputFirstName = $this->getRequest()->getParam('inputFirstName');
		$this->view->inputLastName = $this->getRequest()->getParam('inputLastName');
		$this->view->inputUserName = $this->getRequest()->getParam('inputUserName');
		$this->view->inputPassword = $this->getRequest()->getParam('inputPassword');
		$this->view->inputSubmit = $this->getRequest()->getParam('inputSubmit');
		
		
		}*/
	}
	
}