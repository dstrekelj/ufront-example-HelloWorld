<?php

class tink_core__Callback_CallbackList_Impl_ {
	public function __construct(){}
	static function _new() {
		return (new _hx_array(array()));
	}
	static function get_length($this1) {
		return $this1->length;
	}
	static function add($this1, $cb) {
		$cell = null;
		if(tink_core__Callback_Cell::$pool->length > 0) {
			$cell = tink_core__Callback_Cell::$pool->pop();
		} else {
			$cell = new tink_core__Callback_Cell();
		}
		$cell->cb = $cb;
		$this1->push($cell);
		return array(new _hx_lambda(array(&$cb, &$cell, &$this1), "tink_core__Callback_CallbackList_Impl__0"), 'execute');
	}
	static function invoke($this1, $data) {
		$_g = 0;
		$_g1 = $this1->copy();
		while($_g < $_g1->length) {
			$cell = $_g1[$_g];
			++$_g;
			if($cell->cb !== null) {
				$cell->cb($data);
			}
			unset($cell);
		}
	}
	static function clear($this1) {
		$_g = 0;
		$_g1 = $this1->splice(0, $this1->length);
		while($_g < $_g1->length) {
			$cell = $_g1[$_g];
			++$_g;
			$cell->cb = null;
			tink_core__Callback_Cell::$pool->push($cell);
			unset($cell);
		}
	}
	static $__properties__ = array("get_length" => "get_length");
	function __toString() { return 'tink.core._Callback.CallbackList_Impl_'; }
}
function tink_core__Callback_CallbackList_Impl__0(&$cb, &$cell, &$this1) {
	{
		if($this1->remove($cell)) {
			$cell->cb = null;
			tink_core__Callback_Cell::$pool->push($cell);
		}
		$cell = null;
	}
}
