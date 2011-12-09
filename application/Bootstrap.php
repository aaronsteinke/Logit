<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('HTML5');
        $this->init();
    }
    
    protected function init(){
   
    	$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'production');
		
    	Zend_Registry::set('dbAdapter', new Zend_Db_Adapter_Mysqli($config->resources->db->params->toArray()));
    	
    } 
	
	protected function _initConfig() {
		$aConfig = $this->getOptions();
		Zend_Registry::set('facebook_client_id', $aConfig['facebook']['client_id']);
		Zend_Registry::set('facebook_client_secret', $aConfig['facebook']['client_secret']);
		Zend_Registry::set('facebook_redirect_uri', $aConfig['facebook']['redirect_uri']);
	}
}

