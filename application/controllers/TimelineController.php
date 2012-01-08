<?php
class TimelineController extends Zend_Controller_Action {
	
	public function init()
    {
       
    }
    
    public function indexAction(){
    	
    }
	
	public function getJsonAction(){
		$this->_helper->layout()->disableLayout();
		$user = Application_Model_AuthUser::getAuthUser();
		$this->view->obUser = $user;
		$this->view->arrLogs = $user->getLogs();
	}

}