<?php

class TimePeriod extends Enum {
	public static $Day;
	public static $Hour;
	public static $Minute;
	public static $Month;
	public static $Second;
	public static $Week;
	public static $Year;
	public static $__constructors = array(3 => 'Day', 2 => 'Hour', 1 => 'Minute', 5 => 'Month', 0 => 'Second', 4 => 'Week', 6 => 'Year');
	}
TimePeriod::$Day = new TimePeriod("Day", 3);
TimePeriod::$Hour = new TimePeriod("Hour", 2);
TimePeriod::$Minute = new TimePeriod("Minute", 1);
TimePeriod::$Month = new TimePeriod("Month", 5);
TimePeriod::$Second = new TimePeriod("Second", 0);
TimePeriod::$Week = new TimePeriod("Week", 4);
TimePeriod::$Year = new TimePeriod("Year", 6);
