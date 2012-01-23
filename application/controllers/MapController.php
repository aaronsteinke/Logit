<?php

class MapController extends Zend_Controller_Action
{

    public function init()
    {
    	
    }

   
	public function indexAction()
	{
		$authUser = Application_Model_AuthUser::getAuthUser();
		$this->view->obAuthUser = $authUser;
	}

	
	public function getJsonAction(){
		$this->_helper->layout()->disableLayout();
		$userMapper = new Application_Model_UserMapper();
		$obAuthUser = Application_Model_AuthUser::getAuthUser();
		
		$alleLogs = array();
		
		$startDate = 	$this->getRequest()->getParam('first-date') . ' ' .  
						$this->getRequest()->getParam('first-time');
		
		$endDate = 	$this->getRequest()->getParam('second-date') . ' ' . 
					$this->getRequest()->getParam('second-time');

		$arrUsernames = explode(',', $this->getRequest()->getParam('usernames'));
		if ($arrUsernames[0] != ""){
			foreach ($arrUsernames as $name) {
				$obUser = $userMapper->getOneByUsername($name);
				$arrUserLogs = $obUser->getLogs($startDate, $endDate);
				foreach($arrUserLogs as $log){
					array_push($alleLogs, $log);
				}
			}
		}
		
		foreach ($obAuthUser->getLogs($startDate, $startDate) as $log) {
			array_push($alleLogs, $log);
		}
		
		$this->view->arrLogs = $alleLogs;
		
	}
	
	public function getImagesForTimelineAction(){
		$this->_helper->layout()->disableLayout();		
		
		$startDate = 	$this->getRequest()->getParam('first-date') . ' ' .  
						$this->getRequest()->getParam('first-time');
		
		$endDate = 	$this->getRequest()->getParam('second-date') . ' ' . 
					$this->getRequest()->getParam('second-time');
			
		$limit = $this->getRequest()->getParam('number-of-images');
		
		$pictures = new Application_Model_PictureMapper();
		$arrLogs = $pictures->getLogsByUsername(
						$this->getRequest()->getParam('username'), 
						$startDate, 
						$endDate
					);
		$faktor = count($arrLogs) / $limit;
		$arrLogsSmal = array();
		for ($i=0; $i < $limit; $i++) {
			if ($faktor != 0){ 
				array_push($arrLogsSmal, $arrLogs[floor($faktor) * $i]);
			}
		}
		$this->view->arrLogs = $arrLogs;
		
	}
	
	private function getFormedDateTimeString($date, $hour, $minute, $second){
		return $date . " " . $hour . ":" . $minute . ":" . $second;
	}
	
	public function getUserForTimelineAction(){
		$this->_helper->layout()->disableLayout();
	}
	
	public function testAction(){
		$this->_helper->viewRenderer->setNoRender(true);
		$authUser = Application_Model_AuthUser::getAuthUser();
	}
	
	public function getTimelineAction(){
		$this->_helper->layout()->disableLayout();
		$userMapper = new Application_Model_UserMapper();
		$authUser = Application_Model_AuthUser::getAuthUser();
		if($this->getRequest()->getParam('username') == $authUser->getUsername()){
			$this->view->obUser = $authUser;
		} else {
			$this->view->obUser = $userMapper->getFriendByUsername($authUser->getId(), $this->getRequest()->getParam('username'));
		}
	}

}