<?php
namespace BaseCamp_Feed;

class Basecamp_Person extends Basecamp_Object {
	
	function isAdmin() {
		return $this->admin;
	}
	
	function getEvents($since='',$page='') {
		$this->basecampRequired();
		return $this->_basecamp->getEvents($since,$page,'people',$this->id);
	}
	
	function getTopics($page='') {
		$this->basecampRequired();
		return $this->_basecamp->getTopics($page,'people',$this->id);
	}
}