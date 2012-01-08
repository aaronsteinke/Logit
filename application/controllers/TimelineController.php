<?php
class TimelineController extends Zend_Controller_Action {
	
	public function init()
    {
       
    }
    
    public function indexAction(){
    	
    }
	
	public function getJsonAction(){
		$this->_helper->layout()->disableLayout();
		
		$alleLogs = array();
		$userMapper = new Application_Model_UserMapper();
		$usernames = explode(',', $this->getRequest()->getParam('names'));
		
		foreach ($usernames as $name) {
			$obUser = $userMapper->getOneByUsername($name);
			array_push($alleLogs, $obUser->getLogs());
		}
		$obAuthUser = Application_Model_AuthUser::getAuthUser();
		array_push($alleLogs, $obAuthUser->getLogs());
		$this->view->obUser = $obAuthUser;
		$this->view->arrLogs = $alleLogs;
	}

}