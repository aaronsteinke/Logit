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
  
    public function create($pic_ident, $lat, $long, $date_uploaded, $date_shot){
    	   	
    	$data = array(
    		'pic_ident'=> $pic_ident,
    		'lat' => $lat,
    		'long' => $long,
    		'date_uploaded' => $date_uploaded,
    		'date_shot' => $date_shot,
    	);
    	
    	$strWhereClause = $this->getDbTable()
    						   ->insert($data);			   

    	return true;
    }
    
   	private function createObjekt($result){
	    	if ($result == null){
	    		return false;
	    	}
	    	if (is_object($result)){
		    	$obPicture = new Application_Model_Picture(
		            $result->id, 
		            $result->pic_ident, 
		            $result->lat,
		            $result->long,
		            $result->date_uploaded,
		            $result->date_shot 
				);
	    	} else {
	    		$obPicture = new Application_Model_Picture(
		            $result['id'], 
		            $result['pic_ident'], 
		            $result['lat'],
		            $result['long'],
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