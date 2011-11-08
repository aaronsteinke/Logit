<?php

class ViewController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
	
	public function createUserAction()
	{
		
		$form = new Application_Form_CreateUser();
		$this->view->inputFirstName = $form->getElement('inputFirstName');
		$this->view->inputLastName = $form->getElement('inputLastName');
		$this->view->inputUserName = $form->getElement('inputUserName');
		$this->view->inputPassword = $form->getElement('inputPassword');
		$this->view->inputSubmit = $form->getElement('inputSubmit');
		
		if($this->getRequest()->getParam('inputSubmit') == 'inputSubmit'){
			
			$obUsers = new Application_Model_UserMapper();
			
			$obUsers->create(	$this->getRequest()->getParam('inputUserName'),
								$this->getRequest()->getParam('inputFirstName'),
								$this->getRequest()->getParam('inputLastName'), 
								$this->getRequest()->getParam('inputPassword'));
		}
		
		echo '<pre>' . print_r($this->getRequest()->getParams(),1) . '</php>';
		
	}
	
	public function loginAction(){
		
		$loginForm = new Application_Form_Login($_POST);
		
		if ($loginForm->isValid($_POST)){
			$db = $this->getDatabase();
			
			$adapter = new Zend_Auth_Adapter_DbTable(
				$db,
				'user',
				'username',
				'password'
			);
			
			$adapter->setIdentity($loginForm->getValue('username'));
			$adapter->setCredential($loginForm->getValue('password'));
			
			$auth = Zend_Auth::getInstance();
			$result = $auth->authenticate($adapter);
			
			if($result->isValid()){
				
				echo 'test';
				return;
				
			}
			
		}
		
		$this->view->loginForm = $loginForm;
	}
	
	public function uploadAction(){
		
		//echo '<pre>' . print_r($this->getFrontController()->getParams(),1) . '</php>';
	}
	
	private function getDatabase(){
		$config = new Zend_Config_Ini(APPLICATION_PATH. '/configs/application.ini', 'production');
		$db = new Zend_Db_Adapter_Pdo_Mysql(array(
			'adapter'=>$config->resources->db->adapter,
			'host'=>$config->resources->db->params->host,
			'username'=>$config->resources->db->params->username,
			'password'=>$config->resources->db->params->password,
			'dbname'=> $config->resources->db->params->dbname
		));
		return $db;
	}
	
}