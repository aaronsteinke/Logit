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
		$arrUsernames = explode(',', $this->getRequest()->getParam('names'));
		if ($arrUsernames[0] != ""){
			foreach ($arrUsernames as $name) {
				$obUser = $userMapper->getOneByUsername($name);
				$arrUserLogs = $obUser->getLogs();
				foreach($arrUserLogs as $log){
					array_push($alleLogs, $log);
				}
			}
		}
		
		$obAuthUser = Application_Model_AuthUser::getAuthUser();
		foreach ($obAuthUser->getLogs() as $log) {
			array_push($alleLogs, $log);
		}
		$this->view->obUser = $obAuthUser;
		$this->view->arrLogs = $alleLogs;
		
	}

}