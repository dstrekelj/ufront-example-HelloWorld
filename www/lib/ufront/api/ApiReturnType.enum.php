<?php

class ufront_api_ApiReturnType extends Enum {
	public static $ARTFuture;
	public static $ARTOutcome;
	public static $ARTVoid;
	public static $__constructors = array(0 => 'ARTFuture', 1 => 'ARTOutcome', 2 => 'ARTVoid');
	}
ufront_api_ApiReturnType::$ARTFuture = new ufront_api_ApiReturnType("ARTFuture", 0);
ufront_api_ApiReturnType::$ARTOutcome = new ufront_api_ApiReturnType("ARTOutcome", 1);
ufront_api_ApiReturnType::$ARTVoid = new ufront_api_ApiReturnType("ARTVoid", 2);
