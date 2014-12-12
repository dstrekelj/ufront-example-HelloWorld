<?php

class ufront_auth_NobodyAuthHandler implements ufront_auth_UFAuthHandler{
	public function __construct() {
		;
	}
	public function isLoggedIn() {
		return false;
	}
	public function requireLogin() {
		throw new HException(ufront_auth_AuthError::$NotLoggedIn);
	}
	public function isLoggedInAs($user) {
		return false;
	}
	public function requireLoginAs($user) {
		throw new HException(ufront_auth_AuthError::NotLoggedInAs($user));
	}
	public function hasPermission($permission) {
		return false;
	}
	public function hasPermissions($permissions) {
		return false;
	}
	public function requirePermission($permission) {
		throw new HException(ufront_auth_AuthError::NoPermission($permission));
	}
	public function requirePermissions($permissions) {
		if(null == $permissions) throw new HException('null iterable');
		$__hx__it = $permissions->iterator();
		while($__hx__it->hasNext()) {
			$p = $__hx__it->next();
			throw new HException(ufront_auth_AuthError::NoPermission($p));
		}
	}
	public function getUserByID($id) {
		return null;
	}
	public function setCurrentUser($u) {
		throw new HException("Nobodies cannot become somebodies. It's against the rules!");
	}
	public function toString() {
		return "NobodyAuthHandler";
	}
	public function get_currentUser() {
		return null;
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
	static $__properties__ = array("get_currentUser" => "get_currentUser");
	function __toString() { return $this->toString(); }
}
