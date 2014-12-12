<?php

class Types {
	public function __construct(){}
	static function className($o) {
		return _hx_explode(".", Type::getClassName(Type::getClass($o)))->pop();
	}
	static function fullName($o) {
		return Type::getClassName(Type::getClass($o));
	}
	static function typeName($o) {
		{
			$_g = Type::typeof($o);
			switch($_g->index) {
			case 0:{
				return "null";
			}break;
			case 1:{
				return "Int";
			}break;
			case 2:{
				return "Float";
			}break;
			case 3:{
				return "Bool";
			}break;
			case 5:{
				return "function";
			}break;
			case 6:{
				$c = $_g->params[0];
				return Type::getClassName($c);
			}break;
			case 7:{
				$e = $_g->params[0];
				return Type::getEnumName($e);
			}break;
			case 4:{
				return "Object";
			}break;
			case 8:{
				return "Unknown";
			}break;
			}
		}
	}
	static function hasSuperClass($type, $sup) {
		while(null !== $type) {
			if($type === $sup) {
				return true;
			}
			$type = Type::getSuperClass($type);
		}
		return false;
	}
	static function isAnonymous($v) {
		return Reflect::isObject($v) && null === Type::getClass($v);
	}
	static function has($value, $type) {
		if(Std::is($value, $type)) {
			return $value;
		} else {
			return null;
		}
	}
	static function ifIs($value, $type, $handler) {
		if(Std::is($value, $type)) {
			call_user_func_array($handler, array($value));
		}
		return $value;
	}
	static function of($type, $value) {
		if(Std::is($value, $type)) {
			return $value;
		} else {
			return null;
		}
	}
	static function sameType($a, $b) {
		if(null === $a && $b === null) {
			return true;
		}
		if(null === $a || $b === null) {
			return false;
		}
		$tb = Type::typeof($b);
		switch($tb->index) {
		case 6:{
			$c = $tb->params[0];
			return Std::is($a, $c);
		}break;
		case 7:{
			$e = $tb->params[0];
			return Std::is($a, $e);
		}break;
		default:{
			return Type::typeof($a) === $tb;
		}break;
		}
	}
	static function isPrimitive($v) {
		{
			$_g = Type::typeof($v);
			switch($_g->index) {
			case 0:case 1:case 2:case 3:{
				return true;
			}break;
			case 5:case 7:case 4:case 8:{
				return false;
			}break;
			case 6:{
				$c = $_g->params[0];
				return Type::getClassName($c) === "String";
			}break;
			}
		}
	}
	function __toString() { return 'Types'; }
}
