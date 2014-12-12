<?php

class ufront_ufadmin_modules_EasyAuthAdminModule extends ufront_ufadmin_UFAdminModule {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct("easyauth","Authentication");
	}}
	public $easyAuth;
	public $api;
	public function index() {
		return $this->listAllUsers();
	}
	public function listAllUsers() {
		return $this->displayUserList(tink_core_OutcomeTools::sure($this->api->getAllUsers()), "All Users");
	}
	public function displayUserList($userList, $title) {
		$users = Lambda::harray($userList);
		try {
			$users->sort(array(new _hx_lambda(array(&$title, &$userList, &$users), "ufront_ufadmin_modules_EasyAuthAdminModule_0"), 'execute'));
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				haxe_Log::trace("Cleversort failed: " . Std::string($e), _hx_anonymous(array("fileName" => "CleverSort.hx", "lineNumber" => 111, "className" => "ufront.ufadmin.modules.EasyAuthAdminModule", "methodName" => "displayUserList")));
			}
		}
		$template = "<h2>::title::</h2>\x0A\x0A<p class=\"info\">\x0A\x09Showing ::users.length:: users.\x0A\x09<a href=\"::baseUri::users/new/\" class=\"btn btn-primary pull-right\">Create New User</a>\x0A</p>\x0A\x0A<table class=\"table\">\x0A\x09<thead>\x0A\x09\x09<tr>\x0A\x09\x09\x09<th>Username</th>\x0A\x09\x09\x09<th>Registered</th>\x0A\x09\x09</tr>\x0A\x09</thead>\x0A\x09::foreach users::\x0A\x09\x09<tr>\x0A\x09\x09\x09<td><a href=\"::baseUri::user/::username::/\" title=\"View Profile\">::username::</a></td>\x0A\x09\x09\x09<td>::created::</td>\x0A\x09\x09</tr>\x0A\x09::end::\x0A</table>";
		return ufront_ufadmin_UFAdminModule::wrapInLayout($title, $template, ufront_ufadmin_modules_EasyAuthAdminModule_1($this, $e, $template, $title, $userList, $users));
	}
	public function showUserProfile($username) {
		$user = tink_core_OutcomeTools::sure($this->api->getUserByUsername($username));
		if($user === null) {
			throw new HException(ufront_web_HttpError::pageNotFound(_hx_anonymous(array("fileName" => "EasyAuthAdminModule.hx", "lineNumber" => 46, "className" => "ufront.ufadmin.modules.EasyAuthAdminModule", "methodName" => "showUserProfile"))));
		}
		$permissions = tink_core_OutcomeTools::sure($this->api->getAllPermissionsForUser($user->id));
		$template = "<h2>::username::</h2>\x0A\x0A<div class=\"btn-toolbar\">\x0A\x09<a href=\"::baseUri::changePassword/::id::\" class=\"btn btn-default\">Change Password</a>\x0A\x09<a href=\"::baseUri::loginas/::id::\" class=\"btn btn-default\">Login as ::username::</a>\x0A</div>\x0A\x0A<h4>Groups</h4>\x0A\x0A::foreach groups::\x0A\x09<p><span class=\"label\">::name::</span></p>\x0A::end::\x0A\x0A<h4>Permissions</h4>\x0A\x0A::foreach permissions::\x0A\x09<p><span class=\"label\">::__current__::</span></p>\x0A::end::";
		return ufront_ufadmin_UFAdminModule::wrapInLayout("Viewing User " . _hx_string_or_null($username), $template, ufront_ufadmin_modules_EasyAuthAdminModule_2($this, $permissions, $template, $user, $username));
	}
	public function loginAs($id) {
		$user = ufront_auth_model_User::$manager->unsafeGet($id, true);
		if($user === null) {
			throw new HException(ufront_web_HttpError::pageNotFound(_hx_anonymous(array("fileName" => "EasyAuthAdminModule.hx", "lineNumber" => 63, "className" => "ufront.ufadmin.modules.EasyAuthAdminModule", "methodName" => "loginAs"))));
		}
		$this->easyAuth->setCurrentUser($user);
		return new ufront_web_result_RedirectResult("/", null);
	}
	public function newUserForm() {
		return "Add a new user!";
	}
	public function editUserForm($username) {
		return "Edit user " . _hx_string_or_null($username);
	}
	public function showUserForm($u = null) {
		$template = "<h2>::username::</h2>\x0A\x0A<div class=\"btn-toolbar\">\x0A\x09<a href=\"::baseUri::changePassword/::id::\" class=\"btn btn-default\">Change Password</a>\x0A\x09<a href=\"::baseUri::loginas/::id::\" class=\"btn btn-default\">Login as ::username::</a>\x0A</div>\x0A\x0A<h4>Groups</h4>\x0A\x0A::foreach groups::\x0A\x09<p><span class=\"label\">::name::</span></p>\x0A::end::\x0A\x0A<h4>Permissions</h4>\x0A\x0A::foreach permissions::\x0A\x09<p><span class=\"label\">::__current__::</span></p>\x0A::end::";
		return ufront_ufadmin_UFAdminModule::wrapInLayout("Viewing User " . _hx_string_or_null($u->username), $template, ufront_ufadmin_modules_EasyAuthAdminModule_3($this, $template, $u));
	}
	public function execute() {
		$uriParts = $this->context->actionContext->get_uriParts();
		$this->setBaseUri($uriParts);
		$params = $this->context->request->get_params();
		$method = $this->context->request->get_httpMethod();
		$this->context->actionContext->controller = $this;
		$this->context->actionContext->action = "execute";
		try {
			if(0 === $uriParts->length) {
				$this->context->actionContext->action = "index";
				$this->context->actionContext->args = (new _hx_array(array()));
				$this->context->actionContext->get_uriParts()->splice(0, 0);
				$wrappingRequired = haxe_rtti_Meta::getFields(_hx_qtype("ufront.ufadmin.modules.EasyAuthAdminModule"))->index->wrapResult[0];
				$result = $this->wrapResult($this->index(), $wrappingRequired);
				$this->setContextActionResultWhenFinished($result);
				return $result;
			} else {
				if(2 === $uriParts->length && $uriParts[0] === "users" && $uriParts[1] === "all") {
					$this->context->actionContext->action = "listAllUsers";
					$this->context->actionContext->args = (new _hx_array(array()));
					$this->context->actionContext->get_uriParts()->splice(0, 2);
					$wrappingRequired1 = haxe_rtti_Meta::getFields(_hx_qtype("ufront.ufadmin.modules.EasyAuthAdminModule"))->listAllUsers->wrapResult[0];
					$result1 = $this->wrapResult($this->listAllUsers(), $wrappingRequired1);
					$this->setContextActionResultWhenFinished($result1);
					return $result1;
				} else {
					if(2 === $uriParts->length && $uriParts[0] === "user" && strlen($uriParts[1]) > 0) {
						$username = $uriParts[1];
						$this->context->actionContext->action = "showUserProfile";
						$this->context->actionContext->args = (new _hx_array(array($username)));
						$this->context->actionContext->get_uriParts()->splice(0, 2);
						$wrappingRequired2 = haxe_rtti_Meta::getFields(_hx_qtype("ufront.ufadmin.modules.EasyAuthAdminModule"))->showUserProfile->wrapResult[0];
						$result2 = $this->wrapResult($this->showUserProfile($username), $wrappingRequired2);
						$this->setContextActionResultWhenFinished($result2);
						return $result2;
					} else {
						if(2 === $uriParts->length && $uriParts[0] === "loginas" && strlen($uriParts[1]) > 0) {
							$id = Std::parseInt($uriParts[1]);
							if($id === null) {
								throw new HException(ufront_ufadmin_modules_EasyAuthAdminModule_4($this, $id, $method, $params, $uriParts));
							}
							$this->context->actionContext->action = "loginAs";
							$this->context->actionContext->args = (new _hx_array(array($id)));
							$this->context->actionContext->get_uriParts()->splice(0, 2);
							$wrappingRequired3 = haxe_rtti_Meta::getFields(_hx_qtype("ufront.ufadmin.modules.EasyAuthAdminModule"))->loginAs->wrapResult[0];
							$result3 = $this->wrapResult($this->loginAs($id), $wrappingRequired3);
							$this->setContextActionResultWhenFinished($result3);
							return $result3;
						} else {
							if(strtolower($method) === "get" && 2 === $uriParts->length && $uriParts[0] === "users" && $uriParts[1] === "new") {
								$this->context->actionContext->action = "newUserForm";
								$this->context->actionContext->args = (new _hx_array(array()));
								$this->context->actionContext->get_uriParts()->splice(0, 2);
								$wrappingRequired4 = haxe_rtti_Meta::getFields(_hx_qtype("ufront.ufadmin.modules.EasyAuthAdminModule"))->newUserForm->wrapResult[0];
								$result4 = $this->wrapResult($this->newUserForm(), $wrappingRequired4);
								$this->setContextActionResultWhenFinished($result4);
								return $result4;
							} else {
								if(3 === $uriParts->length && $uriParts[0] === "user" && strlen($uriParts[1]) > 0 && $uriParts[2] === "edit") {
									$username1 = $uriParts[1];
									$this->context->actionContext->action = "editUserForm";
									$this->context->actionContext->args = (new _hx_array(array($username1)));
									$this->context->actionContext->get_uriParts()->splice(0, 3);
									$wrappingRequired5 = haxe_rtti_Meta::getFields(_hx_qtype("ufront.ufadmin.modules.EasyAuthAdminModule"))->editUserForm->wrapResult[0];
									$result5 = $this->wrapResult($this->editUserForm($username1), $wrappingRequired5);
									$this->setContextActionResultWhenFinished($result5);
									return $result5;
								}
							}
						}
					}
				}
			}
			throw new HException(ufront_web_HttpError::pageNotFound(_hx_anonymous(array("fileName" => "ControllerMacros.hx", "lineNumber" => 433, "className" => "ufront.ufadmin.modules.EasyAuthAdminModule", "methodName" => "execute"))));
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				return ufront_core_Sync::httpError("Uncaught error while executing " . Std::string($this->context->actionContext->controller) . "." . _hx_string_or_null($this->context->actionContext->action) . "()", $e, _hx_anonymous(array("fileName" => "ControllerMacros.hx", "lineNumber" => 436, "className" => "ufront.ufadmin.modules.EasyAuthAdminModule", "methodName" => "execute")));
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
	function __toString() { return 'ufront.ufadmin.modules.EasyAuthAdminModule'; }
}
ufront_ufadmin_modules_EasyAuthAdminModule::$__meta__ = _hx_anonymous(array("fields" => _hx_anonymous(array("easyAuth" => _hx_anonymous(array("name" => (new _hx_array(array("easyAuth"))), "type" => (new _hx_array(array("ufront.auth.EasyAuth"))), "inject" => null)), "api" => _hx_anonymous(array("name" => (new _hx_array(array("api"))), "type" => (new _hx_array(array("ufront.auth.api.EasyAuthApi"))), "inject" => null)), "index" => _hx_anonymous(array("wrapResult" => (new _hx_array(array(3))))), "listAllUsers" => _hx_anonymous(array("wrapResult" => (new _hx_array(array(3))))), "showUserProfile" => _hx_anonymous(array("wrapResult" => (new _hx_array(array(3))))), "loginAs" => _hx_anonymous(array("wrapResult" => (new _hx_array(array(3))))), "newUserForm" => _hx_anonymous(array("wrapResult" => (new _hx_array(array(7))))), "editUserForm" => _hx_anonymous(array("wrapResult" => (new _hx_array(array(7)))))))));
function ufront_ufadmin_modules_EasyAuthAdminModule_0(&$title, &$userList, &$users, $i1, $i2) {
	{
		$cmp = null;
		$cmp = Reflect::compare($i1->username, $i2->username);
		if($cmp !== 0) {
			return $cmp;
		}
		return 0;
	}
}
function ufront_ufadmin_modules_EasyAuthAdminModule_1(&$__hx__this, &$e, &$template, &$title, &$userList, &$users) {
	{
		$d = _hx_anonymous(array("users" => $users, "title" => $title));
		return (($d !== null) ? $d : _hx_anonymous(array()));
	}
}
function ufront_ufadmin_modules_EasyAuthAdminModule_2(&$__hx__this, &$permissions, &$template, &$user, &$username) {
	{
		$d = _hx_anonymous(array("id" => $user->id, "username" => $username, "groups" => $user->get_groups(), "permissions" => $permissions));
		return (($d !== null) ? $d : _hx_anonymous(array()));
	}
}
function ufront_ufadmin_modules_EasyAuthAdminModule_3(&$__hx__this, &$template, &$u) {
	{
		$d = _hx_anonymous(array("id" => $u->id, "username" => $u->username));
		return (($d !== null) ? $d : _hx_anonymous(array()));
	}
}
function ufront_ufadmin_modules_EasyAuthAdminModule_4(&$__hx__this, &$id, &$method, &$params, &$uriParts) {
	{
		$reason = "Could not parse parameter " . "id" . ":Int = " . _hx_string_or_null($uriParts[1]);
		$message = "Bad Request";
		if($reason !== null) {
			$message .= ": " . _hx_string_or_null($reason);
		}
		return new tink_core_TypedError(400, $message, _hx_anonymous(array("fileName" => "ControllerMacros.hx", "lineNumber" => 624, "className" => "ufront.ufadmin.modules.EasyAuthAdminModule", "methodName" => "execute")));
	}
}
