<?php

class IndexController extends Zend_Controller_Action
{
	public function facebookAuthAction()
	{
		$this->_helper->viewRenderer->setNoRender(true);
		
		if ($userid = Zend_Auth::getInstance()->getIdentity()->id)
		{
			// Hole Facebook Erlaubnis für user_checkins, user_events, user_location, user_photos, email
			$url = 'https://graph.facebook.com/oauth/authorize?client_id=' . 
			Zend_Registry::get('facebook_client_id') . 
			'&redirect_uri=' .
			Zend_Registry::get('facebook_redirect_uri') .
			'&scope=user_checkins,user_events,user_location,user_photos,email';
			
			// Gebe URL für die JS Weiterleitung zurück
			die ("1|$url");
		} else{
			// Kein User eingeloggt
			die ("0|Bitte zuerst einloggen");
		}
	}
	
	public function facebookcbAction()
	{
		$request = $this->getRequest();
		$params = $request->getParams();
		
		if (isset($params['code']))
		{
			// Code Parameter aus dem Facebook Callback auslesen
			$code = $params['code'];
			
			$url = 'https://graph.facebook.com/oauth/access_token';
			$arpost = array(
			'client_id' 	=>	Zend_Registry::get('facebook_client_id'),
			'redirect_uri'	=>	Zend_Registry::get('facebook_redirect_uri'),
			'client_secret' =>	Zend_Registry::get('facebook_client_secret'),
			'code'			=>	$code);
			
			$result = $this->requestFacebookAPI_GET($url, $arpost);
			
			if ($result === FALSE)
			{
				/// Error Page Redirect 
			} else {
				$user = Application_Model_AuthUser::getAuthUser();
				$user_id = $user->getId();
				$arprofile = json_decode($result, true);
				
				$data = array(
				'id'					=> $user->getId(),
				'facebook_access_token'	=> $arresult['access_token'],
				'facebook_name'			=> $arprofile['name'],
				'facebook_id'			=> $arprofile['id']
				);
				
				$userdb = new Application_Model_UserMapper();
				$userdb->addFacebookData($user_id, $data);
			}
		}
	}		
		
	private function requestFacebookAPI_GET($url, $arpost) {
		
	}
		
}	