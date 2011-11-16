<?php
class Timelinecontroller extends Zend_Controller_Action {
	
	public function init()
    {
       
    }

   
	public function indexAction()
	{
		$this->_helper->viewRenderer->setNoRender(true);
		echo '<a href="/ajax/logout">logout</a>';
	}
	
}