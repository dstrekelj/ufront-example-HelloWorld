<?php

class tink_core__Pair_Pair_Impl_ {
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
	static function toBool($this1) {
		return $this1 !== null;
	}
	static function isNil($this1) {
		return $this1 === null;
	}
	static function nil() {
		return null;
	}
	static $__properties__ = array("get_b" => "get_b","get_a" => "get_a");
	function __toString() { return 'tink.core._Pair.Pair_Impl_'; }
}
