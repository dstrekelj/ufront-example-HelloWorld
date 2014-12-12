<?php

class tink_core__Signal_Signal_Impl_ {
	public function __construct(){}
	static function _new($f) {
		return $f;
	}
	static function handle($this1, $handler) {
		return call_user_func_array($this1, array($handler));
	}
	static function map($this1, $f, $gather = null) {
		if($gather === null) {
			$gather = true;
		}
		$ret = array(new _hx_lambda(array(&$f, &$gather, &$this1), "tink_core__Signal_Signal_Impl__0"), 'execute');
		if($gather) {
			return tink_core__Signal_Signal_Impl_::gather($ret);
		} else {
			return $ret;
		}
	}
	static function flatMap($this1, $f, $gather = null) {
		if($gather === null) {
			$gather = true;
		}
		$ret = array(new _hx_lambda(array(&$f, &$gather, &$this1), "tink_core__Signal_Signal_Impl__1"), 'execute');
		if($gather) {
			return tink_core__Signal_Signal_Impl_::gather($ret);
		} else {
			return $ret;
		}
	}
	static function filter($this1, $f, $gather = null) {
		if($gather === null) {
			$gather = true;
		}
		$ret = array(new _hx_lambda(array(&$f, &$gather, &$this1), "tink_core__Signal_Signal_Impl__2"), 'execute');
		if($gather) {
			return tink_core__Signal_Signal_Impl_::gather($ret);
		} else {
			return $ret;
		}
	}
	static function join($this1, $other, $gather = null) {
		if($gather === null) {
			$gather = true;
		}
		$ret = array(new _hx_lambda(array(&$gather, &$other, &$this1), "tink_core__Signal_Signal_Impl__3"), 'execute');
		if($gather) {
			return tink_core__Signal_Signal_Impl_::gather($ret);
		} else {
			return $ret;
		}
	}
	static function next($this1) {
		$ret = new tink_core_FutureTrigger();
		{
			$handler = tink_core__Callback_CallbackLink_Impl_::toCallback(call_user_func_array($this1, array((isset($ret->trigger) ? $ret->trigger: array($ret, "trigger")))));
			call_user_func_array($this1, array($handler));
		}
		return $ret->future;
	}
	static function noise($this1) {
		return tink_core__Signal_Signal_Impl_::map($this1, array(new _hx_lambda(array(&$this1), "tink_core__Signal_Signal_Impl__4"), 'execute'), null);
	}
	static function gather($this1) {
		$ret = tink_core__Signal_Signal_Impl_::trigger();
		call_user_func_array($this1, array(array(new _hx_lambda(array(&$ret, &$this1), "tink_core__Signal_Signal_Impl__5"), 'execute')));
		return tink_core__Signal_SignalTrigger_Impl_::asSignal($ret);
	}
	static function trigger() {
		return (new _hx_array(array()));
	}
	static function ofClassical($add, $remove, $gather = null) {
		if($gather === null) {
			$gather = true;
		}
		$ret = array(new _hx_lambda(array(&$add, &$gather, &$remove), "tink_core__Signal_Signal_Impl__6"), 'execute');
		if($gather) {
			return tink_core__Signal_Signal_Impl_::gather($ret);
		} else {
			return $ret;
		}
	}
	function __toString() { return 'tink.core._Signal.Signal_Impl_'; }
}
function tink_core__Signal_Signal_Impl__0(&$f, &$gather, &$this1, $cb) {
	{
		return call_user_func_array($this1, array(array(new _hx_lambda(array(&$cb, &$f, &$gather, &$this1), "tink_core__Signal_Signal_Impl__7"), 'execute')));
	}
}
function tink_core__Signal_Signal_Impl__1(&$f, &$gather, &$this1, $cb) {
	{
		return call_user_func_array($this1, array(array(new _hx_lambda(array(&$cb, &$f, &$gather, &$this1), "tink_core__Signal_Signal_Impl__8"), 'execute')));
	}
}
function tink_core__Signal_Signal_Impl__2(&$f, &$gather, &$this1, $cb) {
	{
		return call_user_func_array($this1, array(array(new _hx_lambda(array(&$cb, &$f, &$gather, &$this1), "tink_core__Signal_Signal_Impl__9"), 'execute')));
	}
}
function tink_core__Signal_Signal_Impl__3(&$gather, &$other, &$this1, $cb) {
	{
		return tink_core__Callback_CallbackLink_Impl_::fromMany((new _hx_array(array(call_user_func_array($this1, array($cb)), call_user_func_array($other, array($cb))))));
	}
}
function tink_core__Signal_Signal_Impl__4(&$this1, $_) {
	{
		return tink_core_Noise::$Noise;
	}
}
function tink_core__Signal_Signal_Impl__5(&$ret, &$this1, $x) {
	{
		tink_core__Callback_CallbackList_Impl_::invoke($ret, $x);
	}
}
function tink_core__Signal_Signal_Impl__6(&$add, &$gather, &$remove, $cb) {
	{
		$f = array(new _hx_lambda(array(&$add, &$cb, &$gather, &$remove), "tink_core__Signal_Signal_Impl__10"), 'execute');
		call_user_func_array($add, array($f));
		return tink_core__Signal_Signal_Impl__11($add, $cb, $f, $gather, $remove);
	}
}
function tink_core__Signal_Signal_Impl__7(&$cb, &$f, &$gather, &$this1, $result) {
	{
		$data = call_user_func_array($f, array($result));
		call_user_func_array($cb, array($data));
	}
}
function tink_core__Signal_Signal_Impl__8(&$cb, &$f, &$gather, &$this1, $result) {
	{
		$this2 = call_user_func_array($f, array($result));
		call_user_func_array($this2, array($cb));
	}
}
function tink_core__Signal_Signal_Impl__9(&$cb, &$f, &$gather, &$this1, $result) {
	{
		if(call_user_func_array($f, array($result))) {
			call_user_func_array($cb, array($result));
		}
	}
}
function tink_core__Signal_Signal_Impl__10(&$add, &$cb, &$gather, &$remove, $a) {
	{
		call_user_func_array($cb, array($a));
	}
}
function tink_core__Signal_Signal_Impl__11(&$add, &$cb, &$f, &$gather, &$remove) {
	{
		$f1 = $remove;
		$a1 = $f;
		return array(new _hx_lambda(array(&$a1, &$add, &$cb, &$f, &$f1, &$gather, &$remove), "tink_core__Signal_Signal_Impl__12"), 'execute');
	}
}
function tink_core__Signal_Signal_Impl__12(&$a1, &$add, &$cb, &$f, &$f1, &$gather, &$remove) {
	{
		call_user_func_array($f1, array($a1));
		return;
	}
}
