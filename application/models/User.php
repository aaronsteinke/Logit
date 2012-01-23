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
	
	protected $_mapper;

	public function __construct($id, $userName, $lastName, $firstName, $sex, $profilePic, $eMail, $regTime, $lastLogin, $hits, $birthday, $gcal_calendar_id)
	{
		$this -> _id = $id;
		$this -> _userName = $userName;
		$this -> _lastName = $lastName;
		$this -> _firstName = $firstName;
		$this -> _sex = $sex;
		$this -> _profilePic = $profilePic;
		$this -> _eMail = $eMail;
		$this -> _regTime = $regTime;
		$this -> _lastLogin = $lastLogin;
		$this -> _hits = $hits;
		$this -> _birthday = $birthday;
		$this -> _gcal_calendar_id = $gcal_calendar_id;
	}

	public function updateDb()
	{
		$this->getMapper()->updateUser($this->_id, $this->_userName, $this->_lastName, $this->_firstName, $this->_sex, $this->_profilePic, $this->_eMail, $this->_regTime, $this->_lastLogin, $this->_hits, $this->_birthday, $this->_gcal_calendar_id);
	}

	public function getMapper()
	{
		if ($this -> _mapper === null) {
			$this -> _mapper = new Application_Model_UserMapper();
		}
		return $this -> _mapper;
	}

	public function getId()
	{
		return $this -> _id;
	}

	public function getUserName()
	{
		return $this -> _userName;
	}
	
	public function setUserName($username)
	{
		$this -> _userName = $username;
	}

	public function getUserCalendar()
	{
		return $this -> _gcal_calendar_id;
	}

	public function getFirstName()
	{
		return $this -> _firstName;
	}
	
	public function setFirstName($firstname)
	{
		$this -> _firstName = $firstname;
	}

	public function getLastName()
	{
		return $this -> _lastName;
	}

	public function setLastName($lastname)
	{
		$this -> _lastName = $lastname;
	}

	public function getSex()
	{
		return $this -> _sex;
	}

	public function getProfilePic()
	{
		return $this -> _profilePic;
	}

	public function getEmail()
	{
		return $this -> _eMail;
	}
	
	public function setEmail($email)
	{
		$this -> _eMail = $email;
	}

	public function getRegTime()
	{
		return $this -> _regTime;
	}

	public function getLastLogin()
	{
		return $this -> _lastLogin;
	}

	public function getBirthday()
	{
		return $this -> _birthday;
	}
	
	public function getGcalId()
	{
		return $this -> _gcal_calendar_id;
	}
	
	public function setGcalId($gcalId)
	{
		$this -> _gcal_calendar_id = $gcalId;
	}

	public function getLogs($startDate = null, $endDate = null)
	{
		$arrLogs = array();
		$logMapper = new Application_Model_PictureMapper();
		if($startDate == null && $endDate == null){
			$arrLogs = $logMapper -> getLogsForUser($this -> _id);
		} else {
			$arrLogs = $logMapper->getLogsForUser($this->_id, $startDate, $endDate);
		}
		// hier und im mapper fehlen noch Parameter zur eingrenzung
		return $arrLogs;
	}

	public function getFirstLog()
	{
		$Pictures = new Application_Model_PictureMapper();
		return $Pictures -> getFirstOrLastLogForUser($this -> _id, 0);
	}

	public function getLastLog()
	{
		$Pictures = new Application_Model_PictureMapper();
		return $Pictures -> getFirstOrLastLogForUser($this -> _id, 1);
	}

	public function getNumberOfLogs()
	{
		$Pictures = new Application_Model_PictureMapper();
		return $Pictures -> getNumberOfLogsForUser($this -> _id);
	}

	public function getNumberOfEvents()
	{
		$Events = new Application_Model_EventsMapper();
		return $Events -> getNumberOfEventsForUser($this -> _id);
	}

	public function follow($idUser)
	{
		$users = new Application_Model_UserMapper();
		$users -> createFriend($this -> _id, $idUser, 1);
	}

	public function unfollow($idUser)
	{
		$users = new Application_Model_UserMapper();
		$users -> deleteFriend($this -> _id, $idUser);
	}

	public function addData($user_id, $data)
	{
		$users = new Application_Model_UserMapper();
		$users -> addData($user_id, $data);
	}

	public function getFriends()
	{
		$users = new Application_Model_UserMapper();
		return $users -> getFriendsForUser($this -> _id);
	}

	public function getNumberOfFriends()
	{
		$users = new Application_Model_UserMapper();
		return $users -> getNumberOfFriends($this -> _id);
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
