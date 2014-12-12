<?php

class ufront_auth_EasyAuthAdminMode extends ufront_auth_EasyAuth {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$this->isSuperUser = true;
	}}
	public function get_currentUser() {
		return null;
	}
	static $__properties__ = array("get_isSuperUser" => "get_isSuperUser","get_currentUser" => "get_currentUser");
	function __toString() { return 'ufront.auth.EasyAuthAdminMode'; }
}
