<?php

class ufront_web_DefaultUfrontController extends ufront_web_Controller {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function showMessage() {
		{
			$pos = _hx_anonymous(array("fileName" => "UfrontConfiguration.hx", "lineNumber" => 254, "className" => "ufront.web.DefaultUfrontController", "methodName" => "showMessage"));
			if($this->context !== null) {
				$this->context->messages->push(_hx_anonymous(array("msg" => "Your Ufront App is almost ready.", "pos" => $pos, "type" => ufront_log_MessageType::$Trace)));
			} else {
				haxe_Log::trace("" . "Your Ufront App is almost ready.", $pos);
			}
		}
		return "<!DOCTYPE html>\x0A<html>\x0A<head>\x0A\x09<title>New Ufront App</title>\x0A\x09<link href=\"http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css\" rel=\"stylesheet\" />\x0A</head>\x0A<body style=\"padding-top: 30px;\">\x0A\x09<div class=\"container\">\x0A\x09\x09<div class=\"jumbotron\">\x0A\x09\x09\x09<h1>Almost done!</h1>\x0A\x09\x09\x09<p>Your new Ufront App is almost ready to go. You will need to add some routes and let ufront know about them:</p>\x0A\x09\x09\x09<pre><code>\x0A\x09app = new UfrontApplication({\x0A\x09\x09indexController: MySiteController,\x0A\x09});\x0A\x09app.execute();\x0A\x09\x09\x09</code></pre>\x0A\x09\x09\x09<p>See the Getting Started tutorial for more information.</p>\x0A\x09\x09</div>\x0A\x09</div>\x0A</body>\x0A</html>";
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
				$this->context->actionContext->action = "showMessage";
				$this->context->actionContext->args = (new _hx_array(array()));
				$this->context->actionContext->get_uriParts()->splice(0, 0);
				$wrappingRequired = haxe_rtti_Meta::getFields(_hx_qtype("ufront.web.DefaultUfrontController"))->showMessage->wrapResult[0];
				$result = $this->wrapResult($this->showMessage(), $wrappingRequired);
				$this->setContextActionResultWhenFinished($result);
				return $result;
			}
			throw new HException(ufront_web_HttpError::pageNotFound(_hx_anonymous(array("fileName" => "ControllerMacros.hx", "lineNumber" => 433, "className" => "ufront.web.DefaultUfrontController", "methodName" => "execute"))));
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				return ufront_core_Sync::httpError("Uncaught error while executing " . Std::string($this->context->actionContext->controller) . "." . _hx_string_or_null($this->context->actionContext->action) . "()", $e, _hx_anonymous(array("fileName" => "ControllerMacros.hx", "lineNumber" => 436, "className" => "ufront.web.DefaultUfrontController", "methodName" => "execute")));
			}
		}
	}
	static function __meta__() { $args = func_get_args(); return call_user_func_array(self::$__meta__, $args); }
	static $__meta__;
	function __toString() { return 'ufront.web.DefaultUfrontController'; }
}
ufront_web_DefaultUfrontController::$__meta__ = _hx_anonymous(array("fields" => _hx_anonymous(array("showMessage" => _hx_anonymous(array("wrapResult" => (new _hx_array(array(7)))))))));
