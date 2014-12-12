<?php

class tink_core__Callback_Cell {
	public function __construct() {
		;
	}
	public $cb;
	public function free() {
		$this->cb = null;
		tink_core__Callback_Cell::$pool->push($this);
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
	static $pool;
	static function get() {
		if(tink_core__Callback_Cell::$pool->length > 0) {
			return tink_core__Callback_Cell::$pool->pop();
		} else {
			return new tink_core__Callback_Cell();
		}
	}
	function __toString() { return 'tink.core._Callback.Cell'; }
}
tink_core__Callback_Cell::$pool = (new _hx_array(array()));
