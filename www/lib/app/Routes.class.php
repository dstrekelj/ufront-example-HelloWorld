<?php

class app_Routes extends ufront_web_Controller {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function index($name = null) {
		if($name === null) {
			$name = "world";
		}
		$result = urldecode($name);
		return new ufront_web_result_ViewResult(app_Routes_0($this, $name, $result), null, null);
	}
	public function submit($args) {
		return new ufront_web_result_RedirectResult(_hx_string_or_null(Config::$app->basePath) . _hx_string_or_null($args->name), null);
	}
	public function execute() {
		$uriParts = $this->context->actionContext->get_uriParts();
		$this->setBaseUri($uriParts);
		$params = $this->context->request->get_params();
		$method = $this->context->request->get_httpMethod();
		$this->context->actionContext->controller = $this;
		$this->context->actionContext->action = "execute";
		try {
			if(strtolower($method) === "get" && (0 <= $uriParts->length && 1 >= $uriParts->length)) {
				$name = null;
				if($uriParts[0] !== null && $uriParts[0] !== "") {
					$name = $uriParts[0];
				} else {
					$name = "world";
				}
				$this->context->actionContext->action = "index";
				$this->context->actionContext->args = (new _hx_array(array($name)));
				$this->context->actionContext->get_uriParts()->splice(0, 1);
				$wrappingRequired = haxe_rtti_Meta::getFields(_hx_qtype("app.Routes"))->index->wrapResult[0];
				$result = $this->wrapResult($this->index($name), $wrappingRequired);
				$this->setContextActionResultWhenFinished($result);
				return $result;
			} else {
				if(strtolower($method) === "post" && 2 === $uriParts->length && $uriParts[0] === "action" && $uriParts[1] === "submit") {
					if(!$params->exists("name")) {
						throw new HException(app_Routes_1($this, $method, $params, $uriParts));
					}
					$_param_tmp_name = ufront_core__MultiValueMap_MultiValueMap_Impl_::get($params, "name");
					$args = _hx_anonymous(array("name" => $_param_tmp_name));
					$this->context->actionContext->action = "submit";
					$this->context->actionContext->args = (new _hx_array(array($args)));
					$this->context->actionContext->get_uriParts()->splice(0, 2);
					$wrappingRequired1 = haxe_rtti_Meta::getFields(_hx_qtype("app.Routes"))->submit->wrapResult[0];
					$result1 = $this->wrapResult($this->submit($args), $wrappingRequired1);
					$this->setContextActionResultWhenFinished($result1);
					return $result1;
				}
			}
			throw new HException(ufront_web_HttpError::pageNotFound(_hx_anonymous(array("fileName" => "ControllerMacros.hx", "lineNumber" => 433, "className" => "app.Routes", "methodName" => "execute"))));
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				return ufront_core_Sync::httpError("Uncaught error while executing " . Std::string($this->context->actionContext->controller) . "." . _hx_string_or_null($this->context->actionContext->action) . "()", $e, _hx_anonymous(array("fileName" => "ControllerMacros.hx", "lineNumber" => 436, "className" => "app.Routes", "methodName" => "execute")));
			}
		}
	}
	static function __meta__() { $args = func_get_args(); return call_user_func_array(self::$__meta__, $args); }
	static $__meta__;
	function __toString() { return 'app.Routes'; }
}
app_Routes::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("viewFolder" => (new _hx_array(array("/"))))), "fields" => _hx_anonymous(array("index" => _hx_anonymous(array("wrapResult" => (new _hx_array(array(3))))), "submit" => _hx_anonymous(array("wrapResult" => (new _hx_array(array(3)))))))));
function app_Routes_0(&$__hx__this, &$name, &$result) {
	{
		$d = _hx_anonymous(array("greeting" => "Hello, " . _hx_string_or_null($result) . "!"));
		return (($d !== null) ? $d : _hx_anonymous(array()));
	}
}
function app_Routes_1(&$__hx__this, &$method, &$params, &$uriParts) {
	{
		$reason = "Missing parameter " . "name";
		$message = "Bad Request";
		if($reason !== null) {
			$message .= ": " . _hx_string_or_null($reason);
		}
		return new tink_core_TypedError(400, $message, _hx_anonymous(array("fileName" => "ControllerMacros.hx", "lineNumber" => 572, "className" => "app.Routes", "methodName" => "execute")));
	}
}
