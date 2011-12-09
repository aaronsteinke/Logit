<?php

class ConnectController extends Zend_Controller_Action
{
	public function indexAction()
	{
		
	}
	
	public function facebookauthAction()
	{
		$this->_helper->viewRenderer->setNoRender(true);
		$user = Application_Model_AuthUser::getAuthUser();
				$user_id = $user->getId();
		
		if ($user_id)
		{
			// Hole Facebook Erlaubnis für user_checkins, user_events, user_location, user_photos, email
			$url = 'https://graph.facebook.com/oauth/authorize?client_id=' . 
			Zend_Registry::get('facebook_client_id') . 
			'&redirect_uri=' .
			Zend_Registry::get('facebook_redirect_uri') .
			'&scope=user_checkins,user_events,user_location,user_photos,email';
			
			// Später evtl. auf JS Umbauen
			// Gebe URL für die JS Weiterleitung zurück
			//die ("1|$url");
			$this->_redirect($url);
		} else{
			// Kein User eingeloggt
			//die ("0|Bitte zuerst einloggen");
		}
	}
	
	public function facebookcbAction()
	{
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout();
		
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
				parse_str($result, $arresult);
				
				// Mit Access Token das UserProfil auslesen
				$url = 'https://graph.facebook.com/me';
				$arpost = array(
					'access_token'		=>	$arresult['access_token']);
				$result = $this->requestFacebookAPI_GET($url, $arpost);
				
				if ($result === FALSE)
				{
					// Error Handling
				} else {
					$user = Application_Model_AuthUser::getAuthUser();
					$user_id = $user->getId();
					
					$arprofile = json_decode($result, true);
					print_r($arresult);
					print_r($arprofile);
					$data = array(
					'id'					=> $user->getId(),
					'facebook_access_token'	=> $arresult['access_token'],
					'facebook_name'			=> $arprofile['name'],
					'facebook_id'			=> $arprofile['id']
					);
					
					$userdb = new Application_Model_UserMapper();
					$userdb->addFacebookData($user_id, $data);
					$this->_redirect("/map");
				}
			}
		}
	}		
		
	private function requestFacebookAPI_GET($url, $arpost) {
		// Url Request to facebook
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url . "?" . http_build_query($arpost));
		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
		
	}
		
}	