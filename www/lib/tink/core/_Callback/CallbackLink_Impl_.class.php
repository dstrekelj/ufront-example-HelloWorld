<?php

class tink_core__Callback_CallbackLink_Impl_ {
	public function __construct(){}
	static function _new($link) {
		return $link;
	}
	static function dissolve($this1) {
		if($this1 !== null) {
			call_user_func($this1);
		}
	}
	static function toCallback($this1) {
		$f = $this1;
		return array(new _hx_lambda(array(&$f, &$this1), "tink_core__Callback_CallbackLink_Impl__0"), 'execute');
	}
	static function fromFunction($f) {
		return $f;
	}
	static function fromMany($callbacks) {
		return array(new _hx_lambda(array(&$callbacks), "tink_core__Callback_CallbackLink_Impl__1"), 'execute');
	}
	function __toString() { return 'tink.core._Callback.CallbackLink_Impl_'; }
}
function tink_core__Callback_CallbackLink_Impl__0(&$f, &$this1, $r) {
	{
		call_user_func($f);
	}
}
function tink_core__Callback_CallbackLink_Impl__1(&$callbacks) {
	{
		$_g = 0;
		while($_g < $callbacks->length) {
			$cb = $callbacks[$_g];
			++$_g;
			if($cb !== null) {
				call_user_func($cb);
			}
			unset($cb);
		}
	}
}
