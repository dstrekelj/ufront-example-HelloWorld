<?php

class Objects {
	public function __construct(){}
	static function field($o, $fieldname, $alt = null) {
		if(_hx_has_field($o, $fieldname)) {
			return Reflect::field($o, $fieldname);
		} else {
			return $alt;
		}
	}
	static function keys($o) {
		return Reflect::fields($o);
	}
	static function values($o) {
		$arr = (new _hx_array(array()));
		{
			$_g = 0;
			$_g1 = Reflect::fields($o);
			while($_g < $_g1->length) {
				$key = $_g1[$_g];
				++$_g;
				$arr->push(Reflect::field($o, $key));
				unset($key);
			}
		}
		return $arr;
	}
	static function entries($o) {
		$arr = (new _hx_array(array()));
		{
			$_g = 0;
			$_g1 = Reflect::fields($o);
			while($_g < $_g1->length) {
				$key = $_g1[$_g];
				++$_g;
				$arr->push(_hx_anonymous(array("key" => $key, "value" => Reflect::field($o, $key))));
				unset($key);
			}
		}
		return $arr;
	}
	static function each($o, $handler) {
		$_g = 0;
		$_g1 = Reflect::fields($o);
		while($_g < $_g1->length) {
			$key = $_g1[$_g];
			++$_g;
			call_user_func_array($handler, array($key, Reflect::field($o, $key)));
			unset($key);
		}
	}
	static function map($o, $handler) {
		$results = (new _hx_array(array()));
		{
			$_g = 0;
			$_g1 = Reflect::fields($o);
			while($_g < $_g1->length) {
				$key = $_g1[$_g];
				++$_g;
				$results->push(call_user_func_array($handler, array($key, Reflect::field($o, $key))));
				unset($key);
			}
		}
		return $results;
	}
	static function with($ob, $f) {
		call_user_func_array($f, array($ob));
		return $ob;
	}
	static function toHash($ob) {
		$Map = new haxe_ds_StringMap();
		return Objects::copyToHash($ob, $Map);
	}
	static function copyToHash($ob, $Map) {
		{
			$_g = 0;
			$_g1 = Reflect::fields($ob);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$value = Reflect::field($ob, $field);
				$Map->set($field, $value);
				unset($value,$field);
			}
		}
		return $Map;
	}
	static function interpolate($v, $a, $b, $equation = null) {
		return call_user_func_array(Objects::interpolatef($a, $b, $equation), array($v));
	}
	static function interpolatef($a, $b, $equation = null) {
		$i = _hx_anonymous(array());
		$c = _hx_anonymous(array());
		$keys = Reflect::fields($a);
		{
			$_g = 0;
			while($_g < $keys->length) {
				$key = $keys[$_g];
				++$_g;
				if(_hx_has_field($b, $key)) {
					$va = Reflect::field($a, $key);
					{
						$value = Dynamics::interpolatef($va, Reflect::field($b, $key), null);
						$i->{$key} = $value;
						unset($value);
					}
					unset($va);
				} else {
					$value1 = Reflect::field($a, $key);
					$c->{$key} = $value1;
					unset($value1);
				}
				unset($key);
			}
		}
		$keys = Reflect::fields($b);
		{
			$_g1 = 0;
			while($_g1 < $keys->length) {
				$key1 = $keys[$_g1];
				++$_g1;
				if(!_hx_has_field($a, $key1)) {
					$value2 = Reflect::field($b, $key1);
					$c->{$key1} = $value2;
					unset($value2);
				}
				unset($key1);
			}
		}
		return array(new _hx_lambda(array(&$a, &$b, &$c, &$equation, &$i, &$keys), "Objects_0"), 'execute');
	}
	static function copyTo($src, $dst) {
		{
			$_g = 0;
			$_g1 = Reflect::fields($src);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$sv = Dynamics::hclone(Reflect::field($src, $field), null);
				$dv = Reflect::field($dst, $field);
				if(Reflect::isObject($sv) && null === Type::getClass($sv) && (Reflect::isObject($dv) && null === Type::getClass($dv))) {
					Objects::copyTo($sv, $dv);
				} else {
					$dst->{$field} = $sv;
				}
				unset($sv,$field,$dv);
			}
		}
		return $dst;
	}
	static function hclone($src) {
		$dst = _hx_anonymous(array());
		return Objects::copyTo($src, $dst);
	}
	static function mergef($ob, $new_ob, $f) {
		$_g = 0;
		$_g1 = Reflect::fields($new_ob);
		while($_g < $_g1->length) {
			$field = $_g1[$_g];
			++$_g;
			$new_val = Reflect::field($new_ob, $field);
			if(_hx_has_field($ob, $field)) {
				$old_val = Reflect::field($ob, $field);
				{
					$value = call_user_func_array($f, array($field, $old_val, $new_val));
					$ob->{$field} = $value;
					unset($value);
				}
				unset($old_val);
			} else {
				$ob->{$field} = $new_val;
			}
			unset($new_val,$field);
		}
	}
	static function merge($ob, $new_ob) {
		Objects::mergef($ob, $new_ob, array(new _hx_lambda(array(&$new_ob, &$ob), "Objects_1"), 'execute'));
	}
	static function _flatten($src, $cum, $arr, $levels, $level) {
		$_g = 0;
		$_g1 = Reflect::fields($src);
		while($_g < $_g1->length) {
			$field = $_g1[$_g];
			++$_g;
			$clone = Objects::hclone($cum);
			$v = Reflect::field($src, $field);
			$clone->fields->push($field);
			if(Reflect::isObject($v) && null === Type::getClass($v) && ($levels === 0 || $level + 1 < $levels)) {
				Objects::_flatten($v, $clone, $arr, $levels, $level + 1);
			} else {
				$clone->value = $v;
				$arr->push($clone);
			}
			unset($v,$field,$clone);
		}
	}
	static function flatten($src, $levels = null) {
		if($levels === null) {
			$levels = 0;
		}
		$arr = (new _hx_array(array()));
		{
			$_g = 0;
			$_g1 = Reflect::fields($src);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$v = Reflect::field($src, $field);
				if(Reflect::isObject($v) && null === Type::getClass($v) && $levels !== 1) {
					$item = _hx_anonymous(array("fields" => (new _hx_array(array($field))), "value" => null));
					Objects::_flatten($v, $item, $arr, $levels, 1);
					unset($item);
				} else {
					$arr->push(_hx_anonymous(array("fields" => (new _hx_array(array($field))), "value" => $v)));
				}
				unset($v,$field);
			}
		}
		return $arr;
	}
	static function compare($a, $b) {
		$v = null;
		$fields = null;
		if(($v = Arrays::compare($fields = Reflect::fields($a), Reflect::fields($b))) !== 0) {
			return $v;
		}
		{
			$_g = 0;
			while($_g < $fields->length) {
				$field = $fields[$_g];
				++$_g;
				if(($v = Dynamics::compare(Reflect::field($a, $field), Reflect::field($b, $field))) !== 0) {
					return $v;
				}
				unset($field);
			}
		}
		return 0;
	}
	static function addFields($o, $fields, $values) {
		{
			$_g1 = 0;
			$_g = $fields->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				Objects::addField($o, $fields[$i], $values[$i]);
				unset($i);
			}
		}
		return $o;
	}
	static function addField($o, $field, $value) {
		$o->{$field} = $value;
		return $o;
	}
	static function format($v, $param = null, $params = null, $culture = null) {
		return call_user_func_array(Objects::formatf($param, $params, $culture), array($v));
	}
	static function formatf($param = null, $params = null, $culture = null) {
		$params = thx_culture_FormatParams::params($param, $params, "R");
		$format = $params->shift();
		switch($format) {
		case "O":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Objects_2"), 'execute');
		}break;
		case "R":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Objects_3"), 'execute');
		}break;
		default:{
			throw new HException(new thx_error_Error("Unsupported number format: {0}", null, $format, _hx_anonymous(array("fileName" => "Objects.hx", "lineNumber" => 242, "className" => "Objects", "methodName" => "formatf"))));
		}break;
		}
	}
	function __toString() { return 'Objects'; }
}
function Objects_0(&$a, &$b, &$c, &$equation, &$i, &$keys, $t) {
	{
		{
			$_g2 = 0;
			$_g11 = Reflect::fields($i);
			while($_g2 < $_g11->length) {
				$k = $_g11[$_g2];
				++$_g2;
				$value3 = Reflect::callMethod($i, Reflect::field($i, $k), (new _hx_array(array($t))));
				$c->{$k} = $value3;
				unset($value3,$k);
			}
		}
		return $c;
	}
}
function Objects_1(&$new_ob, &$ob, $key, $old_v, $new_v) {
	{
		return $new_v;
	}
}
function Objects_2(&$culture, &$format, &$param, &$params, $v) {
	{
		return Std::string($v);
	}
}
function Objects_3(&$culture, &$format, &$param, &$params, $v1) {
	{
		$buf = (new _hx_array(array()));
		{
			$_g = 0;
			$_g1 = Reflect::fields($v1);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$buf->push(_hx_string_or_null($field) . ":" . _hx_string_or_null(Dynamics::format(Reflect::field($v1, $field), null, null, null, $culture)));
				unset($field);
			}
		}
		return "{" . _hx_string_or_null($buf->join(",")) . "}";
	}
}
