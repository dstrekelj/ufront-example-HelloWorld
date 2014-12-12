<?php

class app_Config {
	public function __construct(){}
	static $app;
	static $db;
	function __toString() { return 'app.Config'; }
}
app_Config::$app = _hx_anonymous(array("title" => "UFront tutorial"));
app_Config::$db = _hx_anonymous(array("socket" => null, "database" => "qanda", "user" => "root", "port" => 3307, "pass" => "usbw", "host" => "localhost"));
