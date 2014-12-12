<?php

class ufront_web_session_VoidSession implements ufront_web_session_UFHttpSession{
	public function __construct() {
		;
	}
	public $id;
	public function setExpiry($e) {
	}
	public function init() {
		return tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Success(tink_core_Noise::$Noise));
	}
	public function commit() {
		return tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Success(tink_core_Noise::$Noise));
	}
	public function triggerCommit() {
	}
	public function isActive() {
		return false;
	}
	public function get($name) {
		return null;
	}
	public function set($name, $value) {
	}
	public function exists($name) {
		return false;
	}
	public function remove($name) {
	}
	public function clear() {
	}
	public function regenerateID() {
		return tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Success(""));
	}
	public function close() {
	}
	public function get_id() {
		return "";
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
	static $__properties__ = array("get_id" => "get_id");
	function __toString() { return 'ufront.web.session.VoidSession'; }
}
