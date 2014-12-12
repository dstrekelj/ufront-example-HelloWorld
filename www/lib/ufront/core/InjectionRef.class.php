<?php

class ufront_core_InjectionRef {
	public function __construct($v) {
		if(!php_Boot::$skip_constructor) {
		$this->value = $v;
	}}
	public $value;
	public function get() {
		$v = $this->value;
		$this->value = null;
		ufront_core_InjectionRef::$pool->push($this);
		return $v;
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
	static function of($v) {
		if(ufront_core_InjectionRef::$pool->length > 0) {
			$r = ufront_core_InjectionRef::$pool->shift();
			$r->value = $v;
			return $r;
		} else {
			return new ufront_core_InjectionRef($v);
		}
	}
	function __toString() { return 'ufront.core.InjectionRef'; }
}
ufront_core_InjectionRef::$pool = (new _hx_array(array()));
