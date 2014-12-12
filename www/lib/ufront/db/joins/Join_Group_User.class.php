<?php

class ufront_db_joins_Join_Group_User extends ufront_db_Relationship {
	public function __construct($r1, $r2) { if(!php_Boot::$skip_constructor) {
		parent::__construct($r1,$r2);
	}}
	public function _validationsFromMacros() {
		parent::_validationsFromMacros();
	}
	static function __meta__() { $args = func_get_args(); return call_user_func_array(self::$__meta__, $args); }
	static $__meta__;
	static $manager;
	static $__properties__ = array("get_saved" => "get_saved");
	function __toString() { return 'ufront.db.joins.Join_Group_User'; }
}
ufront_db_joins_Join_Group_User::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => (new _hx_array(array("oy4:namey16:_join_Group_Usery7:indexesahy9:relationsahy7:hfieldsby2:idoR0R5y6:isNullfy1:tjy17:sys.db.RecordType:0:0gy8:modifiedoR0R9R6fR7jR8:11:0gy2:r2oR0R10R6fR7jR8:3:0gy7:createdoR0R11R6fR7r7gy2:r1oR0R12R6fR7r9ghy3:keyaR5hy6:fieldsar4r10r6r11r8hg"))), "ufRelationships" => null, "ufSerialize" => (new _hx_array(array("r1", "r2", "id", "created", "modified")))))));
ufront_db_joins_Join_Group_User::$manager = new sys_db_Manager(_hx_qtype("ufront.db.joins.Join_Group_User"));
