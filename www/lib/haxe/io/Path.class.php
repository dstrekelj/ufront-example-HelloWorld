<?php

class haxe_io_Path {
	public function __construct($path) {
		if(!php_Boot::$skip_constructor) {
		$c1 = _hx_last_index_of($path, "/", null);
		$c2 = _hx_last_index_of($path, "\\", null);
		if($c1 < $c2) {
			$this->dir = _hx_substr($path, 0, $c2);
			$path = _hx_substr($path, $c2 + 1, null);
			$this->backslash = true;
		} else {
			if($c2 < $c1) {
				$this->dir = _hx_substr($path, 0, $c1);
				$path = _hx_substr($path, $c1 + 1, null);
			} else {
				$this->dir = null;
			}
		}
		$cp = _hx_last_index_of($path, ".", null);
		if($cp !== -1) {
			$this->ext = _hx_substr($path, $cp + 1, null);
			$this->file = _hx_substr($path, 0, $cp);
		} else {
			$this->ext = null;
			$this->file = $path;
		}
	}}
	public $dir;
	public $file;
	public $ext;
	public $backslash;
	public function toString() {
		return _hx_string_or_null((haxe_io_Path_0($this))) . _hx_string_or_null($this->file) . _hx_string_or_null((haxe_io_Path_1($this)));
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->__dynamics[$m]) && is_callable($this->__dynamics[$m]))
			return call_user_func_array($this->__dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call <'.$m.'>');
	}
	static function withoutDirectory($path) {
		$s = new haxe_io_Path($path);
		$s->dir = null;
		return $s->toString();
	}
	static function directory($path) {
		$s = new haxe_io_Path($path);
		if($s->dir === null) {
			return "";
		}
		return $s->dir;
	}
	static function extension($path) {
		$s = new haxe_io_Path($path);
		if($s->ext === null) {
			return "";
		}
		return $s->ext;
	}
	static function withExtension($path, $ext) {
		$s = new haxe_io_Path($path);
		$s->ext = $ext;
		return $s->toString();
	}
	static function addTrailingSlash($path) {
		if(strlen($path) === 0) {
			return "/";
		}
		$c1 = _hx_last_index_of($path, "/", null);
		$c2 = _hx_last_index_of($path, "\\", null);
		if($c1 < $c2) {
			if($c2 !== strlen($path) - 1) {
				return _hx_string_or_null($path) . "\\";
			} else {
				return $path;
			}
		} else {
			if($c1 !== strlen($path) - 1) {
				return _hx_string_or_null($path) . "/";
			} else {
				return $path;
			}
		}
	}
	static function removeTrailingSlashes($path) {
		while(true) {
			$_g = _hx_char_code_at($path, strlen($path) - 1);
			switch($_g) {
			case 47:case 92:{
				$path = _hx_substr($path, 0, -1);
			}break;
			default:{
				break 2;
			}break;
			}
			unset($_g);
		}
		return $path;
	}
	function __toString() { return $this->toString(); }
}
function haxe_io_Path_0(&$__hx__this) {
	if($__hx__this->dir === null) {
		return "";
	} else {
		return _hx_string_or_null($__hx__this->dir) . _hx_string_or_null(((($__hx__this->backslash) ? "\\" : "/")));
	}
}
function haxe_io_Path_1(&$__hx__this) {
	if($__hx__this->ext === null) {
		return "";
	} else {
		return "." . _hx_string_or_null($__hx__this->ext);
	}
}
