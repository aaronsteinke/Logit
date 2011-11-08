<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	$auth = Zend_Auth::getInstance();
		
		echo '<pre>' . print_r($auth->getIdentity(),1) . '</php>';
    }
    
    private function createUser(){
    	
    }
    
    private function login(){
    	
		//$test = new Application_Model_UserMapper();
		//echo '<pre>' . print_r($test->getOneByUsername('test'),1) . '</php>';
		
		
	} //ende login
	
	public function testAction()
	{
	
	}


}

