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
	protected $_gcal_calendar_id;


	public function __construct( 	$id, $userName, $lastName, $firstName, $sex,
									$profilePic, $eMail, $regTime, $lastLogin, $hits, $birthday, $gcal_calendar_id) {
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
		$this->_gcal_calendar_id = $gcal_calendar_id;
	}

	public function getId() {
		return $this->_id;
	}

	public function getUserName() {
		return $this->_userName;
	}
	
	public function getUserCalendar() {
		return $this->_gcal_calendar_id;
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

	public function getLogs(){
		// hier und im mapper fehlen noch Parameter zur eingrenzung
		$logs = new Application_Model_PictureMapper();
		return $logs->getLogsForUser($this->_id);
	}
	
	public function getFristLog(){
		$Pictures = new Application_Model_PictureMapper();
		return $Pictures->getFirstOrLastLogForUser($this->_id, 0);
	}
	
	public function getLastLog(){
		$Pictures = new Application_Model_PictureMapper();
		return $Pictures->getFirstOrLastLogForUser($this->_id, 1);
	}
	
	public function getNumberOfLogs(){
		$Pictures = new Application_Model_PictureMapper();
		return $Pictures->getNumberOfLogsForUser($this->_id);
	}
	
	public function follow($idUser){
		$users = new Application_Model_UserMapper();
		$users->createFriend($this->_id, $idUser, 1);
	}
	
	public function unfollow($idUser){
		$users = new Application_Model_UserMapper();
		$users->deleteFriend($this->_id, $idUser);
	}
	
	public function addData($user_id, $data){
		$users = new Application_Model_UserMapper();
		$users->addData($user_id, $data);
	}
	
	public function getFriends(){
		$users = new Application_Model_UserMapper();
		return $users->getFriendsForUser($this->_id);
	}
	
	public function getGcal_Calendar(){
		$users = new Application_Model_UserMapper();
		return $users->getFriendsForUser($this->_id);
	}
	/*
	 public function getDateCreated()
	 {
		$dateCreated = date('d.m.Y',strtotime($this->_dateCreated));
		return $dateCreated;
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