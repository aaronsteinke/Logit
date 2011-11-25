<?php

class Application_Model_Picture {

	protected $_id;
	protected $_picIdent;
	protected $_userId;
	protected $_latNs;
	protected $_lat;
	protected $_longNs;
	protected $_long;
	protected $_height;
	protected $_dateUploaded;
	protected $_dateShot;

	public function __construct($id, $picIdent, $userId, $latNs, $lat, $longNs, $long, $height, $dateUploaded, $dateShot) {
		$this -> _id = $id;
		$this -> _picIent = $picIdent;
		$this -> _userId = $userId;
		$this -> _latNs = $latNs;
		$this -> _lat = $lat;
		$this -> _longNs = $longNs;
		$this -> _long = $long;
		$this -> _height = $height;
		$this -> _dateUploaded = $dateUploaded;
		$this -> _dateShot = $dateShot;
	}

	public function getId() {
		return $this -> _id;
	}

	public function getPicIdent() {
		return $this -> _userName;
	}

	public function getUser() {
		$userMapper = new Application_Model_UserMapper();
		return $userMapper -> getOneById($this -> _userId);
	}

	public function getLatNs() {
		return $this -> _latNs;
	}

	public function getLat() {
		return $this -> _lat;
	}

	public function getLongNs() {
		return $this -> _longNs;
	}

	public function getLong() {
		return $this -> _long;
	}

	public function getHeight() {
		return $this -> _height;
	}

	public function getDateUploaded() {
		return $this -> _dateUploaded;
	}

	public function getDateShot() {
		return $this -> _dateShot;
	}

}
