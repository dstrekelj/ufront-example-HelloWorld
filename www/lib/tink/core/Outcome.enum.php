<?php

class tink_core_Outcome extends Enum {
	public static function Failure($failure) { return new tink_core_Outcome("Failure", 1, array($failure)); }
	public static function Success($data) { return new tink_core_Outcome("Success", 0, array($data)); }
	public static $__constructors = array(1 => 'Failure', 0 => 'Success');
	}
