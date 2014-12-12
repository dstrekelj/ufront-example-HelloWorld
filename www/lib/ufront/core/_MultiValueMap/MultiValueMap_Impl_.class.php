<?php

class ufront_core__MultiValueMap_MultiValueMap_Impl_ {
	public function __construct(){}
	static function _new() {
		return new haxe_ds_StringMap();
	}
	static function keys($this1) {
		return $this1->keys();
	}
	static function exists($this1, $name) {
		return $this1->exists($name);
	}
	static function iterator($this1) {
		return _hx_deref((ufront_core__MultiValueMap_MultiValueMap_Impl__0($this1)))->iterator();
	}
	static function get($this1, $name) {
		if($this1->exists($name)) {
			$arr = $this1->get($name);
			return $arr[$arr->length - 1];
		} else {
			return null;
		}
	}
	static function getAll($this1, $name) {
		if($this1->exists($name)) {
			return $this1->get($name);
		} else {
			return (new _hx_array(array()));
		}
	}
	static function set($this1, $name, $value) {
		if($value !== null) {
			if(StringTools::endsWith($name, "[]")) {
				$name = _hx_substr($name, 0, strlen($name) - 2);
			} else {
				$name = $name;
			}
			$this1->set($name, (new _hx_array(array($value))));
		}
	}
	static function add($this1, $name, $value) {
		if($value !== null) {
			if($name !== null) {
				if(StringTools::endsWith($name, "[]")) {
					$name = _hx_substr($name, 0, strlen($name) - 2);
				} else {
					$name = $name;
				}
			} else {
				$name = "";
			}
			if($this1->exists($name)) {
				$this1->get($name)->push($value);
			} else {
				$this1->set($name, (new _hx_array(array($value))));
			}
		}
	}
	static function remove($this1, $key) {
		return $this1->remove($key);
	}
	static function hclone($this1) {
		$newMap = new haxe_ds_StringMap();
		if(null == $this1) throw new HException('null iterable');
		$__hx__it = $this1->keys();
		while($__hx__it->hasNext()) {
			$k = $__hx__it->next();
			$_g = 0;
			$_g1 = $this1->get($k);
			while($_g < $_g1->length) {
				$v = $_g1[$_g];
				++$_g;
				ufront_core__MultiValueMap_MultiValueMap_Impl_::add($newMap, $k, $v);
				unset($v);
			}
			unset($_g1,$_g);
		}
		return $newMap;
	}
	static function toString($this1) {
		$sb = new StringBuf();
		$sb->add("[");
		if(null == $this1) throw new HException('null iterable');
		$__hx__it = $this1->keys();
		while($__hx__it->hasNext()) {
			$key = $__hx__it->next();
			$sb->add("\x0A\x09" . _hx_string_or_null($key) . " = [");
			$sb->add(ufront_core__MultiValueMap_MultiValueMap_Impl_::getAll($this1, $key)->join(", "));
			$sb->add("]");
		}
		if(strlen($sb->b) > 1) {
			$sb->add("\x0A");
		}
		$sb->add("]");
		return $sb->b;
	}
	static function stripArrayFromName($this1, $name) {
		if(StringTools::endsWith($name, "[]")) {
			return _hx_substr($name, 0, strlen($name) - 2);
		} else {
			return $name;
		}
	}
	static function toMapOfArrays($this1) {
		return $this1;
	}
	static function fromMapOfArrays($map) {
		return $map;
	}
	static function toStringMap($this1) {
		$sm = new haxe_ds_StringMap();
		if(null == $this1) throw new HException('null iterable');
		$__hx__it = $this1->keys();
		while($__hx__it->hasNext()) {
			$key = $__hx__it->next();
			$sm->set($key, ufront_core__MultiValueMap_MultiValueMap_Impl_::get($this1, $key));
		}
		return $sm;
	}
	static function toMap($this1) {
		return ufront_core__MultiValueMap_MultiValueMap_Impl_::toStringMap($this1);
	}
	static function fromStringMap($stringMap) {
		$qm = new haxe_ds_StringMap();
		if($stringMap !== null) {
			if(null == $stringMap) throw new HException('null iterable');
			$__hx__it = $stringMap->keys();
			while($__hx__it->hasNext()) {
				$key = $__hx__it->next();
				ufront_core__MultiValueMap_MultiValueMap_Impl_::set($qm, $key, $stringMap->get($key));
			}
		}
		return $qm;
	}
	static function fromMap($map) {
		return ufront_core__MultiValueMap_MultiValueMap_Impl_::fromStringMap($map);
	}
	static function combine($maps) {
		$qm = new haxe_ds_StringMap();
		{
			$_g = 0;
			while($_g < $maps->length) {
				$map = $maps[$_g];
				++$_g;
				if(null == $map) throw new HException('null iterable');
				$__hx__it = $map->keys();
				while($__hx__it->hasNext()) {
					$key = $__hx__it->next();
					$_g1 = 0;
					$_g2 = ufront_core__MultiValueMap_MultiValueMap_Impl_::getAll($map, $key);
					while($_g1 < $_g2->length) {
						$val = $_g2[$_g1];
						++$_g1;
						ufront_core__MultiValueMap_MultiValueMap_Impl_::add($qm, $key, $val);
						unset($val);
					}
					unset($_g2,$_g1);
				}
				unset($map);
			}
		}
		return $qm;
	}
	function __toString() { return 'ufront.core._MultiValueMap.MultiValueMap_Impl_'; }
}
function ufront_core__MultiValueMap_MultiValueMap_Impl__0(&$this1) {
	{
		$_g = (new _hx_array(array()));
		if(null == $this1) throw new HException('null iterable');
		$__hx__it = $this1->iterator();
		while($__hx__it->hasNext()) {
			$arr = $__hx__it->next();
			$_g1 = 0;
			while($_g1 < $arr->length) {
				$v = $arr[$_g1];
				++$_g1;
				$_g->push($v);
				unset($v);
			}
			unset($_g1);
		}
		return $_g;
	}
}
