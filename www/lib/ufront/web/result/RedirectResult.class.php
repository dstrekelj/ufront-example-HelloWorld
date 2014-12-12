<?php

class ufront_web_result_RedirectResult extends ufront_web_result_ActionResult {
	public function __construct($url, $permanentRedirect = null) {
		if(!php_Boot::$skip_constructor) {
		if($permanentRedirect === null) {
			$permanentRedirect = false;
		}
		if(null === $url) {
			throw new HException(new thx_error_NullArgument("url", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "RedirectResult.hx", "lineNumber" => 17, "className" => "ufront.web.result.RedirectResult", "methodName" => "new"))));
		}
		$this->url = $url;
		$this->permanentRedirect = $permanentRedirect;
	}}
	public $url;
	public $permanentRedirect;
	public function executeResult($actionContext) {
		$actionContext->httpContext->response->clearContent();
		$actionContext->httpContext->response->clearHeaders();
		if($this->permanentRedirect) {
			$actionContext->httpContext->response->permanentRedirect($this->url);
		} else {
			$actionContext->httpContext->response->redirect($this->url);
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
	function __toString() { return 'ufront.web.result.RedirectResult'; }
}
