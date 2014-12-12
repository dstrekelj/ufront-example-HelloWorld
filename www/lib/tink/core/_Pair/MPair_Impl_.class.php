<?php

class tink_core__Pair_MPair_Impl_ {
	public function __construct(){}
	static function _new($a, $b) {
		return new tink_core__Pair_Data($a, $b);
	}
	static function get_a($this1) {
		return $this1->a;
	}
	static function get_b($this1) {
		return $this1->b;
	}
	static function set_a($this1, $v) {
		return $this1->a = $v;
	}
	static function set_b($this1, $v) {
		return $this1->b = $v;
	}
	static $__properties__ = array("set_b" => "set_b","get_b" => "get_b","set_a" => "set_a","get_a" => "get_a");
	function __toString() { return 'tink.core._Pair.MPair_Impl_'; }
}
