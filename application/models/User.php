<?php

class Application_Model_User {

	protected $_id;
	protected $_userName;
	protected $_lastName;
	protected $_firstName;
	protected $_sex;
	protected $_profilePic;
	protected $_eMail;
	protected $_regTime;
	protected $_lastLogin;
	protected $_hits;
	protected $_birthday;


	public function __construct( 	$id, $userName, $lastName, $firstName, $sex,
	$profilePic, $eMail, $regTime, $lastLogin, $hits, $birthday ) {
		$this->_id = $id;
		$this->_userName = $userName;
		$this->_lastName = $lastName;
		$this->_firstName = $firstName;
		$this->_sex = $sex;
		$this->_profilePic = $profilePic;
		$this->_eMail = $eMail;
		$this->_regTime = $regTime;
		$this->_lastLogin = $lastLogin;
		$this->_hits = $hits;
		$this->_birthday = $birthday;
	}

	public function getId() {
		return $this->_id;
	}

	public function getUserName() {
		return $this->_userName;
	}

	public function getFirstName(){
		return $this->_firstName;
	}

	public function getLastName(){
		return $this->_lastName;
	}

	public function getSex(){
		return $this->_sex;
	}

	public function getProfilePic(){
		return $this->_profilePic;
	}

	public function getEmail() {
		return $this->_eMail;
	}

	public function getRegTime() {
		return $this->_regTime;
	}

	public function getLastLogin(){
		return $this->_lastLogin;
	}

	public function getBirthday(){
		return $this->_birthday;
	}

	/*
	 public function getDateCreated()
	 {
		$dateCreated = date('d.m.Y',strtotime($this->_dateCreated));
		return $dateCreated;
		}

		public function getMyRestaurants(){
		$obRestaurants = new Application_Model_RestaurantMapper();
		return $obRestaurants->getMyRestaurantsByIdUser($this->_id);
		}

		public function getInvitations($limit = false){
		$obEvents = new Application_Model_EventMapper();
		return $obEvents->getInvitationsForUser($this->_id, $limit);
		}

		public function getEvents($limit = false){
		$obEvents = new Application_Model_EventMapper();
		return $obEvents->getEventsForUser($this->_id, $limit);
		}


		public function acceptEvent($obEvent){
		$eventMapper = new Application_Model_EventMapper();
		$eventMapper->accept($obEvent->getId(), $this->_id);
		}

		public function update($firstName, $lastName)
		{
		$userMapper = new Application_Model_UserMapper();
		$userMapper->update($this->_id, $this->_userName, $firstName, $lastName);

		$this->_firstName = $firstName;
		$this->_lastName = $lastName;
		}
		*/
}