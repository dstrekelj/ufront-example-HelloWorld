<?php

class Bools {
	public function __construct(){}
	static function format($v, $param = null, $params = null, $culture = null) {
		return call_user_func_array(Bools::formatf($param, $params, $culture), array($v));
	}
	static function formatf($param = null, $params = null, $culture = null) {
		$params = thx_culture_FormatParams::params($param, $params, "B");
		$format = $params->shift();
		switch($format) {
		case "B":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Bools_0"), 'execute');
		}break;
		case "N":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Bools_1"), 'execute');
		}break;
		case "R":{
			if($params->length !== 2) {
				throw new HException("bool format R requires 2 parameters");
			}
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Bools_2"), 'execute');
		}break;
		default:{
			throw new HException("Unsupported bool format: " . _hx_string_or_null($format));
		}break;
		}
	}
	static function interpolate($v, $a, $b, $equation = null) {
		return call_user_func_array(Bools::interpolatef($a, $b, $equation), array($v));
	}
	static function interpolatef($a, $b, $equation = null) {
		if($a === $b) {
			return array(new _hx_lambda(array(&$a, &$b, &$equation), "Bools_3"), 'execute');
		} else {
			$f = Floats::interpolatef(0, 1, $equation);
			return array(new _hx_lambda(array(&$a, &$b, &$equation, &$f), "Bools_4"), 'execute');
		}
	}
	static function canParse($s) {
		$s = strtolower($s);
		return $s === "true" || $s === "false";
	}
	static function parse($s) {
		return strtolower($s) === "true";
	}
	static function compare($a, $b) {
		if($a === $b) {
			return 0;
		} else {
			if($a) {
				return -1;
			} else {
				return 1;
			}
		}
	}
	function __toString() { return 'Bools'; }
}
function Bools_0(&$culture, &$format, &$param, &$params, $v) {
	{
		if($v) {
			return "true";
		} else {
			return "false";
		}
	}
}
function Bools_1(&$culture, &$format, &$param, &$params, $v1) {
	{
		if($v1) {
			return "1";
		} else {
			return "0";
		}
	}
}
function Bools_2(&$culture, &$format, &$param, &$params, $v2) {
	{
		if($v2) {
			return $params[0];
		} else {
			return $params[1];
		}
	}
}
function Bools_3(&$a, &$b, &$equation, $_) {
	{
		return $a;
	}
}
function Bools_4(&$a, &$b, &$equation, &$f, $v) {
	{
		if(call_user_func_array($f, array($v)) < 0.5) {
			return $a;
		} else {
			return $b;
		}
	}
}
