<?php

class Application_Model_AuthUser {

	public static function getAuthUser(){
		$auth = Zend_Auth::getInstance();
		$users = new Application_Model_UserMapper();
		return $users->getOneByUsername($auth->getIdentity());
	}
	
}