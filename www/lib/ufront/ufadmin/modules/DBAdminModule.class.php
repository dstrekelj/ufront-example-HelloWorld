<?php

class ufront_ufadmin_modules_DBAdminModule extends ufront_ufadmin_UFAdminModule {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct("db","Database Admin");
	}}
	public function checkPermissions() {
		return true;
	}
	public function doDefault() {
		if(sys_db_Manager::$cnx === null) {
			return "No Database Connection Found";
		} else {
			spadm_AdminStyle::$BASE_URL = $this->baseUri;
			ufront_spadm_DBAdmin::handler($this->baseUri);
			$this->context->completion |= 1 << ufront_web_context_RequestCompletion::$CRequestHandlersComplete->index;
			$this->context->completion |= 1 << ufront_web_context_RequestCompletion::$CFlushComplete->index;
			return null;
		}
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
				$this->context->actionContext->action = "doDefault";
				$this->context->actionContext->args = (new _hx_array(array()));
				$this->context->actionContext->get_uriParts()->splice(0, 0);
				$wrappingRequired = haxe_rtti_Meta::getFields(_hx_qtype("ufront.ufadmin.modules.DBAdminModule"))->doDefault->wrapResult[0];
				$result = $this->wrapResult($this->doDefault(), $wrappingRequired);
				$this->setContextActionResultWhenFinished($result);
				return $result;
			}
			throw new HException(ufront_web_HttpError::pageNotFound(_hx_anonymous(array("fileName" => "ControllerMacros.hx", "lineNumber" => 433, "className" => "ufront.ufadmin.modules.DBAdminModule", "methodName" => "execute"))));
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				return ufront_core_Sync::httpError("Uncaught error while executing " . Std::string($this->context->actionContext->controller) . "." . _hx_string_or_null($this->context->actionContext->action) . "()", $e, _hx_anonymous(array("fileName" => "ControllerMacros.hx", "lineNumber" => 436, "className" => "ufront.ufadmin.modules.DBAdminModule", "methodName" => "execute")));
			}
		}
	}
	static function __meta__() { $args = func_get_args(); return call_user_func_array(self::$__meta__, $args); }
	static $__meta__;
	function __toString() { return 'ufront.ufadmin.modules.DBAdminModule'; }
}
ufront_ufadmin_modules_DBAdminModule::$__meta__ = _hx_anonymous(array("fields" => _hx_anonymous(array("doDefault" => _hx_anonymous(array("wrapResult" => (new _hx_array(array(7)))))))));
