<?php

class ConnectController extends Zend_Controller_Action
{
	public function indexAction()
	{
		
	}
	
	public function facebookauthAction()
	{
		$this->_helper->viewRenderer->setNoRender(true);
			
		// Hole Facebook Erlaubnis für user_checkins, user_events, user_location, user_photos, email, offline_access
		$url = 'https://graph.facebook.com/oauth/authorize?client_id=' . 
		Zend_Registry::get('facebook_client_id') . 
		'&redirect_uri=' .
		Zend_Registry::get('facebook_redirect_uri') .
		'&scope=user_checkins,user_events,user_location,user_photos,email, offline_access';
		
		// Später evtl. auf JS Umbauen
		// Gebe URL für die JS Weiterleitung zurück
		//die ("1|$url");
		$this->_redirect($url);
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
			
			$userdb = new Application_Model_UserMapper();
			
			
			
			if ($result === FALSE)
			{
				/// TODO Error Page Redirect 
			} else {
				parse_str($result, $arresult);
				$auth = Zend_Auth::getInstance();
				$usermapper = new Application_Model_UserMapper();
				
				// Prüfe ob User eingeloggt ist.  
				if (!$auth->hasIdentity()) {	// Nicht eingeloggt
					$auth = Zend_Auth::getInstance();
					// Noch kein Handling von mehreren Accounts mit dem gleichen Token
					$user = $usermapper->getOneByAccess_token($arresult['access_token']); 
					if ($user){						
						$adapter = new Application_Model_Adapter_AuthFb();
						$adapter->setIdentity($user->getUserName());
						$adapter->setCredential($arresult['access_token']);
						$adapter->authenticate();
						$result = $auth->authenticate($adapter);
				
						switch ($result->getCode()){
							case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
								$this->_redirect(index);
								break;
									
							case Zend_Auth_Result::SUCCESS:
								$this->_redirect(map);
								break;  
						}				
					}

					if (false) {
						// TODO Profilinformation wird in die Anmeldefelder eingetragen, access_token in die DB geschrieben.
					}
					
				}
				
				// Mit Access Token das UserProfil auslesen
				$url = 'https://graph.facebook.com/me';
				$arpost = array(
					'access_token'		=>	$arresult['access_token']);
				$result = $this->requestFacebookAPI_GET($url, $arpost);
				
				if ($result === FALSE)
				{
					// TODO Error Handling hinzufügen
				} elseif ($auth->hasIdentity()){
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