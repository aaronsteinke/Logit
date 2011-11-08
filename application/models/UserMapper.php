<?php

class Application_Model_UserMapper
{
	protected $_dbTable;

    public function setDbTable($dbTable)
    {
    	if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        
        $this->_dbTable = $dbTable;
        return $this;
    }
	
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
        	$this->setDbTable('Application_Model_DbTable_User');
        }
        
        return $this->_dbTable;
    }
  
    public function create($userName, $firstName = false, $lastName = false, $password){
    	/*
    	if ( $this->getOneByUserName($userName) != false){
    		return false;
    	}
    	*/
    	
    	$pathToPic = 'da solls hin';
    	$email = 'testmail';
    	$hits = 2;
    	
    	
    	$data = array(
    		'username'=> $userName,
    		'lastname' => $lastName,
    		'firstname' => $firstName,
    		'sex' => 1,
    		'profilepic' => $pathToPic,
    		'password' => $password,
    		'email' => $email,
    		'reg_time' => date('Y-m-d H:i:s'),
    		'last_login' => date('Y-m-d H:i:s'),
    		'hits' => $hits
    	);
    	
    	$strWhereClause = $this->getDbTable()
    						   ->insert($data);
    	return true;
		//return $this->getOneByUserName($userName);
    }
    /*
    
   	private function createObjekt($result){
	    	if ($result == null){
	    		return false;
	    	}
	    	if (is_object($result)){
		    	$obUser = new Application_Model_User(
		            $result->id, 
		            $result->username, 
		            $result->date_created,
		            $result->firstname,
		            $result->lastname
				);
	    	} else {
	    		$obUser = new Application_Model_User(
		            $result['id'], 
		            $result['username'], 
		            $result['date_created'],
		            $result['firstname'],
		            $result['lastname']
				);
	    	}
			return $obUser;
	    }
	    
	    private function createObjektArr($resultSet){
	    	$arrUsers = array();
			foreach ($resultSet as $row) {
	            $arrUsers[] = $this->createObjekt($row);
	        }
	        return $arrUsers;
	    }
    */
}