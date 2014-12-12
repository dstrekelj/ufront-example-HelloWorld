<?php

class ufront_db__ValidationErrors_ValidationErrors_Impl_ {
	public function __construct(){}
	static function _new() {
		return new haxe_ds_StringMap();
	}
	static function reset($this1) {
		if(null == $this1) throw new HException('null iterable');
		$__hx__it = $this1->keys();
		while($__hx__it->hasNext()) {
			$key = $__hx__it->next();
			$this1->remove($key);
		}
	}
	static function set($this1, $field, $error) {
		if(!$this1->exists($field)) {
			$this1->set($field, (new _hx_array(array())));
		}
		$this1->get($field)->push($error);
		return $error;
	}
	static function errorMessage($this1, $field) {
		if(!$this1->exists($field)) {
			return null;
		}
		return $this1->get($field)->join("\x0A");
	}
	static function errors($this1, $field) {
		if(!$this1->exists($field)) {
			return (new _hx_array(array()));
		}
		return $this1->get($field);
	}
	static function isFieldValid($this1, $field) {
		if(!$this1->exists($field)) {
			return true;
		}
		return $this1->get($field)->length === 0;
	}
	static function areFieldsValid($this1, $fields) {
		$allValid = true;
		{
			$_g = 0;
			while($_g < $fields->length) {
				$f = $fields[$_g];
				++$_g;
				if(ufront_db__ValidationErrors_ValidationErrors_Impl_::isFieldValid($this1, $f) === false) {
					$allValid = false;
				}
				unset($f);
			}
		}
		return $allValid;
	}
	static function toMap($this1) {
		return $this1;
	}
	static function toSimpleMap($this1) {
		$m = new haxe_ds_StringMap();
		if(null == $this1) throw new HException('null iterable');
		$__hx__it = $this1->keys();
		while($__hx__it->hasNext()) {
			$k = $__hx__it->next();
			$value = $this1->get($k)->join("\x0A");
			$m->set($k, $value);
			unset($value);
		}
		return $this1;
	}
	static function toArray($this1) {
		$_g = (new _hx_array(array()));
		if(null == $this1) throw new HException('null iterable');
		$__hx__it = $this1->keys();
		while($__hx__it->hasNext()) {
			$key = $__hx__it->next();
			$_g1 = 0;
			$_g2 = $this1->get($key);
			while($_g1 < $_g2->length) {
				$err = $_g2[$_g1];
				++$_g1;
				$_g->push(new tink_core__Pair_Data($key, $err));
				unset($err);
			}
			unset($_g2,$_g1);
		}
		return $_g;
	}
	static function toSimpleArray($this1) {
		$_g = (new _hx_array(array()));
		if(null == $this1) throw new HException('null iterable');
		$__hx__it = $this1->iterator();
		while($__hx__it->hasNext()) {
			$arr = $__hx__it->next();
			$_g1 = 0;
			while($_g1 < $arr->length) {
				$err = $arr[$_g1];
				++$_g1;
				$_g->push($err);
				unset($err);
			}
			unset($_g1);
		}
		return $_g;
	}
	static function toString($this1) {
		return ufront_db__ValidationErrors_ValidationErrors_Impl_::toSimpleArray($this1)->join("\x0A");
	}
	static function iterator($this1) {
		return ufront_db__ValidationErrors_ValidationErrors_Impl_::toArray($this1)->iterator();
	}
	static function get_length($this1) {
		$l = 0;
		if(null == $this1) throw new HException('null iterable');
		$__hx__it = $this1->iterator();
		while($__hx__it->hasNext()) {
			$arr = $__hx__it->next();
			$l += $arr->length;
		}
		return $l;
	}
	static function get_isValid($this1) {
		return ufront_db__ValidationErrors_ValidationErrors_Impl_::get_length($this1) === 0;
	}
	static function get_isInvalid($this1) {
		return ufront_db__ValidationErrors_ValidationErrors_Impl_::get_length($this1) > 0;
	}
	static $__properties__ = array("get_isInvalid" => "get_isInvalid","get_isValid" => "get_isValid","get_length" => "get_length");
	function __toString() { return 'ufront.db._ValidationErrors.ValidationErrors_Impl_'; }
}
