<?php

class tink_core__Ref_Ref_Impl_ {
	public function __construct(){}
	static function _new() {
		return tink_core__Ref_Ref_Impl__0();
	}
	static function get_value($this1) {
		return $this1[0];
	}
	static function set_value($this1, $param) {
		return $this1[0] = $param;
	}
	static function toString($this1) {
		return "@[" . Std::string($this1[0]) . "]";
	}
	static function to($v) {
		$ret = null;
		$ret = tink_core__Ref_Ref_Impl__1($ret, $v);
		$ret[0] = $v;
		return $ret;
	}
	static $__properties__ = array("set_value" => "set_value","get_value" => "get_value");
	function __toString() { return 'tink.core._Ref.Ref_Impl_'; }
}
function tink_core__Ref_Ref_Impl__0() {
	{
		$this1 = null;
		$this1 = (new _hx_array(array()));
		$this1->length = 1;
		return $this1;
	}
}
function tink_core__Ref_Ref_Impl__1(&$ret, &$v) {
	{
		$this1 = null;
		$this1 = (new _hx_array(array()));
		$this1->length = 1;
		return $this1;
	}
}
