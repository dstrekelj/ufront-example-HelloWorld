<?php

class ufront_api_UFAsyncApi {
	public function __construct($api) {
		if(!php_Boot::$skip_constructor) {
		$this->api = $api;
	}}
	public $className;
	public $api;
	public function _makeApiCall($method, $args, $flags) {
		$_g = $this;
		$remotingCallString = "" . _hx_string_or_null($this->className) . "." . _hx_string_or_null($method) . "(" . _hx_string_or_null($args->join(",")) . ")";
		$callApi = array(new _hx_lambda(array(&$_g, &$args, &$flags, &$method, &$remotingCallString), "ufront_api_UFAsyncApi_0"), 'execute');
		$returnError = array(new _hx_lambda(array(&$_g, &$args, &$callApi, &$flags, &$method, &$remotingCallString), "ufront_api_UFAsyncApi_1"), 'execute');
		if(($flags & 1 << ufront_api_ApiReturnType::$ARTVoid->index) !== 0) {
			try {
				call_user_func($callApi);
				return tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Success(null));
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e1 = $_ex_;
				{
					return call_user_func_array($returnError, array($e1));
				}
			}
		} else {
			if(($flags & 1 << ufront_api_ApiReturnType::$ARTFuture->index) !== 0 && ($flags & 1 << ufront_api_ApiReturnType::$ARTOutcome->index) !== 0) {
				try {
					$surprise = call_user_func($callApi);
					return tink_core__Future_Future_Impl_::map($surprise, array(new _hx_lambda(array(&$_g, &$args, &$callApi, &$flags, &$method, &$remotingCallString, &$returnError, &$surprise), "ufront_api_UFAsyncApi_2"), 'execute'), null);
				}catch(Exception $__hx__e) {
					$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
					$e2 = $_ex_;
					{
						return call_user_func_array($returnError, array($e2));
					}
				}
			} else {
				if(($flags & 1 << ufront_api_ApiReturnType::$ARTFuture->index) !== 0) {
					try {
						$future = call_user_func($callApi);
						return tink_core__Future_Future_Impl_::map($future, array(new _hx_lambda(array(&$_g, &$args, &$callApi, &$flags, &$future, &$method, &$remotingCallString, &$returnError), "ufront_api_UFAsyncApi_3"), 'execute'), null);
					}catch(Exception $__hx__e) {
						$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
						$e3 = $_ex_;
						{
							return call_user_func_array($returnError, array($e3));
						}
					}
				} else {
					if(($flags & 1 << ufront_api_ApiReturnType::$ARTOutcome->index) !== 0) {
						try {
							$outcome = call_user_func($callApi);
							switch($outcome->index) {
							case 0:{
								$data2 = $outcome->params[0];
								tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Success($data2));
							}break;
							case 1:{
								$err1 = $outcome->params[0];
								tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Failure(haxe_remoting_RemotingError::ApiFailure($remotingCallString, $err1)));
							}break;
							}
							return tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Success(null));
						}catch(Exception $__hx__e) {
							$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
							$e4 = $_ex_;
							{
								return call_user_func_array($returnError, array($e4));
							}
						}
					} else {
						try {
							$result1 = call_user_func($callApi);
							return tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Success($result1));
						}catch(Exception $__hx__e) {
							$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
							$e5 = $_ex_;
							{
								return call_user_func_array($returnError, array($e5));
							}
						}
					}
				}
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
	function __toString() { return 'ufront.api.UFAsyncApi'; }
}
ufront_api_UFAsyncApi::$__meta__ = _hx_anonymous(array("fields" => _hx_anonymous(array("_" => _hx_anonymous(array("name" => (new _hx_array(array("new"))), "args" => (new _hx_array(array(_hx_anonymous(array("type" => "ufront.api.UFAsyncApi.T", "opt" => false))))), "inject" => null))))));
function ufront_api_UFAsyncApi_0(&$_g, &$args, &$flags, &$method, &$remotingCallString) {
	{
		return Reflect::callMethod($_g->api, Reflect::field($_g->api, $method), $args);
	}
}
function ufront_api_UFAsyncApi_1(&$_g, &$args, &$callApi, &$flags, &$method, &$remotingCallString, $e) {
	{
		$stack = haxe_CallStack::toString(haxe_CallStack::exceptionStack());
		return tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Failure(haxe_remoting_RemotingError::ServerSideException($remotingCallString, $e, $stack)));
	}
}
function ufront_api_UFAsyncApi_2(&$_g, &$args, &$callApi, &$flags, &$method, &$remotingCallString, &$returnError, &$surprise, $result) {
	{
		switch($result->index) {
		case 0:{
			$data = $result->params[0];
			return tink_core_Outcome::Success($data);
		}break;
		case 1:{
			$err = $result->params[0];
			return tink_core_Outcome::Failure(haxe_remoting_RemotingError::ApiFailure($remotingCallString, $err));
		}break;
		}
	}
}
function ufront_api_UFAsyncApi_3(&$_g, &$args, &$callApi, &$flags, &$future, &$method, &$remotingCallString, &$returnError, $data1) {
	{
		return tink_core_Outcome::Success($data1);
	}
}
