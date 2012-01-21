<?php

class SettingsController extends Zend_Controller_Action {
	public function init()
	{

	}

	public function indexAction()
	{
		$this -> _helper -> layout() -> disableLayout();
		$this -> view -> user = Application_Model_AuthUser::getAuthUser();
	}

	public function updateProfileAction()
	{

	}

}
