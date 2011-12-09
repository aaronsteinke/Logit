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
    
    
    public function createFriend($idUser, $idFriend, $follow = true) {
    	$db = $this->getDbTable()->getAdapter();
		$sql = 'INSERT INTO user_friends (	id_user,
											id_friend,
											follow) 
									VALUES (:idUser,
											:idFriend,
											:follow )';

		$stmt = new Zend_Db_Statement_Pdo($db, $sql);
		$stmt->bindParam(':idFriend', $idFriend);
		$stmt->bindParam(':idUser', $idUser);
		$stmt->bindParam(':follow', $follow);
		
		$stmt->execute();
		echo mysql_error();
    }
    
	
    public function deleteFriend($idUser, $idFriend){
    	$db = $this->getDbTable()->getAdapter();
		$sql = 'DELETE
				From user_friends
				WHERE id_user = :idUser
				AND id_friend = :idFriend ';

		$stmt = new Zend_Db_Statement_Pdo($db, $sql);
		$stmt->bindParam(':idFriend', $idFriend);
		$stmt->bindParam(':idUser', $idUser);
		
		$stmt->execute();
    }
    
    
    // wenn funktion nicht mehr benötigt wird bitte löschen
    public function getAllUsers(){
    	$db = $this->getDbTable()->getAdapter();
    	
    	$sql = ('	SELECT 	*
					FROM 	user 	');
    	
    	
    	$stmt = new Zend_Db_Statement_Pdo($db, $sql);
    	$stmt->execute();
    	
    	$resultSet = $stmt->fetchAll();
    	return $this->createObjektArr($resultSet);

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
	
	
	public function getOneById($id){
    	$db = $this->getDbTable()->getAdapter();
    	
    	$sql = ('	SELECT 	*
					FROM 	user 
					WHERE 	id = :id	');
    	
    	
    	$stmt = new Zend_Db_Statement_Pdo($db, $sql);
    	$stmt->bindParam(':id', $id);
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
    
	
    public function getFriendsForUser($idUser){
    	$db = $this->getDbTable()->getAdapter();
		 
		$sql = ('	SELECT 	f.*
					FROM 	user f, 
							user_friends u 
					WHERE 	u.id_user = :idUser
					AND 	f.id = u.id_friend	');
		 
		 
		$stmt = new Zend_Db_Statement_Pdo($db, $sql);
		$stmt->bindParam(':idUser', $idUser);
		$stmt->execute();
		 
		$resultSet = $stmt->fetchAll();
		$arrRestaurants = $this->createObjektArr($resultSet);
		return $arrRestaurants;
    }
	
	public function addFacebookData ($user_id, $data)
	{
		$db = $this->getDbTable()->getAdapter();
		$db->update('user', $data, "id = $user_id");
	}
    
	
	
	// noch nicht fertig
	private function searchUserByName( $name ){
    	$db = $this->getDbTable()->getAdapter();
		 
		$sql = ('	SELECT 	*
					FROM 	user 
					WHERE 	u.id_user LIKE % :name %	');
		 
		 
		$stmt = new Zend_Db_Statement_Pdo($db, $sql);
		$stmt->bindParam(':name', $name);
		$stmt->execute();
		 
		$resultSet = $stmt->fetchAll();
		$arrRestaurants = $this->createObjektArr($resultSet);
		return $arrRestaurants;
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