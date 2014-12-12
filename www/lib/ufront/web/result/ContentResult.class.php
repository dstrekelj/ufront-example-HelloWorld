<?php

class ufront_web_result_ContentResult extends ufront_web_result_ActionResult {
	public function __construct($content = null, $contentType = null) {
		if(!php_Boot::$skip_constructor) {
		$this->content = $content;
		$this->contentType = $contentType;
	}}
	public $content;
	public $contentType;
	public function executeResult($actionContext) {
		if(null !== $this->contentType) {
			$actionContext->httpContext->response->set_contentType($this->contentType);
		}
		$actionContext->httpContext->response->write($this->content);
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
	function __toString() { return 'ufront.web.result.ContentResult'; }
}
