<?php

class ufront_core_Sync {
	public function __construct(){}
	static function success() {
		if(ufront_core_Sync::$s === null) {
			ufront_core_Sync::$s = tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Success(tink_core_Noise::$Noise));
		}
		return ufront_core_Sync::$s;
	}
	static $s;
	static function httpError($msg = null, $err = null, $p = null) {
		return tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Failure(ufront_web_HttpError::wrap($err, $msg, $p)));
	}
	static function of($v) {
		return tink_core__Future_Future_Impl_::sync($v);
	}
	function __toString() { return 'ufront.core.Sync'; }
}
