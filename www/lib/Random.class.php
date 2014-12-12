<?php

class Random {
	public function __construct(){}
	static function bool() {
		return Math::random() < 0.5;
	}
	static function int($from, $to) {
		return $from + Math::floor(($to - $from + 1) * Math::random());
	}
	static function float($from, $to) {
		return $from + ($to - $from) * Math::random();
	}
	static function string($length, $charactersToUse = null) {
		if($charactersToUse === null) {
			$charactersToUse = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		}
		$str = "";
		{
			$_g = 0;
			while($_g < $length) {
				$i = $_g++;
				$str .= _hx_string_or_null(_hx_char_at($charactersToUse, Math::floor((strlen($charactersToUse) - 1 + 1) * Math::random())));
				unset($i);
			}
		}
		return $str;
	}
	static function date($earliest, $latest) {
		return Date::fromTime(Random_0($earliest, $latest));
	}
	static function fromArray($arr) {
		if($arr !== null && $arr->length > 0) {
			return $arr[Math::floor(($arr->length - 1 + 1) * Math::random())];
		} else {
			return null;
		}
	}
	static function shuffle($arr) {
		if($arr !== null) {
			$_g1 = 0;
			$_g = $arr->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$j = Math::floor(($arr->length - 1 + 1) * Math::random());
				$a = $arr[$i];
				$b = $arr[$j];
				$arr[$i] = $b;
				$arr[$j] = $a;
				unset($j,$i,$b,$a);
			}
		}
		return $arr;
	}
	static function fromIterable($it) {
		if($it !== null) {
			$arr = Lambda::harray($it);
			if($arr !== null && $arr->length > 0) {
				return $arr[Math::floor(($arr->length - 1 + 1) * Math::random())];
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
	static function enumConstructor($e) {
		if($e !== null) {
			$arr = Type::allEnums($e);
			if($arr !== null && $arr->length > 0) {
				return $arr[Math::floor(($arr->length - 1 + 1) * Math::random())];
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
	function __toString() { return 'Random'; }
}
function Random_0(&$earliest, &$latest) {
	{
		$from = $earliest->getTime();
		$to = $latest->getTime();
		return $from + ($to - $from) * Math::random();
	}
}
