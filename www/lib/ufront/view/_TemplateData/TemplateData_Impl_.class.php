<?php

class ufront_view__TemplateData_TemplateData_Impl_ {
	public function __construct(){}
	static function _new($obj = null) {
		if($obj !== null) {
			return $obj;
		} else {
			return _hx_anonymous(array());
		}
	}
	static function toObject($this1) {
		return $this1;
	}
	static function toMap($this1) {
		$ret = new haxe_ds_StringMap();
		{
			$_g = 0;
			$_g1 = Reflect::fields($this1);
			while($_g < $_g1->length) {
				$k = $_g1[$_g];
				++$_g;
				$v = Reflect::field($this1, $k);
				$ret->set($k, $v);
				$v;
				unset($v,$k);
			}
		}
		return $ret;
	}
	static function toStringMap($this1) {
		return ufront_view__TemplateData_TemplateData_Impl_::toMap($this1);
	}
	static function get($this1, $key) {
		return Reflect::field($this1, $key);
	}
	static function exists($this1, $key) {
		return _hx_has_field($this1, $key);
	}
	static function set($this1, $key, $val) {
		$this1->{$key} = $val;
		return (($this1 !== null) ? $this1 : _hx_anonymous(array()));
	}
	static function array_set($this1, $key, $val) {
		$this1->{$key} = $val;
		return $val;
	}
	static function setMap($this1, $map) {
		if(null == $map) throw new HException('null iterable');
		$__hx__it = $map->keys();
		while($__hx__it->hasNext()) {
			$k = $__hx__it->next();
			ufront_view__TemplateData_TemplateData_Impl_::set($this1, $k, $map->get($k));
		}
		return (($this1 !== null) ? $this1 : _hx_anonymous(array()));
	}
	static function setObject($this1, $d) {
		{
			$_g = 0;
			$_g1 = Reflect::fields($d);
			while($_g < $_g1->length) {
				$k = $_g1[$_g];
				++$_g;
				ufront_view__TemplateData_TemplateData_Impl_::set($this1, $k, Reflect::field($d, $k));
				unset($k);
			}
		}
		return (($this1 !== null) ? $this1 : _hx_anonymous(array()));
	}
	static function fromMap($d) {
		$m = null;
		{
			$obj = _hx_anonymous(array());
			if($obj !== null) {
				$m = $obj;
			} else {
				$m = _hx_anonymous(array());
			}
		}
		ufront_view__TemplateData_TemplateData_Impl_::setMap($m, $d);
		return $m;
	}
	static function fromStringMap($d) {
		return ufront_view__TemplateData_TemplateData_Impl_::fromMap($d);
	}
	static function fromMany($dataSets) {
		$combined = null;
		{
			$obj = _hx_anonymous(array());
			if($obj !== null) {
				$combined = $obj;
			} else {
				$combined = _hx_anonymous(array());
			}
		}
		if(null == $dataSets) throw new HException('null iterable');
		$__hx__it = $dataSets->iterator();
		while($__hx__it->hasNext()) {
			$d = $__hx__it->next();
			if(Std::is($d, _hx_qtype("haxe.ds.StringMap"))) {
				$map = $d;
				ufront_view__TemplateData_TemplateData_Impl_::setMap($combined, $map);
				unset($map);
			} else {
				$obj1 = $d;
				ufront_view__TemplateData_TemplateData_Impl_::setObject($combined, $obj1);
				unset($obj1);
			}
		}
		return $combined;
	}
	static function fromObject($d) {
		return (($d !== null) ? $d : _hx_anonymous(array()));
	}
	function __toString() { return 'ufront.view._TemplateData.TemplateData_Impl_'; }
}
