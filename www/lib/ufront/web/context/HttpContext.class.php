<?php

class ufront_web_context_HttpContext {
	public function __construct($request, $response, $appInjector = null, $session = null, $auth = null, $urlFilters = null, $relativeContentDir = null) {
		if(!php_Boot::$skip_constructor) {
		if($relativeContentDir === null) {
			$relativeContentDir = "uf-content";
		}
		if(null === $response) {
			throw new HException(new thx_error_NullArgument("response", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "HttpContext.hx", "lineNumber" => 66, "className" => "ufront.web.context.HttpContext", "methodName" => "new"))));
		}
		if(null === $request) {
			throw new HException(new thx_error_NullArgument("request", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "HttpContext.hx", "lineNumber" => 67, "className" => "ufront.web.context.HttpContext", "methodName" => "new"))));
		}
		$this->request = $request;
		$this->response = $response;
		if($urlFilters !== null) {
			$this->urlFilters = $urlFilters;
		} else {
			$this->urlFilters = (new _hx_array(array()));
		}
		$this->relativeContentDir = $relativeContentDir;
		$this->actionContext = new ufront_web_context_ActionContext($this);
		$this->messages = (new _hx_array(array()));
		$this->completion = 0;
		if($appInjector !== null) {
			$this->injector = $appInjector->createChildInjector();
		} else {
			$this->injector = new minject_Injector();
		}
		$this->injector->mapValue(_hx_qtype("ufront.web.context.HttpContext"), $this, null);
		$this->injector->mapValue(_hx_qtype("ufront.web.context.HttpRequest"), $request, null);
		$this->injector->mapValue(_hx_qtype("ufront.web.context.HttpResponse"), $response, null);
		$this->injector->mapValue(_hx_qtype("ufront.web.context.ActionContext"), $this->actionContext, null);
		$this->injector->mapValue(_hx_qtype("ufront.log.MessageList"), new ufront_log_MessageList($this->messages, null), null);
		if($session !== null) {
			$this->session = $session;
		}
		if($this->session === null) {
			try {
				$this->session = $this->injector->getInstance(_hx_qtype("ufront.web.session.UFHttpSession"), null);
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e = $_ex_;
				{
					$msg = "Failed to load UFHttpSession: " . Std::string($e) . ". Using VoidSession instead.";
					$this->messages->push(_hx_anonymous(array("msg" => $msg, "pos" => _hx_anonymous(array("fileName" => "HttpContext.hx", "lineNumber" => 87, "className" => "ufront.web.context.HttpContext", "methodName" => "new")), "type" => ufront_log_MessageType::$Log)));
				}
			}
		}
		if($this->session === null) {
			$this->session = new ufront_web_session_VoidSession();
		}
		ufront_core_InjectionTools::inject($this->injector, _hx_qtype("ufront.web.session.UFHttpSession"), $this->session, null, null, null);
		if($auth !== null) {
			$this->auth = $auth;
		}
		if($this->auth === null) {
			try {
				$this->auth = $this->injector->getInstance(_hx_qtype("ufront.auth.UFAuthHandler"), null);
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e1 = $_ex_;
				{
					$msg1 = "Failed to load UFAuthHandler: " . Std::string($e1) . ". Using NobodyAuthHandler instead.";
					$this->messages->push(_hx_anonymous(array("msg" => $msg1, "pos" => _hx_anonymous(array("fileName" => "HttpContext.hx", "lineNumber" => 94, "className" => "ufront.web.context.HttpContext", "methodName" => "new")), "type" => ufront_log_MessageType::$Log)));
				}
			}
		}
		if($this->auth === null) {
			$this->auth = new ufront_auth_NobodyAuthHandler();
		}
		ufront_core_InjectionTools::inject($this->injector, _hx_qtype("ufront.auth.UFAuthHandler"), $this->auth, null, null, null);
	}}
	public $injector;
	public $request;
	public $response;
	public $session;
	public $sessionID;
	public $auth;
	public $currentUser;
	public $currentUserID;
	public $actionContext;
	public $completion;
	public $urlFilters;
	public $_requestUri;
	public function getRequestUri() {
		if(null === $this->_requestUri) {
			$url = ufront_web_url_PartialUrl::parse($this->request->get_uri());
			if(null == $this->urlFilters) throw new HException('null iterable');
			$__hx__it = $this->urlFilters->iterator();
			while($__hx__it->hasNext()) {
				$filter = $__hx__it->next();
				$filter->filterIn($url, $this->request);
			}
			$this->_requestUri = $url->toString();
		}
		return $this->_requestUri;
	}
	public function generateUri($uri) {
		$uriOut = ufront_web_url_VirtualUrl::parse($uri);
		$filters = $this->urlFilters;
		$i = $filters->length - 1;
		while($i >= 0) {
			_hx_array_get($filters, $i--)->filterOut($uriOut, $this->request);
		}
		return $uriOut->toString();
	}
	public function setUrlFilters($filters) {
		if($filters !== null) {
			$this->urlFilters = $filters;
		} else {
			$this->urlFilters = (new _hx_array(array()));
		}
		$this->_requestUri = null;
	}
	public $contentDirectory;
	public $relativeContentDir;
	public $_contentDir;
	public function get_contentDirectory() {
		if($this->_contentDir === null) {
			if($this->request->get_scriptDirectory() !== null) {
				$this->_contentDir = _hx_string_or_null(haxe_io_Path::addTrailingSlash($this->request->get_scriptDirectory())) . _hx_string_or_null(haxe_io_Path::addTrailingSlash($this->relativeContentDir));
			} else {
				$this->_contentDir = haxe_io_Path::addTrailingSlash($this->relativeContentDir);
			}
		}
		return $this->_contentDir;
	}
	public function commitSession() {
		if($this->session !== null) {
			return $this->session->commit();
		} else {
			return tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Success(tink_core_Noise::$Noise));
		}
	}
	public function ufTrace($msg, $pos = null) {
		$this->messages->push(_hx_anonymous(array("msg" => $msg, "pos" => $pos, "type" => ufront_log_MessageType::$Trace)));
	}
	public function ufLog($msg, $pos = null) {
		$this->messages->push(_hx_anonymous(array("msg" => $msg, "pos" => $pos, "type" => ufront_log_MessageType::$Log)));
	}
	public function ufWarn($msg, $pos = null) {
		$this->messages->push(_hx_anonymous(array("msg" => $msg, "pos" => $pos, "type" => ufront_log_MessageType::$Warning)));
	}
	public function ufError($msg, $pos = null) {
		$this->messages->push(_hx_anonymous(array("msg" => $msg, "pos" => $pos, "type" => ufront_log_MessageType::$Error)));
	}
	public $messages;
	public function get_sessionID() {
		if(null !== $this->session) {
			return $this->session->get_id();
		} else {
			return null;
		}
	}
	public function get_currentUser() {
		if(null !== $this->auth) {
			return $this->auth->get_currentUser();
		} else {
			return null;
		}
	}
	public function get_currentUserID() {
		if($this->auth !== null && $this->auth->get_currentUser() !== null) {
			return $this->auth->get_currentUser()->get_userID();
		} else {
			return null;
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
	static function createSysContext($request = null, $response = null, $appInjector = null, $session = null, $auth = null, $urlFilters = null, $relativeContentDir = null) {
		if($relativeContentDir === null) {
			$relativeContentDir = "uf-content";
		}
		if(null === $request) {
			$request = ufront_web_context_HttpRequest::create();
		}
		if(null === $response) {
			$response = ufront_web_context_HttpResponse::create();
		}
		return new ufront_web_context_HttpContext($request, $response, $appInjector, $session, $auth, $urlFilters, $relativeContentDir);
	}
	static $__properties__ = array("get_contentDirectory" => "get_contentDirectory","get_currentUserID" => "get_currentUserID","get_currentUser" => "get_currentUser","get_sessionID" => "get_sessionID");
	function __toString() { return 'ufront.web.context.HttpContext'; }
}
