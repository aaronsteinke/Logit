<?php

class MapController extends Zend_Controller_Action
{

    public function init()
    {
       
    }

   
	public function indexAction()
	{
		
	}
	
	public function bilderAction(){
		echo 'hier steht php code';
	}
	
	public function getImagesForTimelineAction(){
		$this->_helper->layout()->disableLayout();		
		$this->view->anzahlBilder = $this->getRequest()->getParam("number-of-images");
	}
}