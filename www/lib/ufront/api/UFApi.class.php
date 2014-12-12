<?php

class ufront_api_UFApi {
	public function __construct() {
		;
	}
	public $auth;
	public $messages;
	public function ufTrace($msg, $pos = null) {
		$this->messages->push(_hx_anonymous(array("msg" => $msg, "pos" => $pos, "type" => ufront_log_MessageType::$Trace)));
	}
	public function ufLog($msg, $pos = null) {
		$this->messages->push(_hx_anonymous(array("msg" => $msg, "pos" => $pos, "type" => ufront_log_MessageType::$Log)));
	}
	public function ufWarn($msg, $pos = null) {
		$this->messages->push(_hx_anonymous(array("msg" => $msg, "pos" => $pos, "type" => ufront_log_MessageType::$Warning)));
	}
	public function ufError($msg, $pos = null) {
		$this->messages->push(_hx_anonymous(array("msg" => $msg, "pos" => $pos, "type" => ufront_log_MessageType::$Error)));
	}
	public function toString() {
		return Type::getClassName(Type::getClass($this));
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
	static function __meta__() { $args = func_get_args(); return call_user_func_array(self::$__meta__, $args); }
	static $__meta__;
	function __toString() { return $this->toString(); }
}
ufront_api_UFApi::$__meta__ = _hx_anonymous(array("fields" => _hx_anonymous(array("auth" => _hx_anonymous(array("name" => (new _hx_array(array("auth"))), "type" => (new _hx_array(array("ufront.auth.UFAuthHandler"))), "inject" => null)), "messages" => _hx_anonymous(array("name" => (new _hx_array(array("messages"))), "type" => (new _hx_array(array("ufront.log.MessageList"))), "inject" => null))))));
