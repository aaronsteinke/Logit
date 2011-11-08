<?php
class Application_Model_Adapter_Authdb extends Zend_Auth_Adapter_DbTable {
	
	public $test = 'test';
	
	public function __construct(){
		$reg = new Zend_Registry();
		parent::__construct($reg->dbAdapter);
		$this	->setTableName('user')
				->setIdentityColumn('username')
				->setCredentialColumn('password')
				->setCredentialTreatment('MD5(?)');
	}
}