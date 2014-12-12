<?php

class ufront_web_WrapRequired extends Enum {
	public static $WRFuture;
	public static $WROutcome;
	public static $WRResultOrError;
	public static $__constructors = array(0 => 'WRFuture', 1 => 'WROutcome', 2 => 'WRResultOrError');
	}
ufront_web_WrapRequired::$WRFuture = new ufront_web_WrapRequired("WRFuture", 0);
ufront_web_WrapRequired::$WROutcome = new ufront_web_WrapRequired("WROutcome", 1);
ufront_web_WrapRequired::$WRResultOrError = new ufront_web_WrapRequired("WRResultOrError", 2);
