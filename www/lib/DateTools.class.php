<?php

class DateTools {
	public function __construct(){}
	static $DAYS_OF_MONTH;
	static function getMonthDays($d) {
		$month = $d->getMonth();
		$year = $d->getFullYear();
		if($month !== 1) {
			return DateTools::$DAYS_OF_MONTH[$month];
		}
		$isB = _hx_mod($year, 4) === 0 && _hx_mod($year, 100) !== 0 || _hx_mod($year, 400) === 0;
		if($isB) {
			return 29;
		} else {
			return 28;
		}
	}
	function __toString() { return 'DateTools'; }
}
DateTools::$DAYS_OF_MONTH = (new _hx_array(array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31)));
