<?php

class Application_Model_Events
{
	protected $_id;
	protected $_gcal_id;
	protected $_event_title;
	protected $_event_start;
	protected $_event_end;
	protected $_user_id;
	
	public function __construct( 	$id, $gcal_id, $event_title, $event_start, $event_end, $user_id) {
	$this->_id = $id;
	$this->_gcal_id = $gcal_id;
	$this->_event_title = $id;
	$this->_event_start = $event_start;
	$this->_event_end = $event_end;
	$this->_user_id = $user_id;
	}
	
	public function get_id() { return $this->_id; } 
	public function get_gcal_id() {return $this->$_gcal_id; }
	public function get_event_title() { return $this->_event_title; } 
	public function get_event_start() { return $this->_event_start; } 
	public function get_event_end() { return $this->_event_end; } 
	public function get_user_id() { return $this->_user_id; } 

}

?>
	
	
