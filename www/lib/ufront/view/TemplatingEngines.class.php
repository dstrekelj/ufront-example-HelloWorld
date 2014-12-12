<?php

class ufront_view_TemplatingEngines {
	public function __construct(){}
	static $haxe;
	static function get_haxe() {
		return _hx_anonymous(array("factory" => array(new _hx_lambda(array(), "ufront_view_TemplatingEngines_0"), 'execute'), "type" => "haxe.Template", "extensions" => (new _hx_array(array("html", "tpl")))));
	}
	static $__properties__ = array("get_haxe" => "get_haxe");
	function __toString() { return 'ufront.view.TemplatingEngines'; }
}
function ufront_view_TemplatingEngines_0($tplString) {
	{
		$t = new haxe_Template($tplString);
		return array(new _hx_lambda(array(&$t, &$tplString), "ufront_view_TemplatingEngines_1"), 'execute');
	}
}
function ufront_view_TemplatingEngines_1(&$t, &$tplString, $data) {
	{
		return $t->execute($data, null);
	}
}
