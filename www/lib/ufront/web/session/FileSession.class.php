<?php

class ufront_web_session_FileSession implements ufront_web_session_UFHttpSession{
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->started = false;
		$this->commitFlag = false;
		$this->closeFlag = false;
		$this->regenerateFlag = false;
		$this->expiryFlag = false;
		$this->sessionData = null;
		$this->sessionID = null;
		$this->oldSessionID = null;
	}}
	public $started;
	public $commitFlag;
	public $closeFlag;
	public $regenerateFlag;
	public $expiryFlag;
	public $sessionID;
	public $oldSessionID;
	public $sessionData;
	public $context;
	public function injectConfig() {
		if($this->context->injector->hasMapping(_hx_qtype("String"), "sessionName")) {
			$this->sessionName = $this->context->injector->getInstance(_hx_qtype("String"), "sessionName");
		} else {
			$this->sessionName = ufront_web_session_FileSession::$defaultSessionName;
		}
		if($this->context->injector->hasMapping(_hx_qtype("ufront.core.InjectionRef"), "sessionExpiry")) {
			$this->expiry = $this->context->injector->getInstance(_hx_qtype("ufront.core.InjectionRef"), "sessionExpiry")->get();
		} else {
			$this->expiry = ufront_web_session_FileSession::$defaultExpiry;
		}
		if($this->context->injector->hasMapping(_hx_qtype("String"), "sessionSavePath")) {
			$this->savePath = $this->context->injector->getInstance(_hx_qtype("String"), "sessionSavePath");
		} else {
			$this->savePath = ufront_web_session_FileSession::$defaultSavePath;
		}
		$this->savePath = haxe_io_Path::addTrailingSlash($this->savePath);
		if(!StringTools::startsWith($this->savePath, "/")) {
			$this->savePath = _hx_string_or_null($this->context->get_contentDirectory()) . _hx_string_or_null($this->savePath);
		}
	}
	public $sessionName;
	public $expiry;
	public $savePath;
	public function setExpiry($e) {
		$this->expiry = $e;
	}
	public function init() {
		$t = new tink_core_FutureTrigger();
		if(!$this->started) {
			ufront_sys_SysUtil::mkdir(haxe_io_Path::removeTrailingSlashes($this->savePath));
			$file = null;
			$fileData = null;
			$this->get_id();
			if($this->sessionID !== null) {
				{
					$id = $this->get_id();
					if($id !== null) {
						if(!ufront_web_session_FileSession::$validID->match($id)) {
							throw new HException("Invalid session ID.");
						}
					}
				}
				{
					$id1 = $this->get_id();
					$file = "" . _hx_string_or_null($this->savePath) . _hx_string_or_null($id1) . ".sess";
				}
				if(!file_exists($file)) {
					$this->sessionID = null;
				} else {
					try {
						$fileData = sys_io_File::getContent($file);
					}catch(Exception $__hx__e) {
						$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
						$e = $_ex_;
						{
							$fileData = null;
						}
					}
					if($fileData !== null) {
						try {
							$this->sessionData = haxe_Unserializer::run($fileData);
						}catch(Exception $__hx__e) {
							$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
							$e1 = $_ex_;
							{
								{
									$msg = "Failed to unserialize session data, resetting session: " . Std::string($e1);
									$this->context->messages->push(_hx_anonymous(array("msg" => $msg, "pos" => _hx_anonymous(array("fileName" => "FileSession.hx", "lineNumber" => 199, "className" => "ufront.web.session.FileSession", "methodName" => "init")), "type" => ufront_log_MessageType::$Warning)));
								}
								$fileData = null;
							}
						}
					}
					if($fileData === null) {
						$this->sessionID = null;
						try {
							@unlink($file);
						}catch(Exception $__hx__e) {
							$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
							$e2 = $_ex_;
							{
							}
						}
					}
				}
			}
			if($this->sessionID === null) {
				$this->sessionData = new haxe_ds_StringMap();
				$this->started = true;
				$tryID = null;
				do {
					$tryID = Random::string(40, null);
					$file = _hx_string_or_null($this->savePath) . _hx_string_or_null($tryID) . ".sess";
				} while(file_exists($file));
				$this->sessionID = $tryID;
				sys_io_File::saveContent($file, "");
				$this->setCookie($tryID, $this->expiry);
				$this->commit();
			}
			$this->started = true;
			{
				$result = tink_core_Outcome::Success(tink_core_Noise::$Noise);
				if($t->{"list"} === null) {
					false;
				} else {
					$list = $t->{"list"};
					$t->{"list"} = null;
					$t->result = $result;
					tink_core__Callback_CallbackList_Impl_::invoke($list, $result);
					tink_core__Callback_CallbackList_Impl_::clear($list);
					true;
				}
			}
		} else {
			$result1 = tink_core_Outcome::Success(tink_core_Noise::$Noise);
			if($t->{"list"} === null) {
				false;
			} else {
				$list1 = $t->{"list"};
				$t->{"list"} = null;
				$t->result = $result1;
				tink_core__Callback_CallbackList_Impl_::invoke($list1, $result1);
				tink_core__Callback_CallbackList_Impl_::clear($list1);
				true;
			}
		}
		return $t->future;
	}
	public function setCookie($id, $expiryLength) {
		$expireAt = null;
		if($expiryLength <= 0) {
			$expireAt = null;
		} else {
			$d = Date::now();
			$expireAt = Date::fromTime($d->getTime() + 1000.0 * $expiryLength);
		}
		$path = "/";
		$domain = null;
		$secure = false;
		$sessionCookie = new ufront_web_HttpCookie($this->sessionName, $id, $expireAt, $domain, $path, $secure, null);
		if($expiryLength < 0) {
			$sessionCookie->expireNow();
		}
		$this->context->response->setCookie($sessionCookie);
	}
	public function commit() {
		$t = new tink_core_FutureTrigger();
		$handled = false;
		try {
			if($this->regenerateFlag) {
				$handled = true;
				rename("" . _hx_string_or_null($this->savePath) . _hx_string_or_null($this->oldSessionID) . ".sess", "" . _hx_string_or_null($this->savePath) . _hx_string_or_null($this->sessionID) . ".sess");
				$this->setCookie($this->sessionID, $this->expiry);
				{
					$result = tink_core_Outcome::Success(tink_core_Noise::$Noise);
					if($t->{"list"} === null) {
						false;
					} else {
						$list = $t->{"list"};
						$t->{"list"} = null;
						$t->result = $result;
						tink_core__Callback_CallbackList_Impl_::invoke($list, $result);
						tink_core__Callback_CallbackList_Impl_::clear($list);
						true;
					}
				}
			}
			if($this->commitFlag && $this->sessionData !== null) {
				$handled = true;
				$filePath = "" . _hx_string_or_null($this->savePath) . _hx_string_or_null($this->sessionID) . ".sess";
				$content = haxe_Serializer::run($this->sessionData);
				sys_io_File::saveContent($filePath, $content);
				{
					$result1 = tink_core_Outcome::Success(tink_core_Noise::$Noise);
					if($t->{"list"} === null) {
						false;
					} else {
						$list1 = $t->{"list"};
						$t->{"list"} = null;
						$t->result = $result1;
						tink_core__Callback_CallbackList_Impl_::invoke($list1, $result1);
						tink_core__Callback_CallbackList_Impl_::clear($list1);
						true;
					}
				}
			}
			if($this->closeFlag) {
				$handled = true;
				$this->setCookie("", -1);
				@unlink("" . _hx_string_or_null($this->savePath) . _hx_string_or_null($this->sessionID) . ".sess");
				{
					$result2 = tink_core_Outcome::Success(tink_core_Noise::$Noise);
					if($t->{"list"} === null) {
						false;
					} else {
						$list2 = $t->{"list"};
						$t->{"list"} = null;
						$t->result = $result2;
						tink_core__Callback_CallbackList_Impl_::invoke($list2, $result2);
						tink_core__Callback_CallbackList_Impl_::clear($list2);
						true;
					}
				}
			}
			if($this->expiryFlag) {
				$handled = true;
				$this->setCookie($this->sessionID, $this->expiry);
				{
					$result3 = tink_core_Outcome::Success(tink_core_Noise::$Noise);
					if($t->{"list"} === null) {
						false;
					} else {
						$list3 = $t->{"list"};
						$t->{"list"} = null;
						$t->result = $result3;
						tink_core__Callback_CallbackList_Impl_::invoke($list3, $result3);
						tink_core__Callback_CallbackList_Impl_::clear($list3);
						true;
					}
				}
			}
			if(!$handled) {
				$result4 = tink_core_Outcome::Success(tink_core_Noise::$Noise);
				if($t->{"list"} === null) {
					false;
				} else {
					$list4 = $t->{"list"};
					$t->{"list"} = null;
					$t->result = $result4;
					tink_core__Callback_CallbackList_Impl_::invoke($list4, $result4);
					tink_core__Callback_CallbackList_Impl_::clear($list4);
					true;
				}
			}
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$result5 = tink_core_Outcome::Failure("Unable to save session: " . Std::string($e));
				if($t->{"list"} === null) {
					false;
				} else {
					$list5 = $t->{"list"};
					$t->{"list"} = null;
					$t->result = $result5;
					tink_core__Callback_CallbackList_Impl_::invoke($list5, $result5);
					tink_core__Callback_CallbackList_Impl_::clear($list5);
					true;
				}
			}
		}
		return $t->future;
	}
	public function get($name) {
		if(!$this->started) {
			throw new HException("Trying to access session data before calling init()");
		}
		if($this->sessionData !== null) {
			return $this->sessionData->get($name);
		} else {
			return null;
		}
	}
	public function set($name, $value) {
		$this->init();
		if($this->sessionData !== null) {
			$this->sessionData->set($name, $value);
			$this->commitFlag = true;
		}
	}
	public function exists($name) {
		if(!($this->started && $this->get_id() !== null)) {
			return false;
		}
		if(!$this->started) {
			throw new HException("Trying to access session data before calling init()");
		}
		return $this->sessionData !== null && $this->sessionData->exists($name);
	}
	public function remove($name) {
		if(!$this->started) {
			throw new HException("Trying to access session data before calling init()");
		}
		if($this->sessionData !== null) {
			$this->sessionData->remove($name);
			$this->commitFlag = true;
		}
	}
	public function clear() {
		if($this->sessionData !== null && ($this->started && $this->get_id() !== null)) {
			$this->sessionData = new haxe_ds_StringMap();
			$this->commitFlag = true;
		}
	}
	public function triggerCommit() {
		$this->commitFlag = true;
	}
	public function regenerateID() {
		$t = new tink_core_FutureTrigger();
		$this->oldSessionID = $this->sessionID;
		$this->sessionID = Random::string(40, null);
		$this->regenerateFlag = true;
		{
			$result = tink_core_Outcome::Success($this->sessionID);
			if($t->{"list"} === null) {
				false;
			} else {
				$list = $t->{"list"};
				$t->{"list"} = null;
				$t->result = $result;
				tink_core__Callback_CallbackList_Impl_::invoke($list, $result);
				tink_core__Callback_CallbackList_Impl_::clear($list);
				true;
			}
		}
		return $t->future;
	}
	public function isActive() {
		return $this->started && $this->get_id() !== null;
	}
	public function get_id() {
		if($this->sessionID === null) {
			$this->sessionID = ufront_core__MultiValueMap_MultiValueMap_Impl_::get($this->context->request->get_cookies(), $this->sessionName);
		}
		if($this->sessionID === null) {
			$this->sessionID = ufront_core__MultiValueMap_MultiValueMap_Impl_::get($this->context->request->get_params(), $this->sessionName);
		}
		return $this->sessionID;
	}
	public function close() {
		$this->init();
		$this->sessionData = null;
		$this->closeFlag = true;
	}
	public function toString() {
		if($this->sessionData !== null) {
			return $this->sessionData->toString();
		} else {
			return "{}";
		}
	}
	public function getSessionFilePath($id) {
		return "" . _hx_string_or_null($this->savePath) . _hx_string_or_null($id) . ".sess";
	}
	public function generateSessionID() {
		return Random::string(40, null);
	}
	public function checkStarted() {
		if(!$this->started) {
			throw new HException("Trying to access session data before calling init()");
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
	static $defaultSessionName = "UfrontSessionID";
	static $defaultSavePath = "sessions/";
	static $defaultExpiry = 0;
	static $validID;
	static function testValidId($id) {
		if($id !== null) {
			if(!ufront_web_session_FileSession::$validID->match($id)) {
				throw new HException("Invalid session ID.");
			}
		}
	}
	static $__properties__ = array("get_id" => "get_id");
	function __toString() { return $this->toString(); }
}
ufront_web_session_FileSession::$__meta__ = _hx_anonymous(array("fields" => _hx_anonymous(array("context" => _hx_anonymous(array("name" => (new _hx_array(array("context"))), "type" => (new _hx_array(array("ufront.web.context.HttpContext"))), "inject" => null)), "injectConfig" => _hx_anonymous(array("name" => (new _hx_array(array("injectConfig"))), "args" => null, "post" => null))))));
ufront_web_session_FileSession::$validID = new EReg("^[a-zA-Z0-9]+\$", "");
