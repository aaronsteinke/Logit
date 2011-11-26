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
  
    public function create($userName, $eMail, $password, $birthday){
    	/*
    	if ( $this->getOneByUserName($userName) != false){
    		return false;
    	}
    	*/
    	
    	$pathToPic = 'nicht vorhanden!';
    	$hits = 0;
    	$lastName = 'test';
    	$firstName = 'test';
    	
    	
    	$data = array(
    		'username'=> $userName,
    		'lastname' => $lastName,
    		'firstname' => $firstName,
    		'sex' => 1,
    		'profilepic' => $pathToPic,
    		'password' => $password,
    		'email' => $eMail,
    		'reg_time' => date('Y-m-d H:i:s'),
    		'last_login' => date('Y-m-d H:i:s'),
    		'hits' => $hits,
    		'birthday' => $birthday
    	);
    	
    	$strWhereClause = $this->getDbTable()
    						   ->insert($data);			   

    	return true;
		//return $this->getOneByUserName($userName);
    }
    
    public function getOneByUsername($username){
    	$db = $this->getDbTable()->getAdapter();
    	
    	$sql = ('	SELECT 	*
					FROM 	user 
					WHERE 	username = :username	');
    	
    	
    	$stmt = new Zend_Db_Statement_Pdo($db, $sql);
    	$stmt->bindParam(':username', $username);
    	$stmt->execute();
    	
    	$resultSet = $stmt->fetchAll();
    	$arrUsers = $this->createObjektArr($resultSet);

    	if (empty($arrUsers)) {
    		return 0;
    	} else {
    		return $arrUsers[0];
    	}
    	
    }
    
	public function getOneByEMail($EMail){
    	$db = $this->getDbTable()->getAdapter();
    	
    	$sql = ('	SELECT 	*
					FROM 	user 
					WHERE 	email = :email	');
    	
    	
    	$stmt = new Zend_Db_Statement_Pdo($db, $sql);
    	$stmt->bindParam(':email', $EMail);
    	$stmt->execute();
    	
    	$resultSet = $stmt->fetchAll();
    	$arrUsers = $this->createObjektArr($resultSet);
    	
		if (empty($arrUsers)) {
    		return 0;
    	} else {
    		return $arrUsers[0];
    	}
    }
    
   	private function createObjekt($result){
	    	if ($result == null){
	    		return false;
	    	}
	    	if (is_object($result)){
		    	$obUser = new Application_Model_User(
		            $result->id, 
		            $result->username, 
		            $result->lastname,
		            $result->firstname,
		            $result->sex,
		            $result->profilepic, 
		            $result->email, 
		            $result->reg_time,
		            $result->last_login,
		            $result->hits,
		            $result->birthday
				);
	    	} else {
	    		$obUser = new Application_Model_User(
		            $result['id'], 
		            $result['username'], 
		            $result['lastname'],
		            $result['firstname'],
		            $result['sex'],
		            $result['profilepic'], 
		            $result['email'], 
		            $result['reg_time'],
		            $result['last_login'],
		            $result['hits'],
		            $result['birthday']
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
    
}