<?php

class haxe_ds_Option extends Enum {
	public static $None;
	public static function Some($v) { return new haxe_ds_Option("Some", 0, array($v)); }
	public static $__constructors = array(1 => 'None', 0 => 'Some');
	}
haxe_ds_Option::$None = new haxe_ds_Option("None", 1);
