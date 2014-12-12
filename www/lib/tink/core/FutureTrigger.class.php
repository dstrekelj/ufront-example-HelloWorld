<?php

class tink_core_FutureTrigger {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$_g = $this;
		$this->{"list"} = (new _hx_array(array()));
		$this->future = tink_core__Future_Future_Impl_::_new(array(new _hx_lambda(array(&$_g), "tink_core_FutureTrigger_0"), 'execute'));
	}}
	public $result;
	public $list;
	public $future;
	public function asFuture() {
		return $this->future;
	}
	public function trigger($result) {
		if($this->{"list"} === null) {
			return false;
		} else {
			$list = $this->{"list"};
			$this->{"list"} = null;
			$this->result = $result;
			tink_core__Callback_CallbackList_Impl_::invoke($list, $result);
			tink_core__Callback_CallbackList_Impl_::clear($list);
			return true;
		}
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->__dynamics[$m]) && is_callable($this->__dynamics[$m]))
			return call_user_func_array($this->__dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call <'.$m.'>');
	}
	function __toString() { return 'tink.core.FutureTrigger'; }
}
function tink_core_FutureTrigger_0(&$_g, $callback) {
	{
		if($_g->{"list"} === null) {
			call_user_func_array($callback, array($_g->result));
			return null;
		} else {
			return tink_core__Callback_CallbackList_Impl_::add($_g->{"list"}, $callback);
		}
	}
}
