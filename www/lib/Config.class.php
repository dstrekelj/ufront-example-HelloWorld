<?php

class Config {
	public function __construct(){}
	static $app;
	function __toString() { return 'Config'; }
}
Config::$app = _hx_anonymous(array("basePath" => "/haxe/ufront-example-HelloWorld/www/", "defaultLayout" => "layout.html"));
