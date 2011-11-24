<?php

class Application_Model_Picture {

	protected $_id;
	protected $_pic_ident;
	protected $_lat;
	protected $_long;
	protected $_date_uploaded;
	protected $_date_shot;



	public function __construct( 	$id, $picIdent, $lat, $long, $dateUploaded, $dateShot ) {
		$this->_id = $id;
		$this->_pic_ident = $picIdent;
		$this->_lat = $lat;
		$this->_long = $long;
		$this->_date_uploaded = $dateUploaded;
		$this->_date_shot = $dateShot;
	}

	public function getId() {
		return $this->_id;
	}

	public function getPicIdent() {
		return $this->_userName;
	}

	public function getLat(){
		return $this->_lat;
	}

	public function getLong(){
		return $this->_long;
	}

	public function getDateUploaded(){
		return $this->_date_uploaded;
	}

	public function getDateShot(){
		return $this->_date_shot;
	}

	public function getEmail() {
		return $this->_eMail;
	}
}