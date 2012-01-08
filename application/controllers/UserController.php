<?php

class UserController extends Zend_Controller_Action {

	public function init() {
		/*$auth = Zend_Auth::getInstance();
		if (!$auth -> hasIdentity()) {
			$this -> _redirect(index);
		}*/
	}

	public function indexAction() {
		echo '<h3>Hier kann man einstellen wem man folgt und wem nicht!</h3>';
		$users = new Application_Model_UserMapper();
		$arrAllUsers = $users->getAllUsers();
		
		$authUser = Application_Model_AuthUser::getAuthUser();
		$arrFriends = $authUser->getFriends();
		
		foreach ($arrAllUsers as $obUser){
			if($obUser->getId() != $authUser->getId()){
				$isFriend = false;
				foreach ($arrFriends as $obFriend){
					if ($obUser->getId() == $obFriend->getId()) {
						$isFriend = true;
					}
				}
				if ($isFriend) {
					echo $obUser->getUserName() . ' <a href="/user/unfollow/id-user/'. $obUser->getId() .'"> unfollow</a></br>';
				} else {
					echo $obUser->getUserName() . '<a href="/user/follow/id-user/'. $obUser->getId() .'"> follow</a></br>';
				}
			}			
		}
		
		echo '<a href="/connect/facebookAuth/">connect with Facebook</a><br/>';
		
		echo '<form action="/user/add-google-calendar">';
		echo '<label for="google_calendar_id">Google Calendar Id</label>';
		echo '<input id="google_calendar_id" name="google_calendar_id"/>';
		echo '<input type="submit" value="hau rein!"> ';
		echo '</form>';
		echo '<br/>';
		
		echo '<a href="/gcal">Google Kalender scannen</a>';
		
	}
	
	public function followAction(){
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$idUser = $this->getRequest()->getParam('id-user');
		
		$authUser = Application_Model_AuthUser::getAuthUser();
		$authUser->follow($idUser);
		
		$this -> _redirect(user);
	}
	
	public function unfollowAction(){
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$idUser = $this->getRequest()->getParam('id-user');
		
		$authUser = Application_Model_AuthUser::getAuthUser();
		$authUser->unfollow($idUser);
		
		$this -> _redirect(user);
	}
	
	public function autocompleteFriendsAction()
	{
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$authUser = Application_Model_AuthUser::getAuthUser();
		$query = $this->getRequest()->getParam('term');
		$userMapper = new Application_Model_UserMapper();
		
		$arrUsers = $userMapper->searchFriendsByName($authUser->getId(), $query);
		$arrNames = array();
		foreach ($arrUsers as $obUser) {
			array_push($arrNames, $obUser->getUserName());
		}
		$arrNames = Zend_Json::encode($arrNames);
		print_r($arrNames);
		
	}
	
	public function autocompleteUserAction()
	{
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$query = $this->getRequest()->getParam('term');
		$userMapper = new Application_Model_UserMapper();
		$arrUsers = $userMapper->searchUserByName($query);
		$arrNames = array();
		foreach ($arrUsers as $obUser) {
			array_push($arrNames, $obUser->getUserName());
		}
		$arrNames = Zend_Json::encode($arrNames);
		print_r($arrNames);
	}
	
	public function addGoogleCalendarAction()
	{
		//$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$data = array(
			'gcal_calendar_id'		=>	$this->getRequest()->getParam('google_calendar_id')
		);
		
		$authUser = Application_Model_AuthUser::getAuthUser();
		print_r($authUser);
		print_r($data);
		echo '<br/>';
		$user_id = $authUser->getID();
		$authUser->addData($user_id,$data);
		
		//$authUser = Application_Model_AuthUser::getAuthUser();
		//$authUser->unfollow($idUser);
		
		$this -> _redirect(user);
	}

}
