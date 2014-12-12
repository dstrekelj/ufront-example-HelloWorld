<?php

class ufront_web_Controller {
	public function __construct() {
		;
	}
	public $context;
	public $baseUri;
	public function execute() {
		return tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Failure(ufront_web_HttpError::internalServerError("Field execute() in ufront.web.Controller is an abstract method, please override it in " . _hx_string_or_null($this->toString()) . " ", null, _hx_anonymous(array("fileName" => "Controller.hx", "lineNumber" => 134, "className" => "ufront.web.Controller", "methodName" => "execute")))));
	}
	public function executeSubController($controller) {
		return $this->context->injector->instantiate($controller)->execute();
	}
	public function toString() {
		return Type::getClassName(Type::getClass($this));
	}
	public function ufTrace($msg, $pos = null) {
		if($this->context !== null) {
			$this->context->messages->push(_hx_anonymous(array("msg" => $msg, "pos" => $pos, "type" => ufront_log_MessageType::$Trace)));
		} else {
			haxe_Log::trace("" . Std::string($msg), $pos);
		}
	}
	public function ufLog($msg, $pos = null) {
		if($this->context !== null) {
			$this->context->messages->push(_hx_anonymous(array("msg" => $msg, "pos" => $pos, "type" => ufront_log_MessageType::$Log)));
		} else {
			haxe_Log::trace("Log: " . Std::string($msg), $pos);
		}
	}
	public function ufWarn($msg, $pos = null) {
		if($this->context !== null) {
			$this->context->messages->push(_hx_anonymous(array("msg" => $msg, "pos" => $pos, "type" => ufront_log_MessageType::$Warning)));
		} else {
			haxe_Log::trace("Warning: " . Std::string($msg), $pos);
		}
	}
	public function ufError($msg, $pos = null) {
		if($this->context !== null) {
			$this->context->messages->push(_hx_anonymous(array("msg" => $msg, "pos" => $pos, "type" => ufront_log_MessageType::$Error)));
		} else {
			haxe_Log::trace("Error: " . Std::string($msg), $pos);
		}
	}
	public function setBaseUri($uriPartsBeforeRouting) {
		$remainingUri = haxe_io_Path::addTrailingSlash($uriPartsBeforeRouting->join("/"));
		$fullUri = haxe_io_Path::addTrailingSlash($this->context->getRequestUri());
		$this->baseUri = haxe_io_Path::addTrailingSlash(_hx_substr($fullUri, 0, strlen($fullUri) - strlen($remainingUri)));
	}
	public function wrapResult($result, $wrappingRequired) {
		if($result === null) {
			$actionResult = new ufront_web_result_EmptyResult(true);
			return tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Success($actionResult));
		} else {
			$future = null;
			if(($wrappingRequired & 1 << ufront_web_WrapRequired::$WRFuture->index) !== 0) {
				$future = $this->wrapInFuture($result);
			} else {
				$future = $result;
			}
			$surprise = null;
			if(($wrappingRequired & 1 << ufront_web_WrapRequired::$WROutcome->index) !== 0) {
				$surprise = $this->wrapInOutcome($future);
			} else {
				$surprise = $future;
			}
			$finalResult = null;
			if(($wrappingRequired & 1 << ufront_web_WrapRequired::$WRResultOrError->index) !== 0) {
				$finalResult = $this->wrapResultOrError($surprise);
			} else {
				$finalResult = $surprise;
			}
			return $finalResult;
		}
	}
	public function wrapInFuture($result) {
		return tink_core__Future_Future_Impl_::sync($result);
	}
	public function wrapInOutcome($future) {
		return tink_core__Future_Future_Impl_::map($future, array(new _hx_lambda(array(&$future), "ufront_web_Controller_0"), 'execute'), null);
	}
	public function wrapResultOrError($surprise) {
		return tink_core__Future_Future_Impl_::map($surprise, array(new _hx_lambda(array(&$surprise), "ufront_web_Controller_1"), 'execute'), null);
	}
	public function setContextActionResultWhenFinished($result) {
		$_g = $this;
		call_user_func_array($result, array(array(new _hx_lambda(array(&$_g, &$result), "ufront_web_Controller_2"), 'execute')));
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
	function __toString() { return $this->toString(); }
}
ufront_web_Controller::$__meta__ = _hx_anonymous(array("fields" => _hx_anonymous(array("context" => _hx_anonymous(array("name" => (new _hx_array(array("context"))), "type" => (new _hx_array(array("ufront.web.context.HttpContext"))), "inject" => null))))));
function ufront_web_Controller_0(&$future, $result) {
	{
		return tink_core_Outcome::Success($result);
	}
}
function ufront_web_Controller_1(&$surprise, $outcome) {
	{
		switch($outcome->index) {
		case 0:{
			$result = $outcome->params[0];
			return tink_core_Outcome::Success(ufront_web_result_ActionResult::wrap($result));
		}break;
		case 1:{
			$error = $outcome->params[0];
			return tink_core_Outcome::Failure(ufront_web_HttpError::wrap($error, null, _hx_anonymous(array("fileName" => "Controller.hx", "lineNumber" => 228, "className" => "ufront.web.Controller", "methodName" => "wrapResultOrError"))));
		}break;
		}
	}
}
function ufront_web_Controller_2(&$_g, &$result, $outcome) {
	{
		switch($outcome->index) {
		case 0:{
			$ar = $outcome->params[0];
			$_g->context->actionContext->actionResult = $ar;
		}break;
		default:{
		}break;
		}
	}
}
