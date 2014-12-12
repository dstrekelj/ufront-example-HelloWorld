<?php

class ufront_web_result_ActionResult {
	public function __construct(){}
	public function executeResult($actionContext) {
		return ufront_core_Sync::success();
	}
	static function wrap($resultValue) {
		if($resultValue === null) {
			return new ufront_web_result_EmptyResult(null);
		} else {
			$actionResultValue = Types::has($resultValue, _hx_qtype("ufront.web.result.ActionResult"));
			if($actionResultValue === null) {
				$actionResultValue = new ufront_web_result_ContentResult(Std::string($resultValue), null);
			}
			return $actionResultValue;
		}
	}
	function __toString() { return 'ufront.web.result.ActionResult'; }
}
