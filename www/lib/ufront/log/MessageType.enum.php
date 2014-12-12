<?php

class ufront_log_MessageType extends Enum {
	public static $Error;
	public static $Log;
	public static $Trace;
	public static $Warning;
	public static $__constructors = array(3 => 'Error', 1 => 'Log', 0 => 'Trace', 2 => 'Warning');
	}
ufront_log_MessageType::$Error = new ufront_log_MessageType("Error", 3);
ufront_log_MessageType::$Log = new ufront_log_MessageType("Log", 1);
ufront_log_MessageType::$Trace = new ufront_log_MessageType("Trace", 0);
ufront_log_MessageType::$Warning = new ufront_log_MessageType("Warning", 2);
