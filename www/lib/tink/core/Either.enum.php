<?php

class tink_core_Either extends Enum {
	public static function Left($a) { return new tink_core_Either("Left", 0, array($a)); }
	public static function Right($b) { return new tink_core_Either("Right", 1, array($b)); }
	public static $__constructors = array(0 => 'Left', 1 => 'Right');
	}
