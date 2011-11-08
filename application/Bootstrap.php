<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
        $this->init();
    }
    
    protected function init(){
    	
    	$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'production');
		
    	Zend_Registry::set('dbAdapter', new Zend_Db_Adapter_Mysqli($config->resources->db->params->toArray()));
    	
    }
}

