<?php

class MapController extends Zend_Controller_Action
{

    public function init()
    {
       
    }

   
	public function indexAction()
	{
		$this->_helper->viewRenderer->setNoRender(true);
		echo '<a href="/index/logout">logout</a>';
	}
	
	public function bilderAction(){
		echo 'hier steht php code';
	}
	
	
	
}