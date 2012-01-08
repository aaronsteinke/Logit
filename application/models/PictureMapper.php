<?php

class Application_Model_PictureMapper
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
        	$this->setDbTable('Application_Model_DbTable_Picture');
        }
        
        return $this->_dbTable;
    }
  
    public function create($pic_ident, $user_id, $lat_ns, $lat, $long_ns, $long, $height, $date_uploaded, $date_shot){
    	   	
    	$data = array(
    		'pic_ident'=> $pic_ident,
    		'user_id' => $user_id,
    		'lat_ns' => $lat_ns,
    		'lat' => $lat,
    		'long_ns' => $long_ns,
    		'long' => $long,
    		'height' => $height,
    		'date_uploaded' => $date_uploaded,
    		'date_shot' => $date_shot,
    	);
    	
    	$strWhereClause = $this->getDbTable()
    						   ->insert($data);			   

    	return true;
    }
    
	public function getLogsForUser($idUser, $dateBegin = NULL, $dateEnd = NULL, $limit = NULL){
    	$db = $this->getDbTable()->getAdapter();
    	$sql = ('	SELECT 	*
					FROM 	pic 
					WHERE 	user_id = :idUser 
					');
    	if (isset($dateBegin) && isset($dateEnd)){
    		$sql .= ' 	AND date_shot < :dateEnd 
    					AND date_shot > :dateBegin	';
    	}
    	
    	$sql .= ' 	ORDER BY date_shot DESC ';
    	
    	// binding nachlesen und einsetzen
    	if (isset($limit)){
    		$sql .= '	LIMIT ' . $limit . ' ';
    	}
    	
    	$stmt = new Zend_Db_Statement_Pdo($db, $sql);
    	$stmt->bindParam(':idUser', $idUser);
		
    	if (isset($dateBegin) && isset($dateEnd)){
			$stmt->bindParam(':dateEnd', $dateEnd);
			$stmt->bindParam(':dateBegin', $dateBegin);
    	}
    	
    	/*if (isset($limit)){
    		$stmt->bindParam(':limit', $limit);
    	}*/
    	
    	$stmt->execute();
    	$resultSet = $stmt->fetchAll();
    	return $this->createObjektArr($resultSet);

	}
	
	public function getLogsByUsername($username, $dateBegin = NULL, $dateEnd = NULL, $limit = NULL){
    	$db = $this->getDbTable()->getAdapter();
    	$sql = ('	SELECT 	p.*
					FROM 	pic p,
							user u
					WHERE 	u.username = :username
					AND 	u.id = p.user_id
					');
    	if (isset($dateBegin) && isset($dateEnd)){
    		$sql .= ' 	AND date_shot < :dateEnd 
    					AND date_shot > :dateBegin	';
    	}
    	
    	$sql .= ' 	ORDER BY date_shot DESC ';
    	
    	// binding nachlesen und einsetzen
    	if (isset($limit)){
    		$sql .= '	LIMIT ' . $limit . ' ';
    	}
    	
    	$stmt = new Zend_Db_Statement_Pdo($db, $sql);
    	$stmt->bindParam(':username', $username);
		
    	if (isset($dateBegin) && isset($dateEnd)){
			$stmt->bindParam(':dateEnd', $dateEnd);
			$stmt->bindParam(':dateBegin', $dateBegin);
    	}
    	
    	/*if (isset($limit)){
    		$stmt->bindParam(':limit', $limit);
    	}*/
    	
    	$stmt->execute();
    	$resultSet = $stmt->fetchAll();
    	return $this->createObjektArr($resultSet);

	}
	
	public function getNumberOfLogsForUser($idUser){
		$db = $this->getDbTable()->getAdapter();
		$sql = '	SELECT COUNT(*) as number_of_logs
					FROM pic 
					WHERE user_id = :idUser
					';
		$stmt = new Zend_Db_Statement_Pdo($db, $sql);
    	$stmt->bindParam(':idUser', $idUser);
    	
    	$stmt->execute();
    	$resultSet = $stmt->fetchAll();
    	return $resultSet[0]['number_of_logs'];
	}
	
	public function getFirstOrLastLogForUser($idUser, $first = true ){
		$db = $this->getDbTable()->getAdapter();
		$sql = '	SELECT *
					FROM pic 
					WHERE user_id = :idUser
					';
		if ($first){
			$sql .= ' ORDER BY date_shot DESC LIMIT 1';
		} else {
			$sql .= ' ORDER BY date_shot ASC LIMIT 1';
		}
		
		$stmt = new Zend_Db_Statement_Pdo($db, $sql);
    	$stmt->bindParam(':idUser', $idUser);
    	
    	$stmt->execute();
    	$resultSet = $stmt->fetchAll();
    	$arrPics = $this->createObjektArr($resultSet);
    	
		if (empty($arrPics)) {
    		return 0;
    	} else {
    		return $arrPics[0];
    	}
		
	}
	
   	private function createObjekt($result){
	    	if ($result == null){
	    		return false;
	    	}
	    	if (is_object($result)){
		    	$obPicture = new Application_Model_Picture(
		            $result->id, 
		            $result->pic_ident,
		            $result->user_id, 
		            $result->lat_ns,
		            $result->lat,
		            $result->long_ns,
		            $result->long,
		            $result->height, 
		            $result->date_uploaded,
		            $result->date_shot 
				);
	    	} else {
	    		$obPicture = new Application_Model_Picture(
		            $result['id'], 
		            $result['pic_ident'],
		            $result['user_id'],
		            $result['lat_ns'], 
		            $result['lat'],
		            $result['long_ns'],
		            $result['long'],
		            $result['height'],
		            $result['date_uploaded'],
		            $result['date_shot'] 
				);
	    	}
			return $obPicture;
	    }
	    
	    private function createObjektArr($resultSet){
	    	$arrPictures = array();
			foreach ($resultSet as $row) {
	            $arrPictures[] = $this->createObjekt($row);
	        }
	        return $arrPictures;
	    }
    
}