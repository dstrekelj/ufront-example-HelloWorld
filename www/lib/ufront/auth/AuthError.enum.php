<?php

class ufront_auth_AuthError extends Enum {
	public static function LoginFailed($msg) { return new ufront_auth_AuthError("LoginFailed", 1, array($msg)); }
	public static function NoPermission($p) { return new ufront_auth_AuthError("NoPermission", 3, array($p)); }
	public static $NotLoggedIn;
	public static function NotLoggedInAs($u) { return new ufront_auth_AuthError("NotLoggedInAs", 2, array($u)); }
	public static $__constructors = array(1 => 'LoginFailed', 3 => 'NoPermission', 0 => 'NotLoggedIn', 2 => 'NotLoggedInAs');
	}
ufront_auth_AuthError::$NotLoggedIn = new ufront_auth_AuthError("NotLoggedIn", 0);
