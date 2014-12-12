<?php

class ufront_auth_model_Group extends ufront_db_Object {
	public function __construct($name = null) {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
		if($name !== null) {
			$this->name = $name;
		}
	}}
	public $name;
	public $users;
	public $permissions;
	public function get_users() {
		if($this->users === null) {
			$this->users = new ufront_db_ManyToMany($this, _hx_qtype("ufront.auth.model.User"), null);
		}
		if($this->users->bList === null) {
			$this->users->compileBList();
		}
		return $this->users;
	}
	public function get_permissions() {
		if($this->permissions === null) {
			$quotedID = sys_db_Manager::quoteAny($this->id);
			$table = ufront_auth_model_Permission::$manager->table_name;
			$this->set_permissions(ufront_auth_model_Permission::$manager->unsafeObjects("SELECT * FROM " . _hx_string_or_null($table) . " WHERE " . "groupID" . " = " . _hx_string_or_null($quotedID), null));
		}
		return $this->permissions;
	}
	public function set_permissions($list) {
		return $this->permissions = $list;
	}
	public function _validationsFromMacros() {
		parent::_validationsFromMacros();
		if($this->name === null) {
			ufront_db__ValidationErrors_ValidationErrors_Impl_::set($this->validationErrors, "name", "name" . " is a required field.");
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
	static $manager;
	static $__properties__ = array("set_permissions" => "set_permissions","get_permissions" => "get_permissions","get_users" => "get_users","get_saved" => "get_saved");
	function __toString() { return 'ufront.auth.model.Group'; }
}
ufront_auth_model_Group::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => (new _hx_array(array("oy4:namey10:auth_groupy7:indexesahy9:relationsahy7:hfieldsby2:idoR0R5y6:isNullfy1:tjy17:sys.db.RecordType:0:0gR0oR0R0R6fR7jR8:9:1i255gy8:modifiedoR0R9R6fR7jR8:11:0gy7:createdoR0R10R6fR7r9ghy3:keyaR5hy6:fieldsar4r10r8r6hg"))), "ufRelationships" => (new _hx_array(array("users,ManyToMany,ufront.auth.model.User", "permissions,HasMany,ufront.auth.model.Permission,defaultUfrontControllerID"))), "ufSerialize" => (new _hx_array(array("name", "ManyToManyusers", "id", "created", "modified")))))));
ufront_auth_model_Group::$manager = new sys_db_Manager(_hx_qtype("ufront.auth.model.Group"));
