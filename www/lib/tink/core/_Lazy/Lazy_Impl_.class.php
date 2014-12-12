<?php

class tink_core__Lazy_Lazy_Impl_ {
	public function __construct(){}
	static function _new($r) {
		return $r;
	}
	static function get($this1) {
		return call_user_func($this1);
	}
	static function ofFunc($f) {
		$result = null;
		return array(new _hx_lambda(array(&$f, &$result), "tink_core__Lazy_Lazy_Impl__0"), 'execute');
	}
	static function map($this1, $f) {
		return tink_core__Lazy_Lazy_Impl_::ofFunc(array(new _hx_lambda(array(&$f, &$this1), "tink_core__Lazy_Lazy_Impl__1"), 'execute'));
	}
	static function flatMap($this1, $f) {
		return tink_core__Lazy_Lazy_Impl_::ofFunc(array(new _hx_lambda(array(&$f, &$this1), "tink_core__Lazy_Lazy_Impl__2"), 'execute'));
	}
	static function ofConst($c) {
		return array(new _hx_lambda(array(&$c), "tink_core__Lazy_Lazy_Impl__3"), 'execute');
	}
	function __toString() { return 'tink.core._Lazy.Lazy_Impl_'; }
}
function tink_core__Lazy_Lazy_Impl__0(&$f, &$result) {
	{
		if($f !== null) {
			$result = call_user_func($f);
			$f = null;
		}
		return $result;
	}
}
function tink_core__Lazy_Lazy_Impl__1(&$f, &$this1) {
	{
		return call_user_func_array($f, array(call_user_func($this1)));
	}
}
function tink_core__Lazy_Lazy_Impl__2(&$f, &$this1) {
	{
		$this2 = call_user_func_array($f, array(call_user_func($this1)));
		return call_user_func($this2);
	}
}
function tink_core__Lazy_Lazy_Impl__3(&$c) {
	{
		return $c;
	}
}
