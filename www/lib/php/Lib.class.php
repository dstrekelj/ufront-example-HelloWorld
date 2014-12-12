<?php

class php_Lib {
	public function __construct(){}
	static function hprint($v) {
		echo(Std::string($v));
	}
	static function println($v) {
		php_Lib::hprint($v);
		php_Lib::hprint("\x0A");
	}
	static function serialize($v) {
		return serialize($v);
	}
	static function isCli() {
		return (0 == strncasecmp(PHP_SAPI, 'cli', 3));
	}
	static function hashOfAssociativeArray($arr) {
		$h = new haxe_ds_StringMap();
		$h->h = $arr;
		return $h;
	}
	static function rethrow($e) {
		if(Std::is($e, _hx_qtype("php.Exception"))) {
			$__rtex__ = $e;
			throw $__rtex__;
		} else {
			throw new HException($e);
		}
	}
	static function appendType($o, $path, $t) {
		$name = $path->shift();
		if($path->length === 0) {
			$o->$name = $t;
		} else {
			$so = null;
			if(isset($o->$name)) {
				$so = $o->$name;
			} else {
				$so = _hx_anonymous(array());
			}
			php_Lib::appendType($so, $path, $t);
			$o->$name = $so;
		}
	}
	static function getClasses() {
		$path = null;
		$o = _hx_anonymous(array());
		reset(php_Boot::$qtypes);
		while(($path = key(php_Boot::$qtypes)) !== null) {
			php_Lib::appendType($o, _hx_explode(".", $path), php_Boot::$qtypes[$path]);
			next(php_Boot::$qtypes);
		}
		return $o;
	}
	function __toString() { return 'php.Lib'; }
}
