<?php

class ufront_auth_EasyAuthDBAdapter implements ufront_auth_UFAuthAdapterSync, ufront_auth_UFAuthAdapter{
	public function __construct($username, $password) {
		if(!php_Boot::$skip_constructor) {
		$this->suppliedUsername = $username;
		$this->suppliedPassword = $password;
	}}
	public $suppliedUsername;
	public $suppliedPassword;
	public function authenticateSync() {
		if($this->suppliedUsername === null) {
			return tink_core_Outcome::Failure(ufront_auth_AuthError::LoginFailed("No username was supplied"));
		}
		if($this->suppliedPassword === null) {
			return tink_core_Outcome::Failure(ufront_auth_AuthError::LoginFailed("No password was supplied"));
		}
		$u = ufront_auth_model_User::$manager->unsafeObjects("SELECT * FROM auth_user WHERE username = " . _hx_string_or_null(sys_db_Manager::quoteAny($this->suppliedUsername)), true)->first();
		if($u !== null && strlen($u->password) === 0 && strlen($u->salt) === 0) {
			return tink_core_Outcome::Failure(ufront_auth_AuthError::LoginFailed("This user has not finished setting up their password."));
		}
		if($u !== null && $u->password === ufront_auth_model_User::generatePasswordHash($this->suppliedPassword, $u->salt)) {
			return tink_core_Outcome::Success($u);
		} else {
			return tink_core_Outcome::Failure(ufront_auth_AuthError::LoginFailed("Username or password was incorrect."));
		}
	}
	public function authenticate() {
		return tink_core__Future_Future_Impl_::sync($this->authenticateSync());
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
	function __toString() { return 'ufront.auth.EasyAuthDBAdapter'; }
}
