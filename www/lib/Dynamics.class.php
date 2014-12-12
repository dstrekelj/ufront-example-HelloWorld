<?php

class Dynamics {
	public function __construct(){}
	static function format($v, $param = null, $params = null, $nullstring = null, $culture = null) {
		return call_user_func_array(Dynamics::formatf($param, $params, $nullstring, $culture), array($v));
	}
	static function formatf($param = null, $params = null, $nullstring = null, $culture = null) {
		if($nullstring === null) {
			$nullstring = "null";
		}
		return array(new _hx_lambda(array(&$culture, &$nullstring, &$param, &$params), "Dynamics_0"), 'execute');
	}
	static function interpolate($v, $a, $b, $equation = null) {
		return call_user_func_array(Dynamics::interpolatef($a, $b, $equation), array($v));
	}
	static function interpolatef($a, $b, $equation = null) {
		$ta = Type::typeof($a);
		$tb = Type::typeof($b);
		if(!((Std::is($a, _hx_qtype("Float")) || Std::is($a, _hx_qtype("Int"))) && (Std::is($b, _hx_qtype("Float")) || Std::is($b, _hx_qtype("Int")))) && !Type::enumEq($ta, $tb)) {
			throw new HException(new thx_error_Error("arguments a ({0}) and b ({0}) have different types", (new _hx_array(array($a, $b))), null, _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 61, "className" => "Dynamics", "methodName" => "interpolatef"))));
		}
		switch($ta->index) {
		case 0:{
			return array(new _hx_lambda(array(&$a, &$b, &$equation, &$ta, &$tb), "Dynamics_1"), 'execute');
		}break;
		case 1:{
			if(Std::is($b, _hx_qtype("Int"))) {
				return Ints::interpolatef($a, $b, $equation);
			} else {
				return Floats::interpolatef($a, $b, $equation);
			}
		}break;
		case 2:{
			return Floats::interpolatef($a, $b, $equation);
		}break;
		case 3:{
			return Bools::interpolatef($a, $b, $equation);
		}break;
		case 4:{
			return Objects::interpolatef($a, $b, $equation);
		}break;
		case 6:{
			$c = $ta->params[0];
			{
				$name = Type::getClassName($c);
				switch($name) {
				case "String":{
					return Strings::interpolatef($a, $b, $equation);
				}break;
				case "Date":{
					return Dates::interpolatef($a, $b, $equation);
				}break;
				default:{
					throw new HException(new thx_error_Error("cannot interpolate on instances of {0}", null, $name, _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 79, "className" => "Dynamics", "methodName" => "interpolatef"))));
				}break;
				}
			}
		}break;
		default:{
			throw new HException(new thx_error_Error("cannot interpolate on functions/enums/unknown", null, null, _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 81, "className" => "Dynamics", "methodName" => "interpolatef"))));
		}break;
		}
	}
	static function string($v) {
		{
			$_g = Type::typeof($v);
			switch($_g->index) {
			case 0:{
				return "null";
			}break;
			case 1:{
				return Ints::format($v, null, null, null);
			}break;
			case 2:{
				return Floats::format($v, null, null, null);
			}break;
			case 3:{
				return Bools::format($v, null, null, null);
			}break;
			case 4:{
				$keys = null;
				{
					$o = $v;
					$keys = Reflect::fields($o);
				}
				$result = (new _hx_array(array()));
				{
					$_g1 = 0;
					while($_g1 < $keys->length) {
						$key = $keys[$_g1];
						++$_g1;
						$result->push(_hx_string_or_null($key) . " : " . _hx_string_or_null(Dynamics::string(Reflect::field($v, $key))));
						unset($key);
					}
				}
				return "{" . _hx_string_or_null($result->join(", ")) . "}";
			}break;
			case 6:{
				$c = $_g->params[0];
				{
					$name = Type::getClassName($c);
					switch($name) {
					case "Array":{
						return Arrays::string($v);
					}break;
					case "String":{
						$s = $v;
						if(_hx_index_of($s, "\"", null) < 0) {
							return "\"" . _hx_string_or_null($s) . "\"";
						} else {
							if(_hx_index_of($s, "'", null) < 0) {
								return "'" . _hx_string_or_null($s) . "'";
							} else {
								return "\"" . _hx_string_or_null(str_replace("\"", "\\\"", $s)) . "\"";
							}
						}
					}break;
					case "Date":{
						return Dates::format($v, null, null, null);
					}break;
					default:{
						return Std::string($v);
					}break;
					}
				}
			}break;
			case 7:{
				return Enums::string($v);
			}break;
			case 8:{
				return "<unknown>";
			}break;
			case 5:{
				return "<function>";
			}break;
			}
		}
	}
	static function compare($a, $b) {
		if(null === $a && null === $b) {
			return 0;
		}
		if(null === $a) {
			return -1;
		}
		if(null === $b) {
			return 1;
		}
		{
			$_g = Type::typeof($a);
			switch($_g->index) {
			case 1:case 2:{
				$a1 = $a;
				$b1 = $b;
				if($a1 < $b1) {
					return -1;
				} else {
					if($a1 > $b1) {
						return 1;
					} else {
						return 0;
					}
				}
			}break;
			case 3:{
				$a2 = $a;
				$b2 = $b;
				if($a2 === $b2) {
					return 0;
				} else {
					if($a2) {
						return -1;
					} else {
						return 1;
					}
				}
			}break;
			case 4:{
				return Objects::compare($a, $b);
			}break;
			case 6:{
				$c = $_g->params[0];
				{
					$name = Type::getClassName($c);
					switch($name) {
					case "Array":{
						return Arrays::compare($a, $b);
					}break;
					case "String":{
						return Strings::compare($a, $b);
					}break;
					case "Date":{
						$a3 = $a;
						$b3 = $b;
						{
							$a4 = $a3->getTime();
							$b4 = $b3->getTime();
							if($a4 < $b4) {
								return -1;
							} else {
								if($a4 > $b4) {
									return 1;
								} else {
									return 0;
								}
							}
						}
					}break;
					default:{
						return Strings::compare(Std::string($a), Std::string($b));
					}break;
					}
				}
			}break;
			case 7:{
				return Enums::compare($a, $b);
			}break;
			default:{
				return 0;
			}break;
			}
		}
	}
	static function comparef($sample) {
		{
			$_g = Type::typeof($sample);
			switch($_g->index) {
			case 1:case 2:{
				return (isset(Floats::$compare) ? Floats::$compare: array("Floats", "compare"));
			}break;
			case 3:{
				return (isset(Bools::$compare) ? Bools::$compare: array("Bools", "compare"));
			}break;
			case 4:{
				return (isset(Objects::$compare) ? Objects::$compare: array("Objects", "compare"));
			}break;
			case 6:{
				$c = $_g->params[0];
				{
					$name = Type::getClassName($c);
					switch($name) {
					case "Array":{
						return (isset(Arrays::$compare) ? Arrays::$compare: array("Arrays", "compare"));
					}break;
					case "String":{
						return (isset(Strings::$compare) ? Strings::$compare: array("Strings", "compare"));
					}break;
					case "Date":{
						return (isset(Dates::$compare) ? Dates::$compare: array("Dates", "compare"));
					}break;
					default:{
						return array(new _hx_lambda(array(&$_g, &$c, &$name, &$sample), "Dynamics_2"), 'execute');
					}break;
					}
				}
			}break;
			case 7:{
				return (isset(Enums::$compare) ? Enums::$compare: array("Enums", "compare"));
			}break;
			default:{
				return (isset(Dynamics::$compare) ? Dynamics::$compare: array("Dynamics", "compare"));
			}break;
			}
		}
	}
	static function hclone($v, $cloneInstances = null) {
		if($cloneInstances === null) {
			$cloneInstances = false;
		}
		{
			$_g = Type::typeof($v);
			switch($_g->index) {
			case 0:{
				return null;
			}break;
			case 1:case 2:case 3:case 7:case 8:case 5:{
				return $v;
			}break;
			case 4:{
				$o = _hx_anonymous(array());
				Objects::copyTo($v, $o);
				return $o;
			}break;
			case 6:{
				$c = $_g->params[0];
				{
					$name = Type::getClassName($c);
					switch($name) {
					case "Array":{
						$src = $v;
						$a = (new _hx_array(array()));
						{
							$_g1 = 0;
							while($_g1 < $src->length) {
								$i = $src[$_g1];
								++$_g1;
								$a->push(Dynamics::hclone($i, null));
								unset($i);
							}
						}
						return $a;
					}break;
					case "String":case "Date":{
						return $v;
					}break;
					default:{
						if($cloneInstances) {
							$o1 = Type::createEmptyInstance($c);
							{
								$_g11 = 0;
								$_g2 = Reflect::fields($v);
								while($_g11 < $_g2->length) {
									$field = $_g2[$_g11];
									++$_g11;
									$value = Dynamics::hclone(Reflect::field($v, $field), null);
									$o1->{$field} = $value;
									unset($value,$field);
								}
							}
							return $o1;
						} else {
							return $v;
						}
					}break;
					}
				}
			}break;
			}
		}
	}
	static function same($a, $b) {
		$ta = Types::typeName($a);
		$tb = Types::typeName($b);
		if($ta !== $tb) {
			return false;
		}
		{
			$_g = Type::typeof($a);
			switch($_g->index) {
			case 2:{
				return Floats::equals($a, $b, null);
			}break;
			case 0:case 1:case 3:{
				return (is_object($_t = $a) && !($_t instanceof Enum) ? $_t === $b : $_t == $b);
			}break;
			case 5:{
				return Reflect::compareMethods($a, $b);
			}break;
			case 6:{
				$c = $_g->params[0];
				{
					$ca = Type::getClassName($c);
					$cb = Type::getClassName(Type::getClass($b));
					if($ca !== $cb) {
						return false;
					}
					if(Std::is($a, _hx_qtype("String")) && (is_object($_t = $a) && !($_t instanceof Enum) ? $_t !== $b : $_t != $b)) {
						return false;
					}
					if(Std::is($a, _hx_qtype("Array"))) {
						$aa = $a;
						$ab = $b;
						if($aa->length !== $ab->length) {
							return false;
						}
						{
							$_g2 = 0;
							$_g1 = $aa->length;
							while($_g2 < $_g1) {
								$i = $_g2++;
								if(!Dynamics::same($aa[$i], $ab[$i])) {
									return false;
								}
								unset($i);
							}
						}
						return true;
					}
					if(Std::is($a, _hx_qtype("Date"))) {
						return _hx_equal($a->getTime(), $b->getTime());
					}
					if(Std::is($a, _hx_qtype("haxe.ds.StringMap")) || Std::is($a, _hx_qtype("haxe.ds.IntMap"))) {
						$ha = $a;
						$hb = $b;
						$ka = Iterators::harray($ha->keys());
						$kb = Iterators::harray($hb->keys());
						if($ka->length !== $kb->length) {
							return false;
						}
						{
							$_g11 = 0;
							while($_g11 < $ka->length) {
								$key = $ka[$_g11];
								++$_g11;
								if(!$hb->exists($key) || !Dynamics::same($ha->get($key), $hb->get($key))) {
									return false;
								}
								unset($key);
							}
						}
						return true;
					}
					$t = false;
					if(($t = Iterators::isIterator($a)) || Iterables::isIterable($a)) {
						$va = null;
						if($t) {
							$va = Iterators::harray($a);
						} else {
							$va = Iterators::harray($a->iterator());
						}
						$vb = null;
						if($t) {
							$vb = Iterators::harray($b);
						} else {
							$vb = Iterators::harray($b->iterator());
						}
						if($va->length !== $vb->length) {
							return false;
						}
						{
							$_g21 = 0;
							$_g12 = $va->length;
							while($_g21 < $_g12) {
								$i1 = $_g21++;
								if(!Dynamics::same($va[$i1], $vb[$i1])) {
									return false;
								}
								unset($i1);
							}
						}
						return true;
					}
					$fields = Type::getInstanceFields(Type::getClass($a));
					{
						$_g13 = 0;
						while($_g13 < $fields->length) {
							$field = $fields[$_g13];
							++$_g13;
							$va1 = Reflect::field($a, $field);
							if(Reflect::isFunction($va1)) {
								continue;
							}
							$vb1 = Reflect::field($b, $field);
							if(!Dynamics::same($va1, $vb1)) {
								return false;
							}
							unset($vb1,$va1,$field);
						}
					}
					return true;
				}
			}break;
			case 7:{
				$e = $_g->params[0];
				{
					$ea = Type::getEnumName($e);
					$teb = Type::getEnum($b);
					$eb = Type::getEnumName($teb);
					if($ea !== $eb) {
						return false;
					}
					if($a->index !== $b->index) {
						return false;
					}
					$pa = Type::enumParameters($a);
					$pb = Type::enumParameters($b);
					{
						$_g22 = 0;
						$_g14 = $pa->length;
						while($_g22 < $_g14) {
							$i2 = $_g22++;
							if(!Dynamics::same($pa[$i2], $pb[$i2])) {
								return false;
							}
							unset($i2);
						}
					}
					return true;
				}
			}break;
			case 4:{
				$fa = Reflect::fields($a);
				$fb = Reflect::fields($b);
				{
					$_g15 = 0;
					while($_g15 < $fa->length) {
						$field1 = $fa[$_g15];
						++$_g15;
						$fb->remove($field1);
						if(!_hx_has_field($b, $field1)) {
							return false;
						}
						$va2 = Reflect::field($a, $field1);
						if(Reflect::isFunction($va2)) {
							continue;
						}
						$vb2 = Reflect::field($b, $field1);
						if(!Dynamics::same($va2, $vb2)) {
							return false;
						}
						unset($vb2,$va2,$field1);
					}
				}
				if($fb->length > 0) {
					return false;
				}
				$t1 = false;
				if(($t1 = Iterators::isIterator($a)) || Iterables::isIterable($a)) {
					if($t1 && !Iterators::isIterator($b)) {
						return false;
					}
					if(!$t1 && !Iterables::isIterable($b)) {
						return false;
					}
					$aa1 = null;
					if($t1) {
						$aa1 = Iterators::harray($a);
					} else {
						$aa1 = Iterators::harray($a->iterator());
					}
					$ab1 = null;
					if($t1) {
						$ab1 = Iterators::harray($b);
					} else {
						$ab1 = Iterators::harray($b->iterator());
					}
					if($aa1->length !== $ab1->length) {
						return false;
					}
					{
						$_g23 = 0;
						$_g16 = $aa1->length;
						while($_g23 < $_g16) {
							$i3 = $_g23++;
							if(!Dynamics::same($aa1[$i3], $ab1[$i3])) {
								return false;
							}
							unset($i3);
						}
					}
					return true;
				}
				return true;
			}break;
			case 8:{
				throw new HException("Unable to compare two unknown types");
			}break;
			}
		}
		throw new HException(new thx_error_Error("Unable to compare values: {0} and {1}", (new _hx_array(array($a, $b))), null, _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 371, "className" => "Dynamics", "methodName" => "same"))));
	}
	static function number($v) {
		if(Std::is($v, _hx_qtype("Bool"))) {
			if(_hx_equal($v, true)) {
				return 1;
			} else {
				return 0;
			}
		} else {
			if(Std::is($v, _hx_qtype("Date"))) {
				return $v->getTime();
			} else {
				if(Std::is($v, _hx_qtype("String"))) {
					return Std::parseFloat($v);
				} else {
					return Math::$NaN;
				}
			}
		}
	}
	function __toString() { return 'Dynamics'; }
}
function Dynamics_0(&$culture, &$nullstring, &$param, &$params, $v) {
	{
		{
			$_g = Type::typeof($v);
			switch($_g->index) {
			case 0:{
				return $nullstring;
			}break;
			case 1:{
				return Ints::format($v, $param, $params, $culture);
			}break;
			case 2:{
				return Floats::format($v, $param, $params, $culture);
			}break;
			case 3:{
				return Bools::format($v, $param, $params, $culture);
			}break;
			case 6:{
				$c = $_g->params[0];
				if((is_object($_t = $c) && !($_t instanceof Enum) ? $_t === _hx_qtype("String") : $_t == _hx_qtype("String"))) {
					return Strings::formatOne($v, $param, $params, $culture);
				} else {
					if((is_object($_t2 = $c) && !($_t2 instanceof Enum) ? $_t2 === _hx_qtype("Array") : $_t2 == _hx_qtype("Array"))) {
						return Arrays::format($v, $param, $params, $culture);
					} else {
						if((is_object($_t3 = $c) && !($_t3 instanceof Enum) ? $_t3 === _hx_qtype("Date") : $_t3 == _hx_qtype("Date"))) {
							return Dates::format($v, $param, $params, $culture);
						} else {
							return Objects::format($v, $param, $params, $culture);
						}
					}
				}
			}break;
			case 4:{
				return Objects::format($v, $param, $params, $culture);
			}break;
			case 5:{
				return "function()";
			}break;
			default:{
				throw new HException(new thx_error_Error("Unsupported type format: {0}", null, Type::typeof($v), _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 46, "className" => "Dynamics", "methodName" => "formatf"))));
			}break;
			}
		}
	}
}
function Dynamics_1(&$a, &$b, &$equation, &$ta, &$tb, $_) {
	{
		return null;
	}
}
function Dynamics_2(&$_g, &$c, &$name, &$sample, $a, $b) {
	{
		return Strings::compare(Std::string($a), Std::string($b));
	}
}
