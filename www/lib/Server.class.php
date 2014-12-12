<?php

class Server {
	public function __construct(){}
	static $ufrontApp;
	static function main() {
		if(Server::$ufrontApp === null) {
			Server::$ufrontApp = new ufront_app_UfrontApplication(_hx_anonymous(array("indexController" => _hx_qtype("app.Routes"), "templatingEngines" => (new _hx_array(array(ufront_view_TemplatingEngines::get_haxe()))), "defaultLayout" => Config::$app->defaultLayout, "basePath" => Config::$app->basePath)));
		}
		Server::$ufrontApp->executeRequest();
	}
	function __toString() { return 'Server'; }
}
