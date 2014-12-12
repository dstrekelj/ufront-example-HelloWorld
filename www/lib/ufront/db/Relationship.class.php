<?php

class ufront_db_Relationship extends ufront_db_Object {
	public function __construct($r1, $r2) {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$this->r1 = $r1;
		$this->r2 = $r2;
		$this->modified = $this->created = Date::now();
	}}
	public $r1;
	public $r2;
	public function _validationsFromMacros() {
		parent::_validationsFromMacros();
		if($this->r1 === null) {
			ufront_db__ValidationErrors_ValidationErrors_Impl_::set($this->validationErrors, "r1", "r1" . " is a required field.");
		}
		if($this->r2 === null) {
			ufront_db__ValidationErrors_ValidationErrors_Impl_::set($this->validationErrors, "r2", "r2" . " is a required field.");
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
	static $__properties__ = array("get_saved" => "get_saved");
	function __toString() { return 'ufront.db.Relationship'; }
}
ufront_db_Relationship::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => (new _hx_array(array("oy4:namey12:Relationshipy7:indexesahy9:relationsahy7:hfieldsby2:idoR0R5y6:isNullfy1:tjy17:sys.db.RecordType:0:0gy8:modifiedoR0R9R6fR7jR8:11:0gy2:r2oR0R10R6fR7jR8:3:0gy7:createdoR0R11R6fR7r7gy2:r1oR0R12R6fR7r9ghy3:keyaR5hy6:fieldsar4r10r6r11r8hg"))), "ufRelationships" => null, "ufSerialize" => (new _hx_array(array("r1", "r2", "id", "created", "modified"))), "noTable" => null))));
ufront_db_Relationship::$manager = new sys_db_Manager(_hx_qtype("ufront.db.Relationship"));
