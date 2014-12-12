<?php

class ufront_handler_MVCHandler implements ufront_app_UFInitRequired, ufront_app_UFRequestHandler{
	public function __construct() {
		;
	}
	public $indexController;
	public function init($application) {
		$ufApp = Std::instance($application, _hx_qtype("ufront.app.UfrontApplication"));
		if($ufApp !== null) {
			$this->indexController = $ufApp->configuration->indexController;
		}
		return ufront_core_Sync::success();
	}
	public function dispose($app) {
		$this->indexController = null;
		return ufront_core_Sync::success();
	}
	public function handleRequest($ctx) {
		$_g = $this;
		return tink_core__Future_Future_Impl_::_tryFailingFlatMap($this->processRequest($ctx), array(new _hx_lambda(array(&$_g, &$ctx), "ufront_handler_MVCHandler_0"), 'execute'));
	}
	public function processRequest($context) {
		$context->actionContext->handler = $this;
		$controller = $context->injector->instantiate($this->indexController);
		$resultFuture = tink_core__Future_Future_Impl_::_tryMap($controller->execute(), array(new _hx_lambda(array(&$context, &$controller), "ufront_handler_MVCHandler_1"), 'execute'));
		return $resultFuture;
	}
	public function executeResult($context) {
		try {
			return $context->actionContext->actionResult->executeResult($context->actionContext);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$p_methodName = "executeResult";
				$p_lineNumber = -1;
				$p_fileName = "";
				$p_customParams = (new _hx_array(array("actionContext")));
				$p_className = Type::getClassName(Type::getClass($context->actionContext));
				return tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Failure(ufront_web_HttpError::wrap($e, null, _hx_anonymous(array("fileName" => "MVCHandler.hx", "lineNumber" => 84, "className" => "ufront.handler.MVCHandler", "methodName" => "executeResult")))));
			}
		}
	}
	public function toString() {
		return "ufront.handler.MVCHandler";
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
	function __toString() { return $this->toString(); }
}
function ufront_handler_MVCHandler_0(&$_g, &$ctx, $r) {
	{
		return $_g->executeResult($ctx);
	}
}
function ufront_handler_MVCHandler_1(&$context, &$controller, $result) {
	{
		$context->actionContext->actionResult = $result;
		return tink_core_Noise::$Noise;
	}
}
