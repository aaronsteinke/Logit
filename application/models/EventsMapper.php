<?php

class Application_Model_EventsMapper
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
        	$this->setDbTable('Application_Model_DbTable_Events');
        }
        
        return $this->_dbTable;
    }

	public function create($gcal_id,$event_title, $event_start, $event_end, $user_id){
    	
    	$data = array(
    		'gcal_id'			=> $gcal_id,
    		'event_title' 		=> $event_title,
    		'event_start'		=> $event_start,
    		'event_end'			=> $event_end,
    		'user_id'			=> $user_id
    	);
    	
    	$strWhereClause = $this->getDbTable()
    						   ->insert($data);			   

    	return true;
    }
	
		public function getOneByGcal_id($gcal_id){
    	$db = $this->getDbTable()->getAdapter();
    	
    	$sql = ('	SELECT 	*
					FROM 	events 
					WHERE 	gcal_id = :gcal_id	');
    	
    	
    	$stmt = new Zend_Db_Statement_Pdo($db, $sql);
    	$stmt->bindParam(':gcal_id', $gcal_id);
    	$stmt->execute();
    	
    	$resultSet = $stmt->fetchAll();
    	$arrEvents = $this->createObjektArr($resultSet);
    	
		if (empty($arrEvents)) {
    		return 0;
    	} else {
    		return $arrEvents[0];
    	}
    }
		
	private function createObjekt($result){
	    	if ($result == null){
	    		return false;
	    	}
	    	if (is_object($result)){
		    	$obUser = new Application_Model_Events(
		            $result->id, 
		            $result->gcal_id,
		            $result->event_title,
		            $result->event_start,
		            $result->event_end,
		            $result->user_id 
				);
	    	} else {
	    		$obUser = new Application_Model_Events(
		            $result['id'], 
		            $result['gcal_id'], 
		            $result['event_title'],
		            $result['event_start'],
		            $result['event_end'],
		            $result['user_id']		
				);
	    	}
			return $obUser;
	    }
	
	private function createObjektArr($resultSet){
	    	$arrEvents = array();
			foreach ($resultSet as $row) {
	            $arrEvents[] = $this->createObjekt($row);
	        }
	        return $arrEvents;
	    }

	
}
?>