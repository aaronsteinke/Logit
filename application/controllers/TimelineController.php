<?php
class TimelineController extends Zend_Controller_Action {
	
	public function init()
    {
       
    }
    
    public function indexAction(){
    	
    }
	
	public function getJsonAction(){
		$this->_helper->layout()->disableLayout();
		$userMapper = new Application_Model_UserMapper();
		$obAuthUser = Application_Model_AuthUser::getAuthUser();
		
		$alleLogs = array();
		$arrUser = array();

		array_push($arrUser, $obAuthUser);

		$arrUsernames = explode(',', $this->getRequest()->getParam('names'));
		if ($arrUsernames[0] != ""){
			foreach ($arrUsernames as $name) {
				$obUser = $userMapper->getOneByUsername($name);
				$arrUserLogs = $obUser->getLogs();
				if(is_object($obUser->getFirstLog())){
					array_push($arrUser, $obUser);
					foreach($arrUserLogs as $log){
						array_push($alleLogs, $log);
					}
				}
			}
		}
		
		foreach ($obAuthUser->getLogs() as $log) {
			array_push($alleLogs, $log);
		}
		$this->view->arrUser = $arrUser;
		$this->view->obUser = $obAuthUser;
		$this->view->arrLogs = $alleLogs;
		
	}

	public function getJson2Action(){
		$this->_helper->layout()->disableLayout();
		$userMapper = new Application_Model_UserMapper();
		$obAuthUser = Application_Model_AuthUser::getAuthUser();
		
		$alleLogs = array();
		$arrUser = array();

		array_push($arrUser, $obAuthUser);

		$arrUsernames = explode(',', $this->getRequest()->getParam('names'));
		if ($arrUsernames[0] != ""){
			foreach ($arrUsernames as $name) {
				$obUser = $userMapper->getOneByUsername($name);
				$arrUserLogs = $obUser->getLogs();
				if(is_object($obUser->getFirstLog())){
					array_push($arrUser, $obUser);
					foreach($arrUserLogs as $log){
						array_push($alleLogs, $log);
					}
				}
			}
		}
		
		foreach ($obAuthUser->getLogs() as $log) {
			array_push($alleLogs, $log);
		}
		$this->view->arrUser = $arrUser;
		$this->view->obUser = $obAuthUser;
	}
	

}