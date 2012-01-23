<?php

class Application_Model_Pic2EventMapper {
	protected $_dbTable;

	public function setDbTable($dbTable)
	{
		if (is_string($dbTable)) {
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract) {
			throw new Exception('Invalid table data gateway provided');
		}

		$this -> _dbTable = $dbTable;
		return $this;
	}

	public function getDbTable()
	{
		if (null === $this -> _dbTable) {
			$this -> setDbTable('Application_Model_DbTable_Pic2event');
		}

		return $this -> _dbTable;
	}

	public function create($event_id, $pic_id)
	{

		$data = array(
				'event_id' => $event_id,
				'pic_id' => $pic_id
		);

		$strWhereClause = $this -> getDbTable() -> insert($data);

		return true;
	}

	public function checkExistance($event_id, $pic_id)
	{
		$db = $this -> getDbTable() -> getAdapter();
		$sql = '	SELECT *
					FROM pic2event 
					WHERE event_id = :idEvent
					AND pic_id = :idPic
					LIMIT 1
					';
		$stmt = new Zend_Db_Statement_Pdo($db, $sql);
		$stmt -> bindParam(':idEvent', $event_id);
		$stmt -> bindParam(':idPic', $pic_id);
		//print_r($stmt);
		$stmt -> execute();
		$resultSet = $stmt -> fetchAll();
		return $resultSet;
	}

}
?>