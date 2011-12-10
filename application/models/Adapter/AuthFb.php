<?php
class Application_Model_Adapter_AuthFb extends Zend_Auth_Adapter_DbTable {
	
	public function __construct(){
		$reg = new Zend_Registry();
		parent::__construct($reg->dbAdapter);
		$this	->setTableName('user')
				->setIdentityColumn('username')
				->setCredentialColumn('facebook_access_token');
	}
}