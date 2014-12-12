<?php

class app_controller_IndexController extends ufront_web_Controller {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function index() {
		return "index";
	}
	public function test() {
		return "test";
	}
	public function execute() {
		$uriParts = $this->context->actionContext->get_uriParts();
		$this->setBaseUri($uriParts);
		$params = $this->context->request->get_params();
		$method = $this->context->request->get_httpMethod();
		$this->context->actionContext->controller = $this;
		$this->context->actionContext->action = "execute";
		try {
			{
				$this->context->actionContext->action = "index";
				$this->context->actionContext->args = (new _hx_array(array()));
				$this->context->actionContext->get_uriParts()->splice(0, 0);
				$wrappingRequired = haxe_rtti_Meta::getFields(_hx_qtype("app.controller.IndexController"))->index->wrapResult[0];
				$result = $this->wrapResult($this->index(), $wrappingRequired);
				$this->setContextActionResultWhenFinished($result);
				return $result;
			}
			throw new HException(ufront_web_HttpError::pageNotFound(_hx_anonymous(array("fileName" => "ControllerMacros.hx", "lineNumber" => 433, "className" => "app.controller.IndexController", "methodName" => "execute"))));
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				return ufront_core_Sync::httpError("Uncaught error while executing " . Std::string($this->context->actionContext->controller) . "." . _hx_string_or_null($this->context->actionContext->action) . "()", $e, _hx_anonymous(array("fileName" => "ControllerMacros.hx", "lineNumber" => 436, "className" => "app.controller.IndexController", "methodName" => "execute")));
			}
		}
	}
	static function __meta__() { $args = func_get_args(); return call_user_func_array(self::$__meta__, $args); }
	static $__meta__;
	function __toString() { return 'app.controller.IndexController'; }
}
app_controller_IndexController::$__meta__ = _hx_anonymous(array("fields" => _hx_anonymous(array("index" => _hx_anonymous(array("wrapResult" => (new _hx_array(array(7))))), "test" => _hx_anonymous(array("wrapResult" => (new _hx_array(array(7)))))))));
