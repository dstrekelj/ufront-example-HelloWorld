<?php

class ufront_middleware_InlineSessionMiddleware implements ufront_app_UFMiddleware{
	public function __construct() { 
	}
	public function requestIn($ctx) {
		if(ufront_middleware_InlineSessionMiddleware::$alwaysStart || $ctx->session->get_id() !== null) {
			return tink_core__Future_Future_Impl_::map($ctx->session->init(), array(new _hx_lambda(array(&$ctx), "ufront_middleware_InlineSessionMiddleware_0"), 'execute'), null);
		}
		return ufront_core_Sync::success();
	}
	public function responseOut($ctx) {
		if($ctx->session !== null) {
			return tink_core__Future_Future_Impl_::_map($ctx->session->commit(), array(new _hx_lambda(array(&$ctx), "ufront_middleware_InlineSessionMiddleware_1"), 'execute'));
		} else {
			return ufront_core_Sync::success();
		}
	}
	static $alwaysStart = false;
	function __toString() { return 'ufront.middleware.InlineSessionMiddleware'; }
}
function ufront_middleware_InlineSessionMiddleware_0(&$ctx, $outcome) {
	{
		switch($outcome->index) {
		case 0:{
			$s = $outcome->params[0];
			return tink_core_Outcome::Success($s);
		}break;
		case 1:{
			$f = $outcome->params[0];
			return tink_core_Outcome::Failure(ufront_web_HttpError::internalServerError($f, null, _hx_anonymous(array("fileName" => "InlineSessionMiddleware.hx", "lineNumber" => 35, "className" => "ufront.middleware.InlineSessionMiddleware", "methodName" => "requestIn"))));
		}break;
		}
	}
}
function ufront_middleware_InlineSessionMiddleware_1(&$ctx, $outcome) {
	{
		switch($outcome->index) {
		case 0:{
			$s = $outcome->params[0];
			return tink_core_Outcome::Success($s);
		}break;
		case 1:{
			$f = $outcome->params[0];
			return tink_core_Outcome::Failure(ufront_web_HttpError::internalServerError($f, null, _hx_anonymous(array("fileName" => "InlineSessionMiddleware.hx", "lineNumber" => 50, "className" => "ufront.middleware.InlineSessionMiddleware", "methodName" => "responseOut"))));
		}break;
		}
	}
}
