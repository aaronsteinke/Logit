<?php

class MapController extends Zend_Controller_Action
{

    public function init()
    {
       
    }

   
	public function indexAction()
	{
		
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
<<<<<<< HEAD
	}

	public function getImagesForTimelineAction(){
		$this->_helper->layout()->disableLayout();		
		$this->view->anzahlBilder = $this->getRequest()->getParam("number-of-images");
	}
=======
	}
	
>>>>>>> master
}