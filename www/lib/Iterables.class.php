<?php

class Iterables {
	public function __construct(){}
	static function count($it) {
		return Iterators::count($it->iterator());
	}
	static function indexOf($it, $v = null, $f = null) {
		return Iterators::indexOf($it->iterator(), $v, $f);
	}
	static function contains($it, $v = null, $f = null) {
		return Iterators::contains($it->iterator(), $v, $f);
	}
	static function harray($it) {
		return Iterators::harray($it->iterator());
	}
	static function join($it, $glue = null) {
		if($glue === null) {
			$glue = ", ";
		}
		$it1 = $it->iterator();
		return Iterators::harray($it1)->join($glue);
	}
	static function map($it, $f) {
		return Iterators::map($it->iterator(), $f);
	}
	static function each($it, $f) {
		Iterators::each($it->iterator(), $f);
		return;
	}
	static function filter($it, $f) {
		return Iterators::filter($it->iterator(), $f);
	}
	static function reduce($it, $f, $initialValue) {
		return Iterators::reduce($it->iterator(), $f, $initialValue);
	}
	static function random($it) {
		return Arrays::random(Iterators::harray($it->iterator()));
	}
	static function any($it, $f) {
		return Iterators::any($it->iterator(), $f);
	}
	static function all($it, $f) {
		return Iterators::all($it->iterator(), $f);
	}
	static function last($it) {
		$it1 = $it->iterator();
		$o = null;
		while($it1->hasNext()) {
			$o = $it1->next();
		}
		return $o;
	}
	static function lastf($it, $f) {
		return Iterators::lastf($it->iterator(), $f);
	}
	static function first($it) {
		$it1 = $it->iterator();
		return $it1->next();
	}
	static function firstf($it, $f) {
		return Iterators::firstf($it->iterator(), $f);
	}
	static function order($it, $f = null) {
		$it1 = $it->iterator();
		{
			$arr = Iterators::harray($it1);
			$arr->sort(Iterables_0($arr, $f, $it, $it1));
			return $arr;
		}
	}
	static function isIterable($v) {
		$fields = null;
		if(Reflect::isObject($v) && null === Type::getClass($v)) {
			$fields = Reflect::fields($v);
		} else {
			$fields = Type::getInstanceFields(Type::getClass($v));
		}
		if(!Lambda::has($fields, "iterator")) {
			return false;
		}
		return Reflect::isFunction(Reflect::field($v, "iterator"));
	}
	function __toString() { return 'Iterables'; }
}
function Iterables_0(&$arr, &$f, &$it, &$it1) {
	if(null === $f) {
		return (isset(Dynamics::$compare) ? Dynamics::$compare: array("Dynamics", "compare"));
	} else {
		return $f;
	}
}
