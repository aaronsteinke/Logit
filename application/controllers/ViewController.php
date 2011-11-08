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
								md5($this->getRequest()->getParam('inputPassword')));
		}
		
		echo '<pre>' . print_r($this->getRequest()->getParams(),1) . '</php>';
		
	}
	
		
	
	public function upload(){
		
	}
	
	
	public function testerAction() {
		$form = new Application_Form_CreateUser();
		echo $form;
		if ($this->getRequest()->getParam('inputSubmit') == 'inputSubmit') {
			echo '<pre>' . print_r($this->getRequest()->getParams(),1) . '</php>';
		}
	}
	
}