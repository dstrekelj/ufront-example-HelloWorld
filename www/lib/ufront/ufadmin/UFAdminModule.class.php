<?php

class ufront_ufadmin_UFAdminModule extends ufront_web_Controller {
	public function __construct($slug, $title) {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$this->slug = $slug;
		$this->title = $title;
	}}
	public $slug;
	public $title;
	public function thisIsAWorkaround() {
	}
	public function checkPermissions() {
		return true;
	}
	public function execute() {
		$uriParts = $this->context->actionContext->get_uriParts();
		$this->setBaseUri($uriParts);
		$params = $this->context->request->get_params();
		$method = $this->context->request->get_httpMethod();
		$this->context->actionContext->controller = $this;
		$this->context->actionContext->action = "execute";
		try {
			if(1 === $uriParts->length && $uriParts[0] === "this-is-a-workaround") {
				$this->context->actionContext->action = "thisIsAWorkaround";
				$this->context->actionContext->args = (new _hx_array(array()));
				$this->context->actionContext->get_uriParts()->splice(0, 1);
				$this->thisIsAWorkaround();
				$result = $this->wrapResult(null, 0);
				$this->setContextActionResultWhenFinished($result);
				return $result;
			}
			throw new HException(ufront_web_HttpError::pageNotFound(_hx_anonymous(array("fileName" => "ControllerMacros.hx", "lineNumber" => 433, "className" => "ufront.ufadmin.UFAdminModule", "methodName" => "execute"))));
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				return ufront_core_Sync::httpError("Uncaught error while executing " . Std::string($this->context->actionContext->controller) . "." . _hx_string_or_null($this->context->actionContext->action) . "()", $e, _hx_anonymous(array("fileName" => "ControllerMacros.hx", "lineNumber" => 436, "className" => "ufront.ufadmin.UFAdminModule", "methodName" => "execute")));
			}
		}
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
	static function __meta__() { $args = func_get_args(); return call_user_func_array(self::$__meta__, $args); }
	static $__meta__;
	static function wrapInLayout($title, $template, $data) {
		return _hx_deref(new ufront_web_result_ViewResult($data, null, null))->setVar("title", $title)->usingTemplateString($template, "<!DOCTYPE html>\x0A<html>\x0A<head>\x0A\x09<title>::title::</title>\x0A\x09<base href=\"::server::::prefix::\" />\x0A\x09<link href=\"http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css\" rel=\"stylesheet\" />\x0A</head>\x0A<body>\x0A\x09<div class=\"container\">\x0A\x09\x09::viewContent::\x0A\x09</div>\x0A</body>\x0A</html>", null);
	}
	function __toString() { return 'ufront.ufadmin.UFAdminModule'; }
}
ufront_ufadmin_UFAdminModule::$__meta__ = _hx_anonymous(array("fields" => _hx_anonymous(array("thisIsAWorkaround" => _hx_anonymous(array("wrapResult" => (new _hx_array(array(7)))))))));
