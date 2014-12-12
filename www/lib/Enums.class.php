<?php

class Enums {
	public function __construct(){}
	static function string($e) {
		$cons = Type::enumConstructor($e);
		$params = (new _hx_array(array()));
		{
			$_g = 0;
			$_g1 = Type::enumParameters($e);
			while($_g < $_g1->length) {
				$param = $_g1[$_g];
				++$_g;
				$params->push(Dynamics::string($param));
				unset($param);
			}
		}
		return _hx_string_or_null($cons) . _hx_string_or_null((Enums_0($cons, $e, $params)));
	}
	static function compare($a, $b) {
		$v = null;
		if(($v = Enums_1($a, $b, $v) - Enums_2($a, $b, $v)) !== 0) {
			return $v;
		}
		return Arrays::compare(Type::enumParameters($a), Type::enumParameters($b));
	}
	function __toString() { return 'Enums'; }
}
function Enums_0(&$cons, &$e, &$params) {
	if($params->length === 0) {
		return "";
	} else {
		return "(" . _hx_string_or_null($params->join(", ")) . ")";
	}
}
function Enums_1(&$a, &$b, &$v) {
	{
		$e = $a;
		return $e->index;
	}
}
function Enums_2(&$a, &$b, &$v) {
	{
		$e1 = $b;
		return $e1->index;
	}
}
