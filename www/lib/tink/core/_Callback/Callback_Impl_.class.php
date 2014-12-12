<?php

class tink_core__Callback_Callback_Impl_ {
	public function __construct(){}
	static function _new($f) {
		return $f;
	}
	static function invoke($this1, $data) {
		call_user_func_array($this1, array($data));
	}
	static function fromNiladic($f) {
		return array(new _hx_lambda(array(&$f), "tink_core__Callback_Callback_Impl__0"), 'execute');
	}
	static function fromMany($callbacks) {
		return array(new _hx_lambda(array(&$callbacks), "tink_core__Callback_Callback_Impl__1"), 'execute');
	}
	function __toString() { return 'tink.core._Callback.Callback_Impl_'; }
}
function tink_core__Callback_Callback_Impl__0(&$f, $r) {
	{
		call_user_func($f);
	}
}
function tink_core__Callback_Callback_Impl__1(&$callbacks, $v) {
	{
		$_g = 0;
		while($_g < $callbacks->length) {
			$callback = $callbacks[$_g];
			++$_g;
			call_user_func_array($callback, array($v));
			unset($callback);
		}
	}
}
