<?php

class Iterators {
	public function __construct(){}
	static function count($it) {
		$i = 0;
		$__hx__it = $it;
		while($__hx__it->hasNext()) {
			$_ = $__hx__it->next();
			$i++;
		}
		return $i;
	}
	static function indexOf($it, $v = null, $f = null) {
		if(null === $f) {
			$f = array(new _hx_lambda(array(&$f, &$it, &$v), "Iterators_0"), 'execute');
		}
		$c = 0;
		$__hx__it = $it;
		while($__hx__it->hasNext()) {
			$i = $__hx__it->next();
			if(call_user_func_array($f, array($i))) {
				return $c;
			} else {
				$c++;
			}
		}
		return -1;
	}
	static function contains($it, $v = null, $f = null) {
		if(null === $f) {
			$f = array(new _hx_lambda(array(&$f, &$it, &$v), "Iterators_1"), 'execute');
		}
		$c = 0;
		$__hx__it = $it;
		while($__hx__it->hasNext()) {
			$i = $__hx__it->next();
			if(call_user_func_array($f, array($i))) {
				return true;
			}
		}
		return false;
	}
	static function harray($it) {
		$result = (new _hx_array(array()));
		$__hx__it = $it;
		while($__hx__it->hasNext()) {
			$v = $__hx__it->next();
			$result->push($v);
		}
		return $result;
	}
	static function join($it, $glue = null) {
		if($glue === null) {
			$glue = ", ";
		}
		return Iterators::harray($it)->join($glue);
	}
	static function map($it, $f) {
		$result = (new _hx_array(array()));
		$i = 0;
		$__hx__it = $it;
		while($__hx__it->hasNext()) {
			$v = $__hx__it->next();
			$result->push(call_user_func_array($f, array($v, $i++)));
		}
		return $result;
	}
	static function each($it, $f) {
		$i = 0;
		$__hx__it = $it;
		while($__hx__it->hasNext()) {
			$o = $__hx__it->next();
			call_user_func_array($f, array($o, $i++));
		}
	}
	static function filter($it, $f) {
		$result = (new _hx_array(array()));
		$__hx__it = $it;
		while($__hx__it->hasNext()) {
			$i = $__hx__it->next();
			if(call_user_func_array($f, array($i))) {
				$result->push($i);
			}
		}
		return $result;
	}
	static function reduce($it, $f, $initialValue) {
		$accumulator = $initialValue;
		$i = 0;
		$__hx__it = $it;
		while($__hx__it->hasNext()) {
			$o = $__hx__it->next();
			$accumulator = call_user_func_array($f, array($accumulator, $o, $i++));
		}
		return $accumulator;
	}
	static function random($it) {
		return Arrays::random(Iterators::harray($it));
	}
	static function any($it, $f) {
		$__hx__it = $it;
		while($__hx__it->hasNext()) {
			$v = $__hx__it->next();
			if(call_user_func_array($f, array($v))) {
				return true;
			}
		}
		return false;
	}
	static function all($it, $f) {
		$__hx__it = $it;
		while($__hx__it->hasNext()) {
			$v = $__hx__it->next();
			if(!call_user_func_array($f, array($v))) {
				return false;
			}
		}
		return true;
	}
	static function last($it) {
		$o = null;
		while($it->hasNext()) {
			$o = $it->next();
		}
		return $o;
	}
	static function lastf($it, $f) {
		$rev = Iterators::harray($it);
		$rev->reverse();
		return Arrays::lastf($rev, $f);
	}
	static function first($it) {
		return $it->next();
	}
	static function firstf($it, $f) {
		$__hx__it = $it;
		while($__hx__it->hasNext()) {
			$v = $__hx__it->next();
			if(call_user_func_array($f, array($v))) {
				return $v;
			}
		}
		return null;
	}
	static function order($it, $f = null) {
		$arr = Iterators::harray($it);
		$arr->sort(Iterators_2($arr, $f, $it));
		return $arr;
	}
	static function isIterator($v) {
		$fields = null;
		if(Reflect::isObject($v) && null === Type::getClass($v)) {
			$fields = Reflect::fields($v);
		} else {
			$fields = Type::getInstanceFields(Type::getClass($v));
		}
		if(!Lambda::has($fields, "next") || !Lambda::has($fields, "hasNext")) {
			return false;
		}
		return Reflect::isFunction(Reflect::field($v, "next")) && Reflect::isFunction(Reflect::field($v, "hasNext"));
	}
	function __toString() { return 'Iterators'; }
}
function Iterators_0(&$f, &$it, &$v, $v2) {
	{
		return (is_object($_t = $v) && !($_t instanceof Enum) ? $_t === $v2 : $_t == $v2);
	}
}
function Iterators_1(&$f, &$it, &$v, $v2) {
	{
		return (is_object($_t = $v) && !($_t instanceof Enum) ? $_t === $v2 : $_t == $v2);
	}
}
function Iterators_2(&$arr, &$f, &$it) {
	if(null === $f) {
		return (isset(Dynamics::$compare) ? Dynamics::$compare: array("Dynamics", "compare"));
	} else {
		return $f;
	}
}
