<?php

class ufront_view__UFTemplate_UFTemplate_Impl_ {
	public function __construct(){}
	static function _new($cb) {
		return $cb;
	}
	static function execute($this1, $data) {
		$cb = $this1;
		return call_user_func_array($cb, array($data));
	}
	function __toString() { return 'ufront.view._UFTemplate.UFTemplate_Impl_'; }
}
