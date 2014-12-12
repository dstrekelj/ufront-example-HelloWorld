<?php

class ufront_auth_api_EasyAuthApi extends ufront_api_UFApi {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public $easyAuth;
	public function attemptLogin($username, $password) {
		return $this->easyAuth->startSessionSync(new ufront_auth_EasyAuthDBAdapter($username, $password));
	}
	public function logout() {
		$this->easyAuth->endSession();
	}
	public function getUser($userID) {
		$_g = $this;
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g, &$userID), "ufront_auth_api_EasyAuthApi_0"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 42, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "getUser")));
	}
	public function getUserByUsername($username) {
		$_g = $this;
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g, &$username), "ufront_auth_api_EasyAuthApi_1"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 49, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "getUserByUsername")));
	}
	public function getAllUsers() {
		$_g = $this;
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g), "ufront_auth_api_EasyAuthApi_2"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 56, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "getAllUsers")));
	}
	public function getGroup($groupID) {
		$_g = $this;
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g, &$groupID), "ufront_auth_api_EasyAuthApi_3"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 63, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "getGroup")));
	}
	public function getGroupByName($name) {
		$_g = $this;
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g, &$name), "ufront_auth_api_EasyAuthApi_4"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 70, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "getGroupByName")));
	}
	public function getAllGroups() {
		$_g = $this;
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g), "ufront_auth_api_EasyAuthApi_5"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 77, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "getAllGroups")));
	}
	public function getAllGroupsForUser($userID) {
		$_g = $this;
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g, &$userID), "ufront_auth_api_EasyAuthApi_6"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 84, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "getAllGroupsForUser")));
	}
	public function getAllUsersInGroup($groupID) {
		$_g = $this;
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g, &$groupID), "ufront_auth_api_EasyAuthApi_7"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 92, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "getAllUsersInGroup")));
	}
	public function getAllPermissionsForUser($userID) {
		$_g = $this;
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g, &$userID), "ufront_auth_api_EasyAuthApi_8"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 100, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "getAllPermissionsForUser")));
	}
	public function createUser($username, $password) {
		$_g = $this;
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g, &$password, &$username), "ufront_auth_api_EasyAuthApi_9"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 114, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "createUser")));
	}
	public function createGroup($groupName) {
		$_g = $this;
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g, &$groupName), "ufront_auth_api_EasyAuthApi_10"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 123, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "createGroup")));
	}
	public function userAllowedToAssignToGroup($group) {
		if(!$this->easyAuth->hasPermission(ufront_auth_EasyAuthPermissions::$EAPAssignAnyGroup)) {
			if($this->easyAuth->hasPermission(ufront_auth_EasyAuthPermissions::$EAPAssignOwnGroup)) {
				if(Lambda::has($this->easyAuth->get_currentUser()->get_groups(), $group) === false) {
					throw new HException("You are not in the group you are trying to assign users to.");
				}
			} else {
				throw new HException("You do not have permission to assign users to groups");
			}
		}
	}
	public function assignUserToGroup($userID, $groupID) {
		$_g = $this;
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g, &$groupID, &$userID), "ufront_auth_api_EasyAuthApi_11"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 142, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "assignUserToGroup")));
	}
	public function removeUserFromGroup($userID, $groupID) {
		$_g = $this;
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g, &$groupID, &$userID), "ufront_auth_api_EasyAuthApi_12"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 152, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "removeUserFromGroup")));
	}
	public function userAllowedToAssignPermissions($permission) {
		if(!$this->easyAuth->hasPermission(ufront_auth_EasyAuthPermissions::$EAPAssignAnyUserPermission)) {
			if($this->easyAuth->hasPermission(ufront_auth_EasyAuthPermissions::$EAPAssignUserPermissionYouHave)) {
				if($this->easyAuth->get_currentUser()->can($permission, null) === false) {
					throw new HException("You do not have the " . Std::string($permission) . " permission, so you cannot give it to anyone.");
				}
			} else {
				throw new HException("You do not have permission to assign permissions.");
			}
		}
	}
	public function assignPermissionToUser($permission, $userID) {
		$_g = $this;
		$errors = (new _hx_array(array()));
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g, &$errors, &$permission, &$userID), "ufront_auth_api_EasyAuthApi_13"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 173, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "assignPermissionToUser")));
	}
	public function assignPermissionToGroup($permission, $groupID) {
		$_g = $this;
		$errors = (new _hx_array(array()));
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g, &$errors, &$groupID, &$permission), "ufront_auth_api_EasyAuthApi_14"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 194, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "assignPermissionToGroup")));
	}
	public function revokePermissionFromUser($permission, $userID) {
		$_g = $this;
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g, &$permission, &$userID), "ufront_auth_api_EasyAuthApi_15"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 214, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "revokePermissionFromUser")));
	}
	public function revokePermissionFromGroup($permission, $groupID) {
		$_g = $this;
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g, &$groupID, &$permission), "ufront_auth_api_EasyAuthApi_16"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 223, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "revokePermissionFromGroup")));
	}
	public function userAllowedToEditUsers($user) {
		if(!$this->easyAuth->hasPermission(ufront_auth_EasyAuthPermissions::$EAPEditAnyUser)) {
			if($this->easyAuth->hasPermission(ufront_auth_EasyAuthPermissions::$EAPEditOwnUser)) {
				if($this->easyAuth->get_currentUser()->id === $user->id) {
					throw new HException("You are only allowed to edit your own user.");
				}
			} else {
				throw new HException("You are not allowed to edit users, even your own.");
			}
		}
	}
	public function changeUsername($userID, $newUsername) {
		$_g = $this;
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g, &$newUsername, &$userID), "ufront_auth_api_EasyAuthApi_17"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 242, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "changeUsername")));
	}
	public function changeCurrentUserPassword($userID, $oldPassword, $newPassword) {
		$_g = $this;
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g, &$newPassword, &$oldPassword, &$userID), "ufront_auth_api_EasyAuthApi_18"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 252, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "changeCurrentUserPassword")));
	}
	public function changeAnyPassword($userID, $newPassword) {
		$_g = $this;
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g, &$newPassword, &$userID), "ufront_auth_api_EasyAuthApi_19"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 265, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "changeAnyPassword")));
	}
	public function userAllowedToEditGroups($group) {
		if(!$this->easyAuth->hasPermission(ufront_auth_EasyAuthPermissions::$EAPEditAnyGroup)) {
			if($this->easyAuth->hasPermission(ufront_auth_EasyAuthPermissions::$EAPEditOwnGroup)) {
				if(Lambda::has($this->easyAuth->get_currentUser()->get_groups(), $group) === false) {
					throw new HException("You are only allowed to edit groups you are in.");
				}
			} else {
				throw new HException("You are not allowed to edit groups, even one you are in.");
			}
		}
	}
	public function changeGroupName($groupID, $newName) {
		$_g = $this;
		return $this->wrapInOutcome(array(new _hx_lambda(array(&$_g, &$groupID, &$newName), "ufront_auth_api_EasyAuthApi_20"), 'execute'), _hx_anonymous(array("fileName" => "EasyAuthApi.hx", "lineNumber" => 285, "className" => "ufront.auth.api.EasyAuthApi", "methodName" => "changeGroupName")));
	}
	public function wrapInOutcome($fn, $pos = null) {
		try {
			return tink_core_Outcome::Success(call_user_func($fn));
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				return tink_core_Outcome::Failure(tink_core_TypedError::withData(null, "Internal Server Error", $e, $pos));
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
	function __toString() { return 'ufront.auth.api.EasyAuthApi'; }
}
ufront_auth_api_EasyAuthApi::$__meta__ = _hx_anonymous(array("fields" => _hx_anonymous(array("easyAuth" => _hx_anonymous(array("name" => (new _hx_array(array("easyAuth"))), "type" => (new _hx_array(array("ufront.auth.EasyAuth"))), "inject" => null)), "attemptLogin" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "logout" => _hx_anonymous(array("returnType" => (new _hx_array(array(4))))), "getUser" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "getUserByUsername" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "getAllUsers" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "getGroup" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "getGroupByName" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "getAllGroups" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "getAllGroupsForUser" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "getAllUsersInGroup" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "getAllPermissionsForUser" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "createUser" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "createGroup" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "assignUserToGroup" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "removeUserFromGroup" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "assignPermissionToUser" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "assignPermissionToGroup" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "revokePermissionFromUser" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "revokePermissionFromGroup" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "changeUsername" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "changeCurrentUserPassword" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "changeAnyPassword" => _hx_anonymous(array("returnType" => (new _hx_array(array(2))))), "changeGroupName" => _hx_anonymous(array("returnType" => (new _hx_array(array(2)))))))));
function ufront_auth_api_EasyAuthApi_0(&$_g, &$userID) {
	{
		$_g->easyAuth->requirePermission(ufront_auth_EasyAuthPermissions::$EAPListAllUsers);
		return ufront_auth_model_User::$manager->unsafeGet($userID, true);
	}
}
function ufront_auth_api_EasyAuthApi_1(&$_g, &$username) {
	{
		$_g->easyAuth->requirePermission(ufront_auth_EasyAuthPermissions::$EAPListAllUsers);
		return ufront_auth_model_User::$manager->unsafeObjects("SELECT * FROM auth_user WHERE username = " . _hx_string_or_null(sys_db_Manager::quoteAny($username)), true)->first();
	}
}
function ufront_auth_api_EasyAuthApi_2(&$_g) {
	{
		$_g->easyAuth->requirePermission(ufront_auth_EasyAuthPermissions::$EAPListAllUsers);
		return ufront_auth_model_User::$manager->all(null);
	}
}
function ufront_auth_api_EasyAuthApi_3(&$_g, &$groupID) {
	{
		$_g->easyAuth->requirePermission(ufront_auth_EasyAuthPermissions::$EAPListAllGroups);
		return ufront_auth_model_Group::$manager->unsafeGet($groupID, true);
	}
}
function ufront_auth_api_EasyAuthApi_4(&$_g, &$name) {
	{
		$_g->easyAuth->requirePermission(ufront_auth_EasyAuthPermissions::$EAPListAllGroups);
		return ufront_auth_model_Group::$manager->unsafeObjects("SELECT * FROM auth_group WHERE name = " . _hx_string_or_null(sys_db_Manager::quoteAny($name)), true)->first();
	}
}
function ufront_auth_api_EasyAuthApi_5(&$_g) {
	{
		$_g->easyAuth->requirePermission(ufront_auth_EasyAuthPermissions::$EAPListAllGroups);
		return ufront_auth_model_Group::$manager->all(null);
	}
}
function ufront_auth_api_EasyAuthApi_6(&$_g, &$userID) {
	{
		$_g->easyAuth->requirePermission(ufront_auth_EasyAuthPermissions::$EAPListGroupsForUser);
		$user = ufront_auth_model_User::$manager->unsafeGet($userID, true);
		return Lambda::hlist($user->get_groups());
	}
}
function ufront_auth_api_EasyAuthApi_7(&$_g, &$groupID) {
	{
		$_g->easyAuth->requirePermission(ufront_auth_EasyAuthPermissions::$EAPListUsersInGroups);
		$group = ufront_auth_model_Group::$manager->unsafeGet($groupID, true);
		return Lambda::hlist($group->get_users());
	}
}
function ufront_auth_api_EasyAuthApi_8(&$_g, &$userID) {
	{
		$_g->easyAuth->requirePermission(ufront_auth_EasyAuthPermissions::$EAPListUserPermissions);
		$user = ufront_auth_model_User::$manager->unsafeGet($userID, true);
		$groupIDs = null;
		{
			$_g1 = (new _hx_array(array()));
			$__hx__it = ufront_auth_api_EasyAuthApi_21($_g, $_g1, $g, $groupIDs, $user, $userID);
			while($__hx__it->hasNext()) {
				$g = $__hx__it->next();
				$_g1->push($g->id);
			}
			$groupIDs = $_g1;
		}
		$permissions = ufront_auth_model_Permission::$manager->unsafeObjects("SELECT * FROM auth_permission WHERE " . _hx_string_or_null(sys_db_Manager::nullCompare("userID", sys_db_Manager::quoteAny($userID), true)) . _hx_string_or_null((" OR " . _hx_string_or_null(sys_db_Manager::quoteList("groupID", $groupIDs)))), true);
		return $permissions->map(array(new _hx_lambda(array(&$_g, &$groupIDs, &$permissions, &$user, &$userID), "ufront_auth_api_EasyAuthApi_22"), 'execute'));
	}
}
function ufront_auth_api_EasyAuthApi_9(&$_g, &$password, &$username) {
	{
		$_g->easyAuth->requirePermission(ufront_auth_EasyAuthPermissions::$EAPCreateUser);
		$u = new ufront_auth_model_User($username, $password);
		$u->save();
		return $u;
	}
}
function ufront_auth_api_EasyAuthApi_10(&$_g, &$groupName) {
	{
		$_g->easyAuth->requirePermission(ufront_auth_EasyAuthPermissions::$EAPCreateGroup);
		$g = new ufront_auth_model_Group($groupName);
		$g->save();
		return $g;
	}
}
function ufront_auth_api_EasyAuthApi_11(&$_g, &$groupID, &$userID) {
	{
		$group = ufront_auth_model_Group::$manager->unsafeGet($groupID, true);
		$user = ufront_auth_model_User::$manager->unsafeGet($userID, true);
		$_g->userAllowedToAssignToGroup($group);
		$user->get_groups()->add($group);
		return tink_core_Noise::$Noise;
	}
}
function ufront_auth_api_EasyAuthApi_12(&$_g, &$groupID, &$userID) {
	{
		$user = ufront_auth_model_User::$manager->unsafeGet($userID, true);
		$group = ufront_auth_model_Group::$manager->unsafeGet($groupID, true);
		$_g->userAllowedToAssignToGroup($group);
		$user->get_groups()->remove($group);
		return tink_core_Noise::$Noise;
	}
}
function ufront_auth_api_EasyAuthApi_13(&$_g, &$errors, &$permission, &$userID) {
	{
		$_g->userAllowedToAssignPermissions($permission);
		$pString = ufront_auth_model_Permission::getPermissionID($permission);
		$count = ufront_auth_model_Permission::$manager->unsafeCount("SELECT COUNT(*) FROM auth_permission WHERE " . _hx_string_or_null(sys_db_Manager::nullCompare("userID", sys_db_Manager::quoteAny($userID), true)) . _hx_string_or_null((" AND permission = " . _hx_string_or_null(sys_db_Manager::quoteAny($pString)))));
		if($count > 1) {
			ufront_auth_model_Permission::$manager->unsafeDelete("DELETE FROM auth_permission WHERE " . _hx_string_or_null(sys_db_Manager::nullCompare("userID", sys_db_Manager::quoteAny($userID), true)) . _hx_string_or_null((" AND permission = " . _hx_string_or_null(sys_db_Manager::quoteAny($pString)))));
			$count = 0;
		}
		if($count === 0) {
			$item = new ufront_auth_model_Permission();
			$item->permission = $pString;
			$item->userID = $userID;
			$item->insert();
		}
		return tink_core_Noise::$Noise;
	}
}
function ufront_auth_api_EasyAuthApi_14(&$_g, &$errors, &$groupID, &$permission) {
	{
		$_g->userAllowedToAssignPermissions($permission);
		$pString = ufront_auth_model_Permission::getPermissionID($permission);
		$count = ufront_auth_model_Permission::$manager->unsafeCount("SELECT COUNT(*) FROM auth_permission WHERE " . _hx_string_or_null(sys_db_Manager::nullCompare("groupID", sys_db_Manager::quoteAny($groupID), true)) . _hx_string_or_null((" AND permission = " . _hx_string_or_null(sys_db_Manager::quoteAny($pString)))));
		if($count > 1) {
			ufront_auth_model_Permission::$manager->unsafeDelete("DELETE FROM auth_permission WHERE " . _hx_string_or_null(sys_db_Manager::nullCompare("groupID", sys_db_Manager::quoteAny($groupID), true)) . _hx_string_or_null((" AND permission = " . _hx_string_or_null(sys_db_Manager::quoteAny($pString)))));
			$count = 0;
		}
		if($count === 0) {
			$item = new ufront_auth_model_Permission();
			$item->permission = $pString;
			$item->groupID = $groupID;
			$item->insert();
		}
		return tink_core_Noise::$Noise;
	}
}
function ufront_auth_api_EasyAuthApi_15(&$_g, &$permission, &$userID) {
	{
		$_g->userAllowedToAssignPermissions($permission);
		$pString = ufront_auth_model_Permission::getPermissionID($permission);
		ufront_auth_model_Permission::$manager->unsafeDelete("DELETE FROM auth_permission WHERE " . _hx_string_or_null(sys_db_Manager::nullCompare("userID", sys_db_Manager::quoteAny($userID), true)) . _hx_string_or_null((" AND permission = " . _hx_string_or_null(sys_db_Manager::quoteAny($pString)))));
		return tink_core_Noise::$Noise;
	}
}
function ufront_auth_api_EasyAuthApi_16(&$_g, &$groupID, &$permission) {
	{
		$_g->userAllowedToAssignPermissions($permission);
		$pString = ufront_auth_model_Permission::getPermissionID($permission);
		ufront_auth_model_Permission::$manager->unsafeDelete("DELETE FROM auth_permission WHERE " . _hx_string_or_null(sys_db_Manager::nullCompare("groupID", sys_db_Manager::quoteAny($groupID), true)) . _hx_string_or_null((" AND permission = " . _hx_string_or_null(sys_db_Manager::quoteAny($pString)))));
		return tink_core_Noise::$Noise;
	}
}
function ufront_auth_api_EasyAuthApi_17(&$_g, &$newUsername, &$userID) {
	{
		$u = ufront_auth_model_User::$manager->unsafeGet($userID, true);
		$_g->userAllowedToEditUsers($u);
		$u->username = $newUsername;
		$u->save();
		return tink_core_Noise::$Noise;
	}
}
function ufront_auth_api_EasyAuthApi_18(&$_g, &$newPassword, &$oldPassword, &$userID) {
	{
		$_g->easyAuth->requirePermission(ufront_auth_EasyAuthPermissions::$EAPChangePasswordOwnUser);
		$u = $_g->easyAuth->get_currentUser();
		$authAdapter = new ufront_auth_EasyAuthDBAdapter($u->username, $oldPassword);
		tink_core_OutcomeTools::sure($authAdapter->authenticateSync());
		$u->setPassword($newPassword);
		$u->save();
		return tink_core_Noise::$Noise;
	}
}
function ufront_auth_api_EasyAuthApi_19(&$_g, &$newPassword, &$userID) {
	{
		$_g->easyAuth->requirePermission(ufront_auth_EasyAuthPermissions::$EAPChangePasswordAnyUser);
		$u = ufront_auth_model_User::$manager->unsafeGet($userID, true);
		$u->setPassword($newPassword);
		$u->save();
		return tink_core_Noise::$Noise;
	}
}
function ufront_auth_api_EasyAuthApi_20(&$_g, &$groupID, &$newName) {
	{
		$g = ufront_auth_model_Group::$manager->unsafeGet($groupID, true);
		$_g->userAllowedToEditGroups($g);
		$g->name = $newName;
		$g->save();
		return tink_core_Noise::$Noise;
	}
}
function ufront_auth_api_EasyAuthApi_21(&$_g, &$_g1, &$g, &$groupIDs, &$user, &$userID) {
	{
		$_this = $user->get_groups();
		return $_this->bList->iterator();
	}
}
function ufront_auth_api_EasyAuthApi_22(&$_g, &$groupIDs, &$permissions, &$user, &$userID, $p) {
	{
		$parts = _hx_explode(":", $p->permission);
		$enumType = Type::resolveEnum($parts[0]);
		return Type::createEnum($enumType, $parts[1], null);
	}
}
