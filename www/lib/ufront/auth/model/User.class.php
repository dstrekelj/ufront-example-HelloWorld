<?php

class ufront_auth_model_User extends ufront_db_Object implements ufront_auth_UFAuthUser{
	public function __construct($username, $password = null) {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$this->username = $username;
		if($password !== null) {
			$this->setPassword($password);
		} else {
			$this->salt = "";
			$this->password = "";
		}
		$this->forcePasswordChange = false;
	}}
	public $username;
	public $salt;
	public $password;
	public $forcePasswordChange;
	public $userPermissions;
	public $groups;
	public $userID;
	public function setPassword($password) {
		if($password !== null) {
			$this->salt = Random::string(32, null);
			$this->password = ufront_auth_model_User::generatePasswordHash($password, $this->salt);
		} else {
			$this->salt = "";
			$this->password = "";
		}
	}
	public function can($permission = null, $permissions = null) {
		$this->loadUserPermissions();
		if($this->allUserPermissions === null) {
			return false;
		}
		if($permission !== null) {
			if(!$this->checkPermission($permission)) {
				return false;
			}
		}
		if($permissions !== null) {
			if(null == $permissions) throw new HException('null iterable');
			$__hx__it = $permissions->iterator();
			while($__hx__it->hasNext()) {
				$p = $__hx__it->next();
				if(!$this->checkPermission($p)) {
					return false;
				}
			}
		}
		return true;
	}
	public function get_userID() {
		return $this->username;
	}
	public function checkPermission($p) {
		return Lambda::has($this->allUserPermissions, ufront_auth_model_Permission::getPermissionID($p));
	}
	public $allUserPermissions;
	public function loadUserPermissions() {
		if($this->allUserPermissions === null) {
			$groupIDs = null;
			{
				$_g = (new _hx_array(array()));
				$__hx__it = ufront_auth_model_User_0($this, $_g, $g, $groupIDs);
				while($__hx__it->hasNext()) {
					$g = $__hx__it->next();
					$_g->push($g->id);
				}
				$groupIDs = $_g;
			}
			$permissions = ufront_auth_model_Permission::$manager->unsafeObjects("SELECT * FROM auth_permission WHERE " . _hx_string_or_null(sys_db_Manager::nullCompare("userID", sys_db_Manager::quoteAny($this->id), true)) . _hx_string_or_null((" OR " . _hx_string_or_null(sys_db_Manager::quoteList("groupID", $groupIDs)))), true);
			$this->allUserPermissions = $permissions->map(array(new _hx_lambda(array(&$groupIDs, &$permissions), "ufront_auth_model_User_1"), 'execute'));
		}
	}
	public function toString() {
		return $this->username;
	}
	public function removeSensitiveData() {
		$this->salt = "";
		$this->password = "";
		return $this;
	}
	public function get_userPermissions() {
		if($this->userPermissions === null) {
			$quotedID = sys_db_Manager::quoteAny($this->id);
			$table = ufront_auth_model_Permission::$manager->table_name;
			$this->set_userPermissions(ufront_auth_model_Permission::$manager->unsafeObjects("SELECT * FROM " . _hx_string_or_null($table) . " WHERE " . "userID" . " = " . _hx_string_or_null($quotedID), null));
		}
		return $this->userPermissions;
	}
	public function set_userPermissions($list) {
		return $this->userPermissions = $list;
	}
	public function get_groups() {
		if($this->groups === null) {
			$this->groups = new ufront_db_ManyToMany($this, _hx_qtype("ufront.auth.model.Group"), null);
		}
		if($this->groups->bList === null) {
			$this->groups->compileBList();
		}
		return $this->groups;
	}
	public function _validationsFromMacros() {
		parent::_validationsFromMacros();
		if($this->username === null) {
			ufront_db__ValidationErrors_ValidationErrors_Impl_::set($this->validationErrors, "username", "username" . " is a required field.");
		}
		if($this->salt === null) {
			ufront_db__ValidationErrors_ValidationErrors_Impl_::set($this->validationErrors, "salt", "salt" . " is a required field.");
		}
		if($this->password === null) {
			ufront_db__ValidationErrors_ValidationErrors_Impl_::set($this->validationErrors, "password", "password" . " is a required field.");
		}
		if($this->forcePasswordChange === null) {
			ufront_db__ValidationErrors_ValidationErrors_Impl_::set($this->validationErrors, "forcePasswordChange", "forcePasswordChange" . " is a required field.");
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
	static function generatePasswordHash($password, $salt) {
		return PBKDF2::encode($password, $salt, 500, 32);
	}
	static $manager;
	static $__properties__ = array("get_userID" => "get_userID","get_groups" => "get_groups","set_userPermissions" => "set_userPermissions","get_userPermissions" => "get_userPermissions","get_saved" => "get_saved");
	function __toString() { return $this->toString(); }
}
ufront_auth_model_User::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => (new _hx_array(array("oy4:namey9:auth_usery7:indexesaoy4:keysay8:usernamehy6:uniquetghy9:relationsahy7:hfieldsbR4oR0R4y6:isNullfy1:tjy17:sys.db.RecordType:9:1i40gy2:idoR0R11R8fR9jR10:0:0gy8:modifiedoR0R12R8fR9jR10:11:0gy4:saltoR0R13R8fR9jR10:9:1i32gy7:createdoR0R14R8fR9r11gy19:forcePasswordChangeoR0R15R8fR9jR10:8:0gy8:passwordoR0R16R8fR9jR10:9:1i64ghy3:keyaR11hy6:fieldsar8r14r10r6r12r17r15hg"))), "ufRelationships" => (new _hx_array(array("userPermissions,HasMany,ufront.auth.model.Permission,defaultUfrontControllerID", "groups,ManyToMany,ufront.auth.model.Group"))), "ufSerialize" => (new _hx_array(array("username", "salt", "password", "forcePasswordChange", "ManyToManygroups", "id", "created", "modified")))))));
ufront_auth_model_User::$manager = new sys_db_Manager(_hx_qtype("ufront.auth.model.User"));
function ufront_auth_model_User_0(&$__hx__this, &$_g, &$g, &$groupIDs) {
	{
		$_this = $__hx__this->get_groups();
		return $_this->bList->iterator();
	}
}
function ufront_auth_model_User_1(&$groupIDs, &$permissions, $p) {
	{
		return $p->permission;
	}
}
