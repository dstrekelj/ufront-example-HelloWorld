<?php

class tink_core__Signal_SignalTrigger_Impl_ {
	public function __construct(){}
	static function _new() {
		return (new _hx_array(array()));
	}
	static function trigger($this1, $event) {
		tink_core__Callback_CallbackList_Impl_::invoke($this1, $event);
	}
	static function getLength($this1) {
		return $this1->length;
	}
	static function asSignal($this1) {
		return tink_core__Signal_SignalTrigger_Impl__0($this1);
	}
	function __toString() { return 'tink.core._Signal.SignalTrigger_Impl_'; }
}
function tink_core__Signal_SignalTrigger_Impl__0(&$this1) {
	{
		$_e = $this1;
		return array(new _hx_lambda(array(&$_e, &$this1), "tink_core__Signal_SignalTrigger_Impl__1"), 'execute');
	}
}
function tink_core__Signal_SignalTrigger_Impl__1(&$_e, &$this1, $cb) {
	{
		return tink_core__Callback_CallbackList_Impl_::add($_e, $cb);
	}
}
