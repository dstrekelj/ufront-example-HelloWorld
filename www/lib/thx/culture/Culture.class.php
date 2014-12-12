<?php

class thx_culture_Culture extends thx_culture_Info {
	public $language;
	public $date;
	public $englishCurrency;
	public $nativeCurrency;
	public $currencySymbol;
	public $currencyIso;
	public $englishRegion;
	public $nativeRegion;
	public $isMetric;
	public $digits;
	public $signNeg;
	public $signPos;
	public $symbolNaN;
	public $symbolPercent;
	public $symbolPermille;
	public $symbolNegInf;
	public $symbolPosInf;
	public $number;
	public $currency;
	public $percent;
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
	static $cultures;
	static function get_cultures() {
		if(null === thx_culture_Culture::$cultures) {
			thx_culture_Culture::$cultures = new haxe_ds_StringMap();
		}
		return thx_culture_Culture::$cultures;
	}
	static function get($name) {
		$this1 = thx_culture_Culture::get_cultures();
		$key = strtolower($name);
		return $this1->get($key);
	}
	static function names() {
		$this1 = thx_culture_Culture::get_cultures();
		return $this1->keys();
	}
	static function exists($culture) {
		$this1 = thx_culture_Culture::get_cultures();
		$key = strtolower($culture);
		return $this1->exists($key);
	}
	static $_defaultCulture;
	static function get_defaultCulture() {
		if(null === thx_culture_Culture::$_defaultCulture) {
			return thx_cultures_EnUS::get_culture();
		} else {
			return thx_culture_Culture::$_defaultCulture;
		}
	}
	static function set_defaultCulture($culture) {
		return thx_culture_Culture::$_defaultCulture = $culture;
	}
	static function add($culture) {
		if(null === thx_culture_Culture::$_defaultCulture) {
			thx_culture_Culture::$_defaultCulture = $culture;
		}
		$name = strtolower($culture->name);
		if(!thx_culture_Culture_0($culture, $name)) {
			$this2 = thx_culture_Culture::get_cultures();
			$this2->set($name, $culture);
		}
	}
	static function loadAll() {
		$dir = _hx_string_or_null(Sys::getCwd()) . "lib/thx/cultures/";
		{
			$_g = 0;
			$_g1 = sys_FileSystem::readDirectory($dir);
			while($_g < $_g1->length) {
				$file = $_g1[$_g];
				++$_g;
				require_once(_hx_string_or_null($dir) . _hx_string_or_null($file));
				unset($file);
			}
		}
	}
	static $__properties__ = array("set_defaultCulture" => "set_defaultCulture","get_defaultCulture" => "get_defaultCulture","get_cultures" => "get_cultures");
	function __toString() { return 'thx.culture.Culture'; }
}
function thx_culture_Culture_0(&$culture, &$name) {
	{
		$this1 = thx_culture_Culture::get_cultures();
		return $this1->exists($name);
	}
}
