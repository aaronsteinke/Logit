<?php

class SettingsController extends Zend_Controller_Action {
	public function init()
	{

	}

	public function indexAction()
	{
		$this -> _helper -> layout() -> disableLayout();
		$this -> view -> user = Application_Model_AuthUser::getAuthUser();
	}

	public function updatesettingsAction()
	{
		$this -> _helper -> viewRenderer -> setNoRender(true);
		$this -> _helper -> layout() -> disableLayout();
		$user = Application_Model_AuthUser::getAuthUser();
		$params = $this -> getRequest() -> getParams();

		// Vor Aufruf der Setter ist vielleicht noch ein Überprüfen ob die Werte geändert
		// wurden sinnvoll
		$user -> setUserName($params['username']);
		// TODO Ändern des Usernames zerstört session
		$user -> setEmail($params['email']);
		$user -> setGcalId($params['gcal_id']);

		// Namensfeld Trennen
		$arrNames = explode(' ', $params['name'], 2);
		$user -> setFirstName($arrNames[0]);
		$user -> setLastName($arrNames[1]);

		// Änderungen schreiben
		$user -> updateDb();

		// Redirect zur Map
		$this -> _redirect('/map');

	}

}
