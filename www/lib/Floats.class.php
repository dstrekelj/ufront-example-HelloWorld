<?php

class Floats {
	public function __construct(){}
	static function normalize($v) {
		if($v < 0.0) {
			return 0.0;
		} else {
			if($v > 1.0) {
				return 1.0;
			} else {
				return $v;
			}
		}
	}
	static function clamp($v, $min, $max) {
		if($v < $min) {
			return $min;
		} else {
			if($v > $max) {
				return $max;
			} else {
				return $v;
			}
		}
	}
	static function clampSym($v, $max) {
		if($v < -$max) {
			return -$max;
		} else {
			if($v > $max) {
				return $max;
			} else {
				return $v;
			}
		}
	}
	static function range($start, $stop = null, $step = null, $inclusive = null) {
		if($inclusive === null) {
			$inclusive = false;
		}
		if($step === null) {
			$step = 1.0;
		}
		if(null === $stop) {
			$stop = $start;
			$start = 0.0;
		}
		if(($stop - $start) / $step === Math::$POSITIVE_INFINITY) {
			throw new HException(new thx_error_Error("infinite range", null, null, _hx_anonymous(array("fileName" => "Floats.hx", "lineNumber" => 50, "className" => "Floats", "methodName" => "range"))));
		}
		$range = (new _hx_array(array()));
		$i = -1.0;
		$j = null;
		if($inclusive) {
			if($step < 0) {
				while(($j = $start + $step * ++$i) >= $stop) {
					$range->push($j);
				}
			} else {
				while(($j = $start + $step * ++$i) <= $stop) {
					$range->push($j);
				}
			}
		} else {
			if($step < 0) {
				while(($j = $start + $step * ++$i) > $stop) {
					$range->push($j);
				}
			} else {
				while(($j = $start + $step * ++$i) < $stop) {
					$range->push($j);
				}
			}
		}
		return $range;
	}
	static function sign($v) {
		if($v < 0) {
			return -1;
		} else {
			return 1;
		}
	}
	static function abs($a) {
		if($a < 0) {
			return -$a;
		} else {
			return $a;
		}
	}
	static function min($a, $b) {
		if($a < $b) {
			return $a;
		} else {
			return $b;
		}
	}
	static function max($a, $b) {
		if($a > $b) {
			return $a;
		} else {
			return $b;
		}
	}
	static function wrap($v, $min, $max) {
		$range = $max - $min + 1;
		if($v < $min) {
			$v += $range * (($min - $v) / $range + 1);
		}
		return $min + _hx_mod(($v - $min), $range);
	}
	static function circularWrap($v, $max) {
		$v = _hx_mod($v, $max);
		if($v < 0) {
			$v += $max;
		}
		return $v;
	}
	static function interpolate($f, $a = null, $b = null, $equation = null) {
		if($b === null) {
			$b = 1.0;
		}
		if($a === null) {
			$a = 0.0;
		}
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return $a + call_user_func_array($equation, array($f)) * ($b - $a);
	}
	static function interpolatef($a = null, $b = null, $equation = null) {
		if($b === null) {
			$b = 1.0;
		}
		if($a === null) {
			$a = 0.0;
		}
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		$d = $b - $a;
		return array(new _hx_lambda(array(&$a, &$b, &$d, &$equation), "Floats_0"), 'execute');
	}
	static function interpolateClampf($min, $max, $equation = null) {
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return array(new _hx_lambda(array(&$equation, &$max, &$min), "Floats_1"), 'execute');
	}
	static function format($v, $param = null, $params = null, $culture = null) {
		return call_user_func_array(Floats::formatf($param, $params, $culture), array($v));
	}
	static function formatf($param = null, $params = null, $culture = null) {
		$params = thx_culture_FormatParams::params($param, $params, "D");
		$format = $params->shift();
		$decimals = null;
		if($params->length > 0) {
			$decimals = Std::parseInt($params[0]);
		} else {
			$decimals = null;
		}
		switch($format) {
		case "D":{
			return array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "Floats_2"), 'execute');
		}break;
		case "I":{
			return array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "Floats_3"), 'execute');
		}break;
		case "C":{
			$s = null;
			if($params->length > 1) {
				$s = $params[1];
			} else {
				$s = null;
			}
			return array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params, &$s), "Floats_4"), 'execute');
		}break;
		case "P":{
			return array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "Floats_5"), 'execute');
		}break;
		case "M":{
			return array(new _hx_lambda(array(&$culture, &$decimals, &$format, &$param, &$params), "Floats_6"), 'execute');
		}break;
		default:{
			throw new HException(new thx_error_Error("Unsupported number format: {0}", null, $format, _hx_anonymous(array("fileName" => "Floats.hx", "lineNumber" => 152, "className" => "Floats", "methodName" => "formatf"))));
		}break;
		}
	}
	static $_reparse;
	static $_reparseStrict;
	static function canParse($s, $strict = null) {
		if($strict === null) {
			$strict = false;
		}
		if($strict) {
			return Floats::$_reparseStrict->match($s);
		} else {
			return Floats::$_reparse->match($s);
		}
	}
	static function parse($s) {
		if(_hx_substr($s, 0, 1) === "+") {
			$s = _hx_substr($s, 1, null);
		}
		return Std::parseFloat($s);
	}
	static function compare($a, $b) {
		if($a < $b) {
			return -1;
		} else {
			if($a > $b) {
				return 1;
			} else {
				return 0;
			}
		}
	}
	static function isNumeric($v) {
		return Std::is($v, _hx_qtype("Float")) || Std::is($v, _hx_qtype("Int"));
	}
	static function equals($a, $b, $approx = null) {
		if($approx === null) {
			$approx = 1e-5;
		}
		if(Math::isNaN($a)) {
			return Math::isNaN($b);
		} else {
			if(Math::isNaN($b)) {
				return false;
			} else {
				if(!Math::isFinite($a) && !Math::isFinite($b)) {
					return (is_object($_t = ($a > 0)) && !($_t instanceof Enum) ? $_t === $b > 0 : $_t == $b > 0);
				}
			}
		}
		return Math::abs($b - $a) < $approx;
	}
	static function uninterpolatef($a, $b) {
		$b = 1 / ($b - $a);
		return array(new _hx_lambda(array(&$a, &$b), "Floats_7"), 'execute');
	}
	static function uninterpolateClampf($a, $b) {
		$b = 1 / ($b - $a);
		return array(new _hx_lambda(array(&$a, &$b), "Floats_8"), 'execute');
	}
	static function round($number, $precision = null) {
		if($precision === null) {
			$precision = 2;
		}
		$number *= Math::pow(10, $precision);
		return Math::round($number) / Math::pow(10, $precision);
	}
	function __toString() { return 'Floats'; }
}
Floats::$_reparse = new EReg("^[+\\-]?(?:0|[1-9]\\d*)(?:\\.\\d*)?(?:[eE][+\\-]?\\d+)?", "");
Floats::$_reparseStrict = new EReg("^[+\\-]?(?:0|[1-9]\\d*)(?:\\.\\d*)?(?:[eE][+\\-]?\\d+)?\$", "");
function Floats_0(&$a, &$b, &$d, &$equation, $f) {
	{
		return $a + call_user_func_array($equation, array($f)) * $d;
	}
}
function Floats_1(&$equation, &$max, &$min, $a, $b) {
	{
		$d = $b - $a;
		return array(new _hx_lambda(array(&$a, &$b, &$d, &$equation, &$max, &$min), "Floats_9"), 'execute');
	}
}
function Floats_2(&$culture, &$decimals, &$format, &$param, &$params, $v) {
	{
		return thx_culture_FormatNumber::decimal($v, $decimals, $culture);
	}
}
function Floats_3(&$culture, &$decimals, &$format, &$param, &$params, $v1) {
	{
		return thx_culture_FormatNumber::int($v1, $culture);
	}
}
function Floats_4(&$culture, &$decimals, &$format, &$param, &$params, &$s, $v2) {
	{
		return thx_culture_FormatNumber::currency($v2, $s, $decimals, $culture);
	}
}
function Floats_5(&$culture, &$decimals, &$format, &$param, &$params, $v3) {
	{
		return thx_culture_FormatNumber::percent($v3, $decimals, $culture);
	}
}
function Floats_6(&$culture, &$decimals, &$format, &$param, &$params, $v4) {
	{
		return thx_culture_FormatNumber::permille($v4, $decimals, $culture);
	}
}
function Floats_7(&$a, &$b, $x) {
	{
		return ($x - $a) * $b;
	}
}
function Floats_8(&$a, &$b, $x) {
	{
		return Floats::clamp(($x - $a) * $b, 0.0, 1.0);
	}
}
function Floats_9(&$a, &$b, &$d, &$equation, &$max, &$min, $f) {
	{
		return $a + call_user_func_array($equation, array(Floats::clamp($f, $min, $max))) * $d;
	}
}
