<?php

class thx_culture_Language extends thx_culture_Info {
	static $languages;
	static function get_languages() {
		if(null === thx_culture_Language::$languages) {
			thx_culture_Language::$languages = new haxe_ds_StringMap();
		}
		return thx_culture_Language::$languages;
	}
	static function get($name) {
		$this1 = thx_culture_Language::get_languages();
		$key = strtolower($name);
		return $this1->get($key);
	}
	static function names() {
		$this1 = thx_culture_Language::get_languages();
		return $this1->keys();
	}
	static function add($language) {
		if(!thx_culture_Language_0($language)) {
			$this2 = thx_culture_Language::get_languages();
			$this2->set($language->iso2, $language);
		}
	}
	static $__properties__ = array("get_languages" => "get_languages");
	function __toString() { return 'thx.culture.Language'; }
}
function thx_culture_Language_0(&$language) {
	{
		$this1 = thx_culture_Language::get_languages();
		return $this1->exists($language->iso2);
	}
}
