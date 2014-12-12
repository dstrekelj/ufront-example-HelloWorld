<?php

class DynamicsT {
	public function __construct(){}
	static function toHash($ob) {
		$Map = new haxe_ds_StringMap();
		return DynamicsT::copyToHash($ob, $Map);
	}
	static function copyToHash($ob, $hash) {
		{
			$_g = 0;
			$_g1 = Reflect::fields($ob);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$value = Reflect::field($ob, $field);
				$hash->set($field, $value);
				unset($value,$field);
			}
		}
		return $hash;
	}
	function __toString() { return 'DynamicsT'; }
}
