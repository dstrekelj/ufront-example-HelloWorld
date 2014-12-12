<?php

class Dates {
	public function __construct(){}
	static function format($d, $param = null, $params = null, $culture = null) {
		return call_user_func_array(Dates::formatf($param, $params, $culture), array($d));
	}
	static function formatf($param = null, $params = null, $culture = null) {
		$params = thx_culture_FormatParams::params($param, $params, "D");
		$format = $params->shift();
		switch($format) {
		case "D":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_0"), 'execute');
		}break;
		case "DS":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_1"), 'execute');
		}break;
		case "DST":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_2"), 'execute');
		}break;
		case "DSTS":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_3"), 'execute');
		}break;
		case "DTS":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_4"), 'execute');
		}break;
		case "Y":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_5"), 'execute');
		}break;
		case "YM":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_6"), 'execute');
		}break;
		case "M":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_7"), 'execute');
		}break;
		case "MN":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_8"), 'execute');
		}break;
		case "MS":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_9"), 'execute');
		}break;
		case "MD":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_10"), 'execute');
		}break;
		case "MDS":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_11"), 'execute');
		}break;
		case "WD":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_12"), 'execute');
		}break;
		case "WDN":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_13"), 'execute');
		}break;
		case "WDS":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_14"), 'execute');
		}break;
		case "R":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_15"), 'execute');
		}break;
		case "DT":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_16"), 'execute');
		}break;
		case "U":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_17"), 'execute');
		}break;
		case "S":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_18"), 'execute');
		}break;
		case "T":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_19"), 'execute');
		}break;
		case "TS":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_20"), 'execute');
		}break;
		case "C":{
			$f = $params[0];
			if(null === $f) {
				return array(new _hx_lambda(array(&$culture, &$f, &$format, &$param, &$params), "Dates_21"), 'execute');
			} else {
				return array(new _hx_lambda(array(&$culture, &$f, &$format, &$param, &$params), "Dates_22"), 'execute');
			}
		}break;
		default:{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Dates_23"), 'execute');
		}break;
		}
	}
	static function interpolate($f, $a, $b, $equation = null) {
		return call_user_func_array(Dates::interpolatef($a, $b, $equation), array($f));
	}
	static function interpolatef($a, $b, $equation = null) {
		$f = Floats::interpolatef($a->getTime(), $b->getTime(), $equation);
		return array(new _hx_lambda(array(&$a, &$b, &$equation, &$f), "Dates_24"), 'execute');
	}
	static function snap($time, $period, $mode = null) {
		$mode1 = null;
		if($mode !== null) {
			$mode1 = $mode;
		} else {
			$mode1 = SnapMode::$Round;
		}
		switch($mode1->index) {
		case 1:{
			switch($period->index) {
			case 0:{
				return Math::floor($time / 1000.0) * 1000.0;
			}break;
			case 1:{
				return Math::floor($time / 60000.0) * 60000.0;
			}break;
			case 2:{
				return Math::floor($time / 3600000.0) * 3600000.0;
			}break;
			case 3:{
				$d = Date::fromTime($time);
				return _hx_deref(new Date($d->getFullYear(), $d->getMonth(), $d->getDate(), 0, 0, 0))->getTime();
			}break;
			case 4:{
				return Math::floor($time / 604800000.) * 604800000.;
			}break;
			case 5:{
				$d1 = Date::fromTime($time);
				return _hx_deref(new Date($d1->getFullYear(), $d1->getMonth(), 1, 0, 0, 0))->getTime();
			}break;
			case 6:{
				$d2 = Date::fromTime($time);
				return _hx_deref(new Date($d2->getFullYear(), 0, 1, 0, 0, 0))->getTime();
			}break;
			}
		}break;
		case 0:{
			switch($period->index) {
			case 0:{
				return Math::ceil($time / 1000.0) * 1000.0;
			}break;
			case 1:{
				return Math::ceil($time / 60000.0) * 60000.0;
			}break;
			case 2:{
				return Math::ceil($time / 3600000.0) * 3600000.0;
			}break;
			case 3:{
				$d3 = Date::fromTime($time);
				return _hx_deref(new Date($d3->getFullYear(), $d3->getMonth(), $d3->getDate() + 1, 0, 0, 0))->getTime();
			}break;
			case 4:{
				return Math::ceil($time / 604800000.) * 604800000.;
			}break;
			case 5:{
				$d4 = Date::fromTime($time);
				return _hx_deref(new Date($d4->getFullYear(), $d4->getMonth() + 1, 1, 0, 0, 0))->getTime();
			}break;
			case 6:{
				$d5 = Date::fromTime($time);
				return _hx_deref(new Date($d5->getFullYear() + 1, 0, 1, 0, 0, 0))->getTime();
			}break;
			}
		}break;
		case 2:{
			switch($period->index) {
			case 0:{
				return Math::round($time / 1000.0) * 1000.0;
			}break;
			case 1:{
				return Math::round($time / 60000.0) * 60000.0;
			}break;
			case 2:{
				return Math::round($time / 3600000.0) * 3600000.0;
			}break;
			case 3:{
				$d6 = Date::fromTime($time);
				$mod = null;
				if($d6->getHours() >= 12) {
					$mod = 1;
				} else {
					$mod = 0;
				}
				return _hx_deref(new Date($d6->getFullYear(), $d6->getMonth(), $d6->getDate() + $mod, 0, 0, 0))->getTime();
			}break;
			case 4:{
				return Math::round($time / 604800000.) * 604800000.;
			}break;
			case 5:{
				$d7 = Date::fromTime($time);
				$mod1 = null;
				if($d7->getDate() > Math::round(DateTools::getMonthDays($d7) / 2)) {
					$mod1 = 1;
				} else {
					$mod1 = 0;
				}
				return _hx_deref(new Date($d7->getFullYear(), $d7->getMonth() + $mod1, 1, 0, 0, 0))->getTime();
			}break;
			case 6:{
				$d8 = Date::fromTime($time);
				$mod2 = null;
				if($time > _hx_deref(new Date($d8->getFullYear(), 6, 2, 0, 0, 0))->getTime()) {
					$mod2 = 1;
				} else {
					$mod2 = 0;
				}
				return _hx_deref(new Date($d8->getFullYear() + $mod2, 0, 1, 0, 0, 0))->getTime();
			}break;
			}
		}break;
		}
	}
	static function snapToWeekDay($time, $day, $snapMode = null, $firstDayOfWk = null) {
		$snapMode1 = null;
		if($snapMode !== null) {
			$snapMode1 = $snapMode;
		} else {
			$snapMode1 = SnapMode::$Round;
		}
		if($firstDayOfWk === null) {
			$firstDayOfWk = 0;
		}
		$d = Date::fromTime($time)->getDay();
		$s = $day;
		if($s === -1) {
			throw new HException(new thx_error_Error("unknown week day '{0}'", null, $day, _hx_anonymous(array("fileName" => "Dates.hx", "lineNumber" => 251, "className" => "Dates", "methodName" => "snapToWeekDay"))));
		}
		switch($snapMode1->index) {
		case 1:{
			if($s > $d) {
				$s = $s - 7;
			}
			return $time - ($d - $s) * 24 * 60 * 60 * 1000;
		}break;
		case 0:{
			if($s < $d) {
				$s = $s + 7;
			}
			return $time + ($s - $d) * 24 * 60 * 60 * 1000;
		}break;
		case 2:{
			if($s < $firstDayOfWk) {
				$s = $s + 7;
			}
			if($d < $firstDayOfWk) {
				$d = $d + 7;
			}
			return $time + ($s - $d) * 24 * 60 * 60 * 1000;
		}break;
		}
	}
	static function isLeapYear($year) {
		if(_hx_mod($year, 4) !== 0) {
			return false;
		}
		if(_hx_mod($year, 100) === 0) {
			return _hx_mod($year, 400) === 0;
		}
		return true;
	}
	static function isInLeapYear($d) {
		return Dates::isLeapYear($d->getFullYear());
	}
	static function numDaysInMonth($month, $year) {
		switch($month) {
		case 0:case 2:case 4:case 6:case 7:case 9:case 11:{
			return 31;
		}break;
		case 3:case 5:case 8:case 10:{
			return 30;
		}break;
		case 1:{
			if(Dates::isLeapYear($year)) {
				return 29;
			} else {
				return 28;
			}
		}break;
		default:{
			throw new HException(new thx_error_Error("Invalid month '{0}'.  Month should be a number, Jan=0, Dec=11", null, $month, _hx_anonymous(array("fileName" => "Dates.hx", "lineNumber" => 316, "className" => "Dates", "methodName" => "numDaysInMonth"))));
			return 0;
		}break;
		}
	}
	static function numDaysInThisMonth($d) {
		return Dates::numDaysInMonth($d->getMonth(), $d->getFullYear());
	}
	static function dateBasedDelta($d, $yearDelta = null, $monthDelta = null, $dayDelta = null, $hourDelta = null, $minDelta = null, $secDelta = null, $msDelta = null) {
		if($msDelta === null) {
			$msDelta = 0;
		}
		if($secDelta === null) {
			$secDelta = 0;
		}
		if($minDelta === null) {
			$minDelta = 0;
		}
		if($hourDelta === null) {
			$hourDelta = 0;
		}
		if($dayDelta === null) {
			$dayDelta = 0;
		}
		if($monthDelta === null) {
			$monthDelta = 0;
		}
		if($yearDelta === null) {
			$yearDelta = 0;
		}
		$year = $d->getFullYear() + $yearDelta;
		$month = $d->getMonth() + $monthDelta;
		$day = $d->getDate() + $dayDelta;
		$hour = $d->getHours() + $hourDelta;
		$min = $d->getMinutes() + $minDelta;
		$sec = $d->getSeconds() + $secDelta;
		while($sec > 60) {
			$sec -= 60;
			$min++;
		}
		while($min > 60) {
			$min -= 60;
			$hour++;
		}
		while($hour > 23) {
			$hour -= 24;
			$day++;
		}
		while($hour > 23) {
			$hour -= 24;
			$day++;
		}
		$daysInMonth = Dates::numDaysInMonth($month, $year);
		while($day > $daysInMonth || $month > 11) {
			if($day > $daysInMonth) {
				$day -= $daysInMonth;
				$month++;
			}
			if($month > 11) {
				$month -= 12;
				$year++;
			}
			$daysInMonth = Dates::numDaysInMonth($month, $year);
		}
		$d1 = new Date($year, $month, $day, $hour, $min, $sec);
		return Date::fromTime($d1->getTime() + $msDelta);
	}
	static function deltaSec($d, $numSec) {
		return Date::fromTime($d->getTime() + $numSec * 1000);
	}
	static function deltaMin($d, $numMin) {
		return Date::fromTime($d->getTime() + $numMin * 60 * 1000);
	}
	static function deltaHour($d, $numHrs) {
		return Date::fromTime($d->getTime() + $numHrs * 60 * 60 * 1000);
	}
	static function deltaDay($d, $numDays) {
		return Dates::dateBasedDelta($d, 0, 0, $numDays, null, null, null, null);
	}
	static function deltaWeek($d, $numWks) {
		return Dates::dateBasedDelta($d, 0, 0, $numWks * 7, null, null, null, null);
	}
	static function deltaMonth($d, $numMonths) {
		return Dates::dateBasedDelta($d, 0, $numMonths, null, null, null, null, null);
	}
	static function deltaYear($d, $numYrs) {
		return Dates::dateBasedDelta($d, $numYrs, null, null, null, null, null, null);
	}
	static function prevYear($d) {
		return Dates::dateBasedDelta($d, -1, null, null, null, null, null, null);
	}
	static function nextYear($d) {
		return Dates::dateBasedDelta($d, 1, null, null, null, null, null, null);
	}
	static function prevMonth($d) {
		return Dates::dateBasedDelta($d, 0, -1, null, null, null, null, null);
	}
	static function nextMonth($d) {
		return Dates::dateBasedDelta($d, 0, 1, null, null, null, null, null);
	}
	static function prevWeek($d) {
		return Dates::dateBasedDelta($d, 0, 0, -7, null, null, null, null);
	}
	static function nextWeek($d) {
		return Dates::dateBasedDelta($d, 0, 0, 7, null, null, null, null);
	}
	static function prevDay($d) {
		return Dates::dateBasedDelta($d, 0, 0, -1, null, null, null, null);
	}
	static function nextDay($d) {
		return Dates::dateBasedDelta($d, 0, 0, 1, null, null, null, null);
	}
	static $_reparse;
	static function canParse($s) {
		return Dates::$_reparse->match($s);
	}
	static function parse($s) {
		$parts = _hx_explode(".", $s);
		$date = Date::fromString(Dates_25($parts, $s));
		if($parts->length > 1) {
			$date = Date::fromTime($date->getTime() + Std::parseInt($parts[1]));
		}
		return $date;
	}
	static function compare($a, $b) {
		$a1 = $a->getTime();
		$b1 = $b->getTime();
		if($a1 < $b1) {
			return -1;
		} else {
			if($a1 > $b1) {
				return 1;
			} else {
				return 0;
			}
		}
	}
	function __toString() { return 'Dates'; }
}
Dates::$_reparse = new EReg("^\\d{4}-\\d\\d-\\d\\d(( |T)\\d\\d:\\d\\d(:\\d\\d(\\.\\d{1,3})?)?)?Z?\$", "");
function Dates_0(&$culture, &$format, &$param, &$params, $d) {
	{
		return thx_culture_FormatDate::date($d, $culture);
	}
}
function Dates_1(&$culture, &$format, &$param, &$params, $d1) {
	{
		return thx_culture_FormatDate::dateShort($d1, $culture);
	}
}
function Dates_2(&$culture, &$format, &$param, &$params, $d2) {
	{
		return _hx_string_or_null(thx_culture_FormatDate::dateShort($d2, $culture)) . " " . _hx_string_or_null(thx_culture_FormatDate::time($d2, $culture));
	}
}
function Dates_3(&$culture, &$format, &$param, &$params, $d3) {
	{
		return _hx_string_or_null(thx_culture_FormatDate::dateShort($d3, $culture)) . " " . _hx_string_or_null(thx_culture_FormatDate::timeShort($d3, $culture));
	}
}
function Dates_4(&$culture, &$format, &$param, &$params, $d4) {
	{
		return _hx_string_or_null(thx_culture_FormatDate::date($d4, $culture)) . " " . _hx_string_or_null(thx_culture_FormatDate::timeShort($d4, $culture));
	}
}
function Dates_5(&$culture, &$format, &$param, &$params, $d5) {
	{
		return thx_culture_FormatDate::year($d5, $culture);
	}
}
function Dates_6(&$culture, &$format, &$param, &$params, $d6) {
	{
		return thx_culture_FormatDate::yearMonth($d6, $culture);
	}
}
function Dates_7(&$culture, &$format, &$param, &$params, $d7) {
	{
		return thx_culture_FormatDate::month($d7, $culture);
	}
}
function Dates_8(&$culture, &$format, &$param, &$params, $d8) {
	{
		return thx_culture_FormatDate::monthName($d8, $culture);
	}
}
function Dates_9(&$culture, &$format, &$param, &$params, $d9) {
	{
		return thx_culture_FormatDate::monthNameShort($d9, $culture);
	}
}
function Dates_10(&$culture, &$format, &$param, &$params, $d10) {
	{
		return thx_culture_FormatDate::monthDay($d10, $culture);
	}
}
function Dates_11(&$culture, &$format, &$param, &$params, $d11) {
	{
		return thx_culture_FormatDate::monthDayShort($d11, $culture);
	}
}
function Dates_12(&$culture, &$format, &$param, &$params, $d12) {
	{
		return thx_culture_FormatDate::weekDay($d12, $culture);
	}
}
function Dates_13(&$culture, &$format, &$param, &$params, $d13) {
	{
		return thx_culture_FormatDate::weekDayName($d13, $culture);
	}
}
function Dates_14(&$culture, &$format, &$param, &$params, $d14) {
	{
		return thx_culture_FormatDate::weekDayNameShort($d14, $culture);
	}
}
function Dates_15(&$culture, &$format, &$param, &$params, $d15) {
	{
		return thx_culture_FormatDate::dateRfc($d15, $culture);
	}
}
function Dates_16(&$culture, &$format, &$param, &$params, $d16) {
	{
		return thx_culture_FormatDate::dateTime($d16, $culture);
	}
}
function Dates_17(&$culture, &$format, &$param, &$params, $d17) {
	{
		return thx_culture_FormatDate::universal($d17, $culture);
	}
}
function Dates_18(&$culture, &$format, &$param, &$params, $d18) {
	{
		return thx_culture_FormatDate::sortable($d18, $culture);
	}
}
function Dates_19(&$culture, &$format, &$param, &$params, $d19) {
	{
		return thx_culture_FormatDate::time($d19, $culture);
	}
}
function Dates_20(&$culture, &$format, &$param, &$params, $d20) {
	{
		return thx_culture_FormatDate::timeShort($d20, $culture);
	}
}
function Dates_21(&$culture, &$f, &$format, &$param, &$params, $d21) {
	{
		return thx_culture_FormatDate::date($d21, $culture);
	}
}
function Dates_22(&$culture, &$f, &$format, &$param, &$params, $d22) {
	{
		return thx_culture_FormatDate::format($d22, $f, $culture, Dates_26($culture, $d22, $f, $format, $param, $params));
	}
}
function Dates_23(&$culture, &$format, &$param, &$params, $d23) {
	{
		return thx_culture_FormatDate::format($d23, $format, $culture, Dates_27($culture, $d23, $format, $param, $params));
	}
}
function Dates_24(&$a, &$b, &$equation, &$f, $v) {
	{
		return Date::fromTime(call_user_func_array($f, array($v)));
	}
}
function Dates_25(&$parts, &$s) {
	{
		$s1 = $parts[0];
		return str_replace("T", " ", $s1);
	}
}
function Dates_26(&$culture, &$d22, &$f, &$format, &$param, &$params) {
	if($params[1] !== null) {
		return $params[1] === "true";
	} else {
		return true;
	}
}
function Dates_27(&$culture, &$d23, &$format, &$param, &$params) {
	if($params[0] !== null) {
		return $params[0] === "true";
	} else {
		return true;
	}
}
