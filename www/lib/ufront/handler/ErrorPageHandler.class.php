<?php

class ufront_handler_ErrorPageHandler implements ufront_app_UFErrorHandler{
	public function __construct() {
		if(!isset($this->renderErrorContent)) $this->renderErrorContent = array(new _hx_lambda(array(&$this), "ufront_handler_ErrorPageHandler_0"), 'execute');
		if(!isset($this->renderErrorPage)) $this->renderErrorPage = array(new _hx_lambda(array(&$this), "ufront_handler_ErrorPageHandler_1"), 'execute');
		if(!php_Boot::$skip_constructor) {
		$this->catchErrors = true;
	}}
	public $catchErrors;
	public function handleError($httpError, $ctx) {
		$callStack = "";
		$inner = null;
		if($httpError !== null && _hx_field($httpError, "data") !== null) {
			$inner = " (" . Std::string($httpError->data) . ")";
		} else {
			$inner = "";
		}
		{
			$msg = "Handling error: " . Std::string($httpError) . _hx_string_or_null($inner) . " " . _hx_string_or_null($callStack);
			$ctx->messages->push(_hx_anonymous(array("msg" => $msg, "pos" => _hx_anonymous(array("fileName" => "ErrorPageHandler.hx", "lineNumber" => 53, "className" => "ufront.handler.ErrorPageHandler", "methodName" => "handleError")), "type" => ufront_log_MessageType::$Error)));
		}
		if(!(($ctx->completion & 1 << ufront_web_context_RequestCompletion::$CRequestHandlersComplete->index) !== 0)) {
			$showStack = false;
			$ctx->response->clear();
			$ctx->response->status = $httpError->code;
			$ctx->response->set_contentType("text/html");
			$ctx->response->write($this->renderError($httpError, $showStack));
			$ctx->completion |= 1 << ufront_web_context_RequestCompletion::$CRequestHandlersComplete->index;
		}
		if(!$this->catchErrors) {
			throw new HException($httpError);
		}
		return ufront_core_Sync::success();
	}
	public function renderErrorContent($error, $showStack = null) { return call_user_func_array($this->renderErrorContent, array($error, $showStack)); }
	public $renderErrorContent = null;
	public function renderErrorPage($title, $content) { return call_user_func_array($this->renderErrorPage, array($title, $content)); }
	public $renderErrorPage = null;
	public function renderError($error, $showStack = null) {
		$content = $this->renderErrorContent($error, $showStack);
		return $this->renderErrorPage($error->toString(), $content);
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
	static function errorStackItems($stack) {
		$arr = (new _hx_array(array()));
		$stack->pop();
		$stack = $stack->slice(2, null);
		$arr1 = _hx_explode("\x0A", haxe_CallStack::toString($stack));
		return $arr1;
	}
	function __toString() { return 'ufront.handler.ErrorPageHandler'; }
}
function ufront_handler_ErrorPageHandler_0(&$__hx__this, $error, $showStack) {
	{
		if($showStack === null) {
			$showStack = false;
		}
		$inner = null;
		if(null !== _hx_field($error, "data")) {
			$inner = "<p class=\"error-data\">" . Std::string($error->data) . "</p>";
		} else {
			$inner = "";
		}
		$pos = null;
		if($showStack) {
			$pos = "<p class=\"error-pos\">&gt; " . _hx_string_or_null($error->printPos()) . "</p>";
		} else {
			$pos = "";
		}
		$exceptionStackItems = ufront_handler_ErrorPageHandler::errorStackItems(haxe_CallStack::exceptionStack());
		$exceptionStack = null;
		if($showStack && $exceptionStackItems->length > 0) {
			$exceptionStack = "<div class=\"error-exception-stack\"><h3>Exception Stack:</h3>\x0A\x09\x09\x09\x09\x09<pre><code>" . _hx_string_or_null($exceptionStackItems->join("\x0A")) . "</pre></code>\x0A\x09\x09\x09\x09</div>";
		} else {
			$exceptionStack = "";
		}
		$content = "\x0A\x09\x09\x09<summary class=\"error-summary\"><h1 class=\"error-message\">" . _hx_string_or_null($error->message) . "</h1></summary>\x0A\x09\x09\x09<details class=\"error-details\"> " . _hx_string_or_null($inner) . " " . _hx_string_or_null($pos) . " " . _hx_string_or_null($exceptionStack) . "</details>\x0A\x09\x09";
		return $content;
	}
}
function ufront_handler_ErrorPageHandler_1(&$__hx__this, $title, $content) {
	{
		return "<!DOCTYPE html>\x0A<html>\x0A<head>\x0A\x09<title>" . _hx_string_or_null($title) . "</title>\x0A\x09<style>\x0A\x09\x09body {\x0A\x09\x09\x09font-family: sans-serif;\x0A\x09\x09}\x0A\x09\x09.container {\x0A\x09\x09\x09max-width: 800px;\x0A\x09\x09\x09margin: 30px auto;\x0A\x09\x09}\x0A\x09\x09.jumbotron {\x0A\x09\x09\x09padding: 30px;\x0A\x09\x09\x09border-radius: 30px;\x0A\x09\x09\x09background-color: rgb(230,230,230);\x0A\x09\x09}\x0A\x09\x09p[frown] {\x0A\x09\x09\x09text-align: center;\x0A\x09\x09}\x0A\x09\x09p[frown] span { \x0A\x09\x09\x09transform: rotate(90deg); \x0A\x09\x09\x09display: inline-block; \x0A\x09\x09\x09color: #bbb; \x0A\x09\x09\x09font-size: 3em;\x0A\x09\x09}\x0A\x09</style>\x0A</head>\x0A<body>\x0A\x09<div class=\"container\">\x0A\x09\x09<div class=\"jumbotron\">\x0A\x09\x09\x09<p frown><span>:(</span></p>\x0A\x09\x09\x09" . _hx_string_or_null($content) . "\x0A\x09\x09</div>\x0A\x09</div>\x0A</body>\x0A</html>";
	}
}
