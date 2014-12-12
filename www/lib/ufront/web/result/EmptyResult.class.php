<?php

class ufront_web_result_EmptyResult extends ufront_web_result_ActionResult {
	public function __construct($preventFlush = null) {
		if(!php_Boot::$skip_constructor) {
		if($preventFlush === null) {
			$preventFlush = false;
		}
		$this->preventFlush = $preventFlush;
	}}
	public $preventFlush;
	public function executeResult($actionContext) {
		if($this->preventFlush) {
			$actionContext->httpContext->response->preventFlush();
		}
		return ufront_core_Sync::success();
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
	function __toString() { return 'ufront.web.result.EmptyResult'; }
}
