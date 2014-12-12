<?php

class ufront_handler_RemotingHandler implements ufront_app_UFInitRequired, ufront_app_UFRequestHandler{
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->apiContexts = new HList();
		$this->apis = new HList();
	}}
	public $apiContexts;
	public $apis;
	public $context;
	public function loadApi($api) {
		$this->apis->push($api);
	}
	public function loadApis($newAPIs) {
		if(null == $newAPIs) throw new HException('null iterable');
		$__hx__it = $newAPIs->iterator();
		while($__hx__it->hasNext()) {
			$api = $__hx__it->next();
			$this->apis->push($api);
		}
	}
	public function loadApiContext($apiContext) {
		$this->apiContexts->push($apiContext);
	}
	public function init($app) {
		$ufApp = Std::instance($app, _hx_qtype("ufront.app.UfrontApplication"));
		if($ufApp !== null) {
			if(null == $ufApp->configuration->apis) throw new HException('null iterable');
			$__hx__it = $ufApp->configuration->apis->iterator();
			while($__hx__it->hasNext()) {
				$api = $__hx__it->next();
				$this->apis->push($api);
			}
			$this->apiContexts->push($ufApp->configuration->remotingApi);
		}
		return ufront_core_Sync::success();
	}
	public function dispose($app) {
		$this->apiContexts = null;
		return ufront_core_Sync::success();
	}
	public function handleRequest($httpContext) {
		$doneTrigger = new tink_core_FutureTrigger();
		if(ufront_handler_RemotingHandler_0($this, $doneTrigger, $httpContext)) {
			$r = $httpContext->response;
			$remotingResponse = null;
			$r->setOk();
			try {
				$this->initializeContext($httpContext->injector);
				$params = $httpContext->request->get_params();
				if(!$params->exists("__x")) {
					throw new HException("Remoting call did not have parameter `__x` which describes which API call to make.  Aborting");
				}
				$u = new haxe_Unserializer(ufront_core__MultiValueMap_MultiValueMap_Impl_::get($params, "__x"));
				$path = $u->unserialize();
				$args = $u->unserialize();
				$apiCallFinished = $this->executeApiCall($path, $args, $this->context, $httpContext->actionContext);
				$remotingResponse = tink_core__Future_Future_Impl_::map($apiCallFinished, array(new _hx_lambda(array(&$apiCallFinished, &$args, &$doneTrigger, &$httpContext, &$params, &$path, &$r, &$remotingResponse, &$u), "ufront_handler_RemotingHandler_1"), 'execute'), null);
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e = $_ex_;
				{
					$r->setInternalError();
					$remotingResponse = tink_core__Future_Future_Impl_::sync($this->remotingError($e, $httpContext));
				}
			}
			call_user_func_array($remotingResponse, array(array(new _hx_lambda(array(&$doneTrigger, &$e, &$httpContext, &$r, &$remotingResponse), "ufront_handler_RemotingHandler_2"), 'execute')));
		} else {
			$result1 = tink_core_Outcome::Success(tink_core_Noise::$Noise);
			if($doneTrigger->{"list"} === null) {
				false;
			} else {
				$list1 = $doneTrigger->{"list"};
				$doneTrigger->{"list"} = null;
				$doneTrigger->result = $result1;
				tink_core__Callback_CallbackList_Impl_::invoke($list1, $result1);
				tink_core__Callback_CallbackList_Impl_::clear($list1);
				true;
			}
		}
		return $doneTrigger->future;
	}
	public function initializeContext($injector) {
		$this->context = new haxe_remoting_Context();
		if(null == $this->apiContexts) throw new HException('null iterable');
		$__hx__it = $this->apiContexts->iterator();
		while($__hx__it->hasNext()) {
			$apiContextClass = $__hx__it->next();
			$apiContext = $injector->instantiate($apiContextClass);
			{
				$_g = 0;
				$_g1 = Reflect::fields($apiContext);
				while($_g < $_g1->length) {
					$fieldName = $_g1[$_g];
					++$_g;
					$api = Reflect::field($apiContext, $fieldName);
					if(Reflect::isObject($api)) {
						$this->context->addObject($fieldName, $api, null);
					}
					unset($fieldName,$api);
				}
				unset($_g1,$_g);
			}
			unset($apiContext);
		}
		if(null == $this->apis) throw new HException('null iterable');
		$__hx__it = $this->apis->iterator();
		while($__hx__it->hasNext()) {
			$apiClass = $__hx__it->next();
			$className = Type::getClassName($apiClass);
			$api1 = $injector->instantiate($apiClass);
			$this->context->addObject($className, $api1, null);
			unset($className,$api1);
		}
	}
	public function executeApiCall($path, $args, $remotingContext, $actionContext) {
		$actionContext->handler = $this;
		$actionContext->action = $path[$path->length - 1];
		$actionContext->controller = $remotingContext->objects->get($actionContext->action);
		$actionContext->args = $args;
		$returnType = null;
		try {
			$fieldsMeta = haxe_rtti_Meta::getFields(Type::getClass($actionContext->controller));
			$actionMeta = Reflect::field($fieldsMeta, $actionContext->action);
			$returnType = $actionMeta->returnType;
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$returnType = 0;
			}
		}
		$flags = $returnType;
		$result = $remotingContext->call($path, $args);
		if(($flags & 1 << ufront_api_ApiReturnType::$ARTFuture->index) !== 0) {
			return $result;
		} else {
			if(($flags & 1 << ufront_api_ApiReturnType::$ARTVoid->index) !== 0) {
				return tink_core__Future_Future_Impl_::sync(null);
			} else {
				return tink_core__Future_Future_Impl_::sync($result);
			}
		}
	}
	public function remotingError($e, $httpContext) {
		$httpContext->messages->push(_hx_anonymous(array("msg" => $e, "pos" => _hx_anonymous(array("fileName" => "RemotingHandler.hx", "lineNumber" => 183, "className" => "ufront.handler.RemotingHandler", "methodName" => "remotingError")), "type" => ufront_log_MessageType::$Error)));
		$s = new haxe_Serializer();
		$s->serializeException($e);
		$serializedException = "hxe" . _hx_string_or_null($s->toString());
		return $serializedException;
	}
	public function toString() {
		return "ufront.handler.RemotingHandler";
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
function ufront_handler_RemotingHandler_0(&$__hx__this, &$doneTrigger, &$httpContext) {
	{
		$this1 = $httpContext->request->get_clientHeaders();
		return $this1->exists("X-Haxe-Remoting");
	}
}
function ufront_handler_RemotingHandler_1(&$apiCallFinished, &$args, &$doneTrigger, &$httpContext, &$params, &$path, &$r, &$remotingResponse, &$u, $data) {
	{
		$s = new haxe_Serializer();
		$s->serialize($data);
		return "hxr" . _hx_string_or_null($s->toString());
	}
}
function ufront_handler_RemotingHandler_2(&$doneTrigger, &$e, &$httpContext, &$r, &$remotingResponse, $response) {
	{
		$r->set_contentType("application/x-haxe-remoting");
		$r->clearContent();
		$r->write($response);
		$httpContext->completion |= 1 << ufront_web_context_RequestCompletion::$CRequestHandlersComplete->index;
		{
			$result = tink_core_Outcome::Success(tink_core_Noise::$Noise);
			if($doneTrigger->{"list"} === null) {
				false;
			} else {
				$list = $doneTrigger->{"list"};
				$doneTrigger->{"list"} = null;
				$doneTrigger->result = $result;
				tink_core__Callback_CallbackList_Impl_::invoke($list, $result);
				tink_core__Callback_CallbackList_Impl_::clear($list);
				true;
			}
		}
	}
}
