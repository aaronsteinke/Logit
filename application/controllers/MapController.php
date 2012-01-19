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


		$arrUsernames = explode(',', $this->getRequest()->getParam('usernames'));
		if ($arrUsernames[0] != ""){
			foreach ($arrUsernames as $name) {
				$obUser = $userMapper->getOneByUsername($name);
				$arrUserLogs = $obUser->getLogs();
				foreach($arrUserLogs as $log){
					array_push($alleLogs, $log);
				}
			}
		}
		
		foreach ($obAuthUser->getLogs() as $log) {
			array_push($alleLogs, $log);
		}
		
		$this->view->arrLogs = $alleLogs;
		
		/*
		$arrLogs = $user->getLogs();
		$arrJsonObjs = array();
		foreach ($arrLogs as $objLog){
			array_push($arrJsonObjs, 
				array( 	'latitude' => $objLog->getLat(),
						'longitude' => $objLog->getLong(),
						'image' => 'daten/pics/orig/' . $objLog->getPicIdent() . '.jpg'
				)
			);
		}
		$jsonData = Zend_Json::encode($arrJsonObjs);
		echo $jsonData;
		*/
	}
	
	
	public function getImagesForTimelineAction(){
		$this->_helper->layout()->disableLayout();		
		
		$startDate = 	$this->getRequest()->getParam('first-date') . ' ' .  
						$this->getRequest()->getParam('first-time');
		
		$endDate = 	$this->getRequest()->getParam('second-date') . ' ' . 
					$this->getRequest()->getParam('second-time');
			
		$limit = $this->getRequest()->getParam('number-of-images');
		
		$pictures = new Application_Model_PictureMapper();
		$this->view->arrLogs = $pictures->getLogsByUsername($this->getRequest()->getParam('username'), $startDate, $endDate, $limit);
		
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