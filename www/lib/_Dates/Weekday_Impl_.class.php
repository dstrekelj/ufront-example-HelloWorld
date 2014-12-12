<?php

class _Dates_Weekday_Impl_ {
	public function __construct(){}
	static $Sunday;
	static $Monday;
	static $Tuesday;
	static $Wednesday;
	static $Thursday;
	static $Friday;
	static $Saturday;
	function __toString() { return '_Dates.Weekday_Impl_'; }
}
_Dates_Weekday_Impl_::$Sunday = 0;
_Dates_Weekday_Impl_::$Monday = 1;
_Dates_Weekday_Impl_::$Tuesday = 2;
_Dates_Weekday_Impl_::$Wednesday = 3;
_Dates_Weekday_Impl_::$Thursday = 4;
_Dates_Weekday_Impl_::$Friday = 5;
_Dates_Weekday_Impl_::$Saturday = 6;
