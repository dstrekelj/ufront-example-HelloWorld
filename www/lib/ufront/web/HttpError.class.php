<?php

class ufront_web_HttpError {
	public function __construct(){}
	static function wrap($e, $msg = null, $pos = null) {
		if($msg === null) {
			$msg = "Internal Server Error";
		}
		if(Std::is($e, _hx_qtype("tink.core.TypedError"))) {
			return $e;
		} else {
			return tink_core_TypedError::withData(500, $msg, $e, $pos);
		}
	}
	static function badRequest($reason = null, $pos = null) {
		$message = "Bad Request";
		if($reason !== null) {
			$message .= ": " . _hx_string_or_null($reason);
		}
		return new tink_core_TypedError(400, $message, $pos);
	}
	static function internalServerError($msg = null, $inner = null, $pos = null) {
		if($msg === null) {
			$msg = "Internal Server Error";
		}
		return tink_core_TypedError::withData(500, $msg, $inner, $pos);
	}
	static function methodNotAllowed($pos = null) {
		return new tink_core_TypedError(405, "Method Not Allowed", $pos);
	}
	static function pageNotFound($pos = null) {
		return new tink_core_TypedError(404, "Page Not Found", $pos);
	}
	static function unauthorized($pos = null) {
		return new tink_core_TypedError(401, "Unauthorized Access", $pos);
	}
	static function unprocessableEntity($pos = null) {
		return new tink_core_TypedError(422, "Unprocessable Entity", $pos);
	}
	static function fakePosition($obj, $method, $args = null) {
		return _hx_anonymous(array("methodName" => $method, "lineNumber" => -1, "fileName" => "", "customParams" => $args, "className" => Type::getClassName(Type::getClass($obj))));
	}
	function __toString() { return 'ufront.web.HttpError'; }
}
