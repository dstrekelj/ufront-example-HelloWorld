<?php

class ufront_auth_EasyAuth implements ufront_auth_UFAuthHandler{
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->isSuperUser = null;
	}}
	public $sessionVariableName;
	public $context;
	public $currentUser;
	public $isSuperUser;
	public function postInjection() {
		if($this->context->injector->hasMapping(_hx_qtype("String"), "easyAuthSessionVariableName")) {
			$this->sessionVariableName = $this->context->injector->getInstance(_hx_qtype("String"), "easyAuthSessionVariableName");
		} else {
			$this->sessionVariableName = ufront_auth_EasyAuth::$defaultSessionVariableName;
		}
	}
	public function isLoggedIn() {
		return $this->get_isSuperUser() || $this->context->session->exists($this->sessionVariableName);
	}
	public function requireLogin() {
		if(!$this->isLoggedIn()) {
			throw new HException(ufront_auth_AuthError::$NotLoggedIn);
		}
	}
	public function isLoggedInAs($user) {
		$u = Std::instance($user, _hx_qtype("ufront.auth.model.User"));
		return $this->get_isSuperUser() || $u !== null && $this->get_currentUser() !== null && $u->id === $this->get_currentUser()->id;
	}
	public function requireLoginAs($user) {
		if(!$this->isLoggedInAs($user)) {
			throw new HException(ufront_auth_AuthError::NotLoggedInAs($user));
		}
	}
	public function hasPermission($permission) {
		return $this->get_isSuperUser() || $this->get_currentUser() !== null && $this->get_currentUser()->can($permission, null);
	}
	public function hasPermissions($permissions) {
		if($this->get_isSuperUser()) {
			return true;
		}
		if(null == $permissions) throw new HException('null iterable');
		$__hx__it = $permissions->iterator();
		while($__hx__it->hasNext()) {
			$p = $__hx__it->next();
			if(!$this->hasPermission($p)) {
				return false;
			}
		}
		return true;
	}
	public function requirePermission($permission) {
		if(!$this->hasPermission($permission)) {
			$name = Type::enumConstructor($permission);
			throw new HException(ufront_auth_AuthError::NoPermission($permission));
		}
	}
	public function requirePermissions($permissions) {
		if(null == $permissions) throw new HException('null iterable');
		$__hx__it = $permissions->iterator();
		while($__hx__it->hasNext()) {
			$p = $__hx__it->next();
			$this->requirePermission($p);
		}
	}
	public function setCurrentUser($user) {
		$u = Std::instance($user, _hx_qtype("ufront.auth.model.User"));
		if($u !== null) {
			$this->_currentUser = $u;
			$this->context->session->set($this->sessionVariableName, ufront_auth_EasyAuth_0($this, $u, $user));
		} else {
			throw new HException("Could not set the current user to " . Std::string($user) . ", because that user is not a ufront.auth.model.User");
		}
	}
	public $_currentUser;
	public function get_currentUser() {
		if($this->_currentUser === null) {
			if($this->context->session->exists($this->sessionVariableName)) {
				$userID = $this->context->session->get($this->sessionVariableName);
				if($userID !== null) {
					$this->_currentUser = ufront_auth_model_User::$manager->unsafeGet($userID, true);
				}
			}
		}
		return $this->_currentUser;
	}
	public function startSession($authAdapter) {
		$_g = $this;
		$this->endSession();
		$resultFuture = $authAdapter->authenticate();
		call_user_func_array($resultFuture, array(array(new _hx_lambda(array(&$_g, &$authAdapter, &$resultFuture), "ufront_auth_EasyAuth_1"), 'execute')));
		return $resultFuture;
	}
	public function startSessionSync($authAdapter) {
		$this->endSession();
		$result = $authAdapter->authenticateSync();
		switch($result->index) {
		case 0:{
			$user = $result->params[0];
			$this->context->session->set($this->sessionVariableName, $user->id);
		}break;
		case 1:{
		}break;
		}
		return $result;
	}
	public function endSession() {
		if($this->context->session->exists($this->sessionVariableName)) {
			$this->context->session->remove($this->sessionVariableName);
		}
	}
	public function getUserByID($id) {
		return ufront_auth_model_User::$manager->unsafeObjects("SELECT * FROM auth_user WHERE username = " . _hx_string_or_null(sys_db_Manager::quoteAny($id)), true)->first();
	}
	public function toString() {
		return "EasyAuth" . _hx_string_or_null((ufront_auth_EasyAuth_2($this)));
	}
	public function get_isSuperUser() {
		if($this->isSuperUser === null) {
			$this->isSuperUser = $this->get_currentUser() !== null && $this->get_currentUser()->can(ufront_auth_EasyAuthPermissions::$EAPCanDoAnything, null);
			if($this->isSuperUser === false) {
				$numSuperUsers = null;
				try {
					$numSuperUsers = ufront_auth_model_Permission::$manager->unsafeCount("SELECT COUNT(*) FROM auth_permission WHERE permission = " . _hx_string_or_null(sys_db_Manager::quoteAny(ufront_auth_model_Permission::getPermissionID(ufront_auth_EasyAuthPermissions::$EAPCanDoAnything))));
				}catch(Exception $__hx__e) {
					$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
					$e = $_ex_;
					{
						if(sys_db_TableCreate::exists(ufront_auth_model_Permission::$manager) === false) {
							$numSuperUsers = 0;
						} else {
							throw new HException($e);
						}
					}
				}
				if($numSuperUsers === 0) {
					$this->isSuperUser = true;
					$this->context->messages->push(_hx_anonymous(array("msg" => "Please note you have not set up a super-user yet, so we are treating everybody(!) as a super-user, even visitors. Please set up a super-user (with the EAPCanDoAnything permission) ASAP.", "pos" => _hx_anonymous(array("fileName" => "EasyAuth.hx", "lineNumber" => 187, "className" => "ufront.auth.EasyAuth", "methodName" => "get_isSuperUser")), "type" => ufront_log_MessageType::$Warning)));
				}
			}
		}
		return $this->isSuperUser;
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
	static $defaultSessionVariableName = "easyauth_session_storage";
	static $__properties__ = array("get_isSuperUser" => "get_isSuperUser","get_currentUser" => "get_currentUser");
	function __toString() { return $this->toString(); }
}
ufront_auth_EasyAuth::$__meta__ = _hx_anonymous(array("fields" => _hx_anonymous(array("context" => _hx_anonymous(array("name" => (new _hx_array(array("context"))), "type" => (new _hx_array(array("ufront.web.context.HttpContext"))), "inject" => null)), "postInjection" => _hx_anonymous(array("name" => (new _hx_array(array("postInjection"))), "args" => null, "post" => null))))));
function ufront_auth_EasyAuth_0(&$__hx__this, &$u, &$user) {
	if($u !== null) {
		return $u->id;
	}
}
function ufront_auth_EasyAuth_1(&$_g, &$authAdapter, &$resultFuture, $r) {
	{
		switch($r->index) {
		case 0:{
			$user = $r->params[0];
			$_g->context->session->set($_g->sessionVariableName, $user->id);
		}break;
		case 1:{
		}break;
		}
	}
}
function ufront_auth_EasyAuth_2(&$__hx__this) {
	if($__hx__this->get_currentUser() !== null) {
		return "[" . _hx_string_or_null($__hx__this->get_currentUser()->get_userID()) . "]";
	} else {
		return "";
	}
}
