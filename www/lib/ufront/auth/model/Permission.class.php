<?php

class ufront_auth_model_Permission extends ufront_db_Object {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public $permission;
	public $group;
	public $user;
	public $groupID;
	public function get_group() {
		if($this->group === null && $this->groupID !== null) {
			$this->set_group(ufront_auth_model_Group::$manager->unsafeGet($this->groupID, true));
		}
		return $this->group;
	}
	public function set_group($v) {
		$this->group = $v;
		if($v === null) {
			$this->groupID = null;
		} else {
			$this->groupID = $v->id;
		}
		return $this->get_group();
	}
	public $userID;
	public function get_user() {
		if($this->user === null && $this->userID !== null) {
			$this->set_user(ufront_auth_model_User::$manager->unsafeGet($this->userID, true));
		}
		return $this->user;
	}
	public function set_user($v) {
		$this->user = $v;
		if($v === null) {
			$this->userID = null;
		} else {
			$this->userID = $v->id;
		}
		return $this->get_user();
	}
	public function _validationsFromMacros() {
		parent::_validationsFromMacros();
		if($this->permission === null) {
			ufront_db__ValidationErrors_ValidationErrors_Impl_::set($this->validationErrors, "permission", "permission" . " is a required field.");
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
	static function getPermissionID($e) {
		$enumName = Type::getEnumName(Type::getEnum($e));
		return _hx_string_or_null($enumName) . ":" . _hx_string_or_null(Type::enumConstructor($e));
	}
	static $manager;
	static $__properties__ = array("set_user" => "set_user","get_user" => "get_user","set_group" => "set_group","get_group" => "get_group","get_saved" => "get_saved");
	function __toString() { return 'ufront.auth.model.Permission'; }
}
ufront_auth_model_Permission::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => (new _hx_array(array("oy4:namey15:auth_permissiony7:indexesaoy4:keysay10:permissiony7:groupIDhy6:uniquetgoR3aR4y6:userIDhR6tghy9:relationsahy7:hfieldsby2:idoR0R10y6:isNullfy1:tjy17:sys.db.RecordType:0:0gR4oR0R4R11fR12jR13:9:1i255gy8:modifiedoR0R14R11fR12jR13:11:0gR5oR0R5R11tR12jR13:3:0gR7oR0R7R11tR12r15gy7:createdoR0R15R11fR12r13ghy3:keyaR10hy6:fieldsar8r17r12r10r14r16hg"))), "ufRelationships" => (new _hx_array(array("group,BelongsTo,ufront.auth.model.Group", "user,BelongsTo,ufront.auth.model.User"))), "ufSerialize" => (new _hx_array(array("permission", "groupID", "userID", "id", "created", "modified")))))));
ufront_auth_model_Permission::$manager = new sys_db_Manager(_hx_qtype("ufront.auth.model.Permission"));
