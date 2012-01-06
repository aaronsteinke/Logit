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
		$user = Application_Model_AuthUser::getAuthUser();
		$this->view->arrLogs = $user->getLogs();
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
		
		$authUser = Application_Model_AuthUser::getAuthUser();
		
		$startDate = 	$this->getRequest()->getParam('first-date') . ' ' .  
						$this->getRequest()->getParam('first-time');
		
		$endDate = 	$this->getRequest()->getParam('second-date') . ' ' . 
					$this->getRequest()->getParam('second-time');
			
		$limit = $this->getRequest()->getParam('number-of-images');
		
		$pictures = new Application_Model_PictureMapper();
		$this->view->arrLogs = $pictures->getLogsForUser($authUser->getId(), $startDate, $endDate, $limit);
		
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

}