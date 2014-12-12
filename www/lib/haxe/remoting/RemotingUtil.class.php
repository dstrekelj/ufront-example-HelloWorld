<?php

class haxe_remoting_RemotingUtil {
	public function __construct(){}
	static function processResponse($response, $onResult, $onError, $remotingCallString) {
		$ret = null;
		$stack = null;
		$hxrFound = false;
		$errors = (new _hx_array(array()));
		{
			$_g = 0;
			$_g1 = _hx_explode("\x0A", $response);
			while($_g < $_g1->length) {
				$line = $_g1[$_g];
				++$_g;
				if($line === "") {
					continue;
				}
				try {
					$_g2 = _hx_substr($line, 0, 3);
					switch($_g2) {
					case "hxr":{
						$s = new haxe_Unserializer(_hx_substr($line, 3, null));
						try {
							$ret = $s->unserialize();
						}catch(Exception $__hx__e) {
							$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
							$e = $_ex_;
							{
								throw new HException(haxe_remoting_RemotingError::UnserializeFailed($remotingCallString, _hx_substr($line, 3, null), "" . Std::string($e)));
							}
						}
						$hxrFound = true;
					}break;
					case "hxt":{
						$s1 = new haxe_Unserializer(_hx_substr($line, 3, null));
						$m = null;
						try {
							$m = $s1->unserialize();
						}catch(Exception $__hx__e) {
							$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
							$e1 = $_ex_;
							{
								throw new HException(haxe_remoting_RemotingError::UnserializeFailed($remotingCallString, _hx_substr($line, 3, null), "" . Std::string($e1)));
							}
						}
						$m->pos->fileName = "[R]" . _hx_string_or_null($m->pos->fileName);
						haxe_Log::trace("[" . Std::string($m->type) . "]" . Std::string($m->msg), $m->pos);
					}break;
					case "hxs":{
						$s2 = new haxe_Unserializer(_hx_substr($line, 3, null));
						try {
							$stack = $s2->unserialize();
						}catch(Exception $__hx__e) {
							$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
							$e2 = $_ex_;
							{
								throw new HException(haxe_remoting_RemotingError::UnserializeFailed($remotingCallString, _hx_substr($line, 3, null), "" . Std::string($e2)));
							}
						}
					}break;
					case "hxe":{
						$s3 = new haxe_Unserializer(_hx_substr($line, 3, null));
						try {
							$ret = $s3->unserialize();
						}catch(Exception $__hx__e) {
							$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
							$e3 = $_ex_;
							{
								throw new HException(haxe_remoting_RemotingError::ServerSideException($remotingCallString, $e3, $stack));
							}
						}
					}break;
					default:{
						throw new HException(haxe_remoting_RemotingError::UnserializeFailed($remotingCallString, $line, "Invalid line in response"));
					}break;
					}
					unset($_g2);
				}catch(Exception $__hx__e) {
					$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
					$err = $_ex_;
					{
						$errors->push($err);
					}
				}
				unset($line,$err);
			}
		}
		if($errors->length === 0) {
			if(false === $hxrFound) {
				throw new HException(haxe_remoting_RemotingError::NoRemotingResult($remotingCallString, $response));
			}
			try {
				call_user_func_array($onResult, array($ret));
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e4 = $_ex_;
				{
					call_user_func_array($onError, array(haxe_remoting_RemotingError::ClientCallbackException($remotingCallString, $e4)));
				}
			}
		} else {
			$_g3 = 0;
			while($_g3 < $errors->length) {
				$err1 = $errors[$_g3];
				++$_g3;
				call_user_func_array($onError, array($err1));
				unset($err1);
			}
		}
	}
	static function wrapErrorHandler($errorHandler) {
		return array(new _hx_lambda(array(&$errorHandler), "haxe_remoting_RemotingUtil_0"), 'execute');
	}
	function __toString() { return 'haxe.remoting.RemotingUtil'; }
}
function haxe_remoting_RemotingUtil_0(&$errorHandler, $e) {
	{
		if(Std::is($e, _hx_qtype("haxe.remoting.RemotingError"))) {
			call_user_func_array($errorHandler, array($e));
		} else {
			call_user_func_array($errorHandler, array(haxe_remoting_RemotingError::UnknownException($e)));
		}
	}
}
