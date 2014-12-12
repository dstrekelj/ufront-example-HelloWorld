<?php

class tink_core__Future_Future_Impl_ {
	public function __construct(){}
	static function _new($f) {
		return $f;
	}
	static function handle($this1, $callback) {
		return call_user_func_array($this1, array($callback));
	}
	static function gather($this1) {
		$op = new tink_core_FutureTrigger();
		$self = $this1;
		return tink_core__Future_Future_Impl_::_new(array(new _hx_lambda(array(&$op, &$self, &$this1), "tink_core__Future_Future_Impl__0"), 'execute'));
	}
	static function first($this1, $other) {
		return tink_core__Future_Future_Impl_::async(array(new _hx_lambda(array(&$other, &$this1), "tink_core__Future_Future_Impl__1"), 'execute'), null);
	}
	static function map($this1, $f, $gather = null) {
		if($gather === null) {
			$gather = true;
		}
		$ret = tink_core__Future_Future_Impl_::_new(array(new _hx_lambda(array(&$f, &$gather, &$this1), "tink_core__Future_Future_Impl__2"), 'execute'));
		if($gather) {
			return tink_core__Future_Future_Impl_::gather($ret);
		} else {
			return $ret;
		}
	}
	static function flatMap($this1, $next, $gather = null) {
		if($gather === null) {
			$gather = true;
		}
		$ret = tink_core__Future_Future_Impl_::flatten(tink_core__Future_Future_Impl_::map($this1, $next, $gather));
		if($gather) {
			return tink_core__Future_Future_Impl_::gather($ret);
		} else {
			return $ret;
		}
	}
	static function merge($this1, $other, $merger, $gather = null) {
		if($gather === null) {
			$gather = true;
		}
		return tink_core__Future_Future_Impl_::flatMap($this1, array(new _hx_lambda(array(&$gather, &$merger, &$other, &$this1), "tink_core__Future_Future_Impl__3"), 'execute'), $gather);
	}
	static function flatten($f) {
		return tink_core__Future_Future_Impl_::_new(array(new _hx_lambda(array(&$f), "tink_core__Future_Future_Impl__4"), 'execute'));
	}
	static function fromTrigger($trigger) {
		return $trigger->future;
	}
	static function ofMany($futures, $gather = null) {
		if($gather === null) {
			$gather = true;
		}
		$ret = tink_core__Future_Future_Impl_::sync((new _hx_array(array())));
		{
			$_g = 0;
			while($_g < $futures->length) {
				$f = $futures[$_g];
				++$_g;
				$ret = tink_core__Future_Future_Impl_::flatMap($ret, array(new _hx_lambda(array(&$_g, &$f, &$futures, &$gather, &$ret), "tink_core__Future_Future_Impl__5"), 'execute'), false);
				unset($f);
			}
		}
		if($gather) {
			return tink_core__Future_Future_Impl_::gather($ret);
		} else {
			return $ret;
		}
	}
	static function fromMany($futures) {
		return tink_core__Future_Future_Impl_::ofMany($futures, null);
	}
	static function lazy($l) {
		return tink_core__Future_Future_Impl_::_new(array(new _hx_lambda(array(&$l), "tink_core__Future_Future_Impl__6"), 'execute'));
	}
	static function sync($v) {
		return tink_core__Future_Future_Impl_::_new(array(new _hx_lambda(array(&$v), "tink_core__Future_Future_Impl__7"), 'execute'));
	}
	static function async($f, $lazy = null) {
		if($lazy === null) {
			$lazy = false;
		}
		if($lazy) {
			return tink_core__Future_Future_Impl_::flatten(tink_core__Future_Future_Impl_::lazy(tink_core__Lazy_Lazy_Impl_::ofFunc(tink_core__Future_Future_Impl__8($f, $lazy))));
		} else {
			$op = new tink_core_FutureTrigger();
			call_user_func_array($f, array((isset($op->trigger) ? $op->trigger: array($op, "trigger"))));
			return $op->future;
		}
	}
	static function hor($a, $b) {
		return tink_core__Future_Future_Impl_::first($a, $b);
	}
	static function either($a, $b) {
		return tink_core__Future_Future_Impl_::first(tink_core__Future_Future_Impl_::map($a, (isset(tink_core_Either::$Left) ? tink_core_Either::$Left: array("tink_core_Either", "Left")), false), tink_core__Future_Future_Impl_::map($b, (isset(tink_core_Either::$Right) ? tink_core_Either::$Right: array("tink_core_Either", "Right")), false));
	}
	static function hand($a, $b) {
		return tink_core__Future_Future_Impl_::merge($a, $b, array(new _hx_lambda(array(&$a, &$b), "tink_core__Future_Future_Impl__9"), 'execute'), null);
	}
	static function _tryFailingFlatMap($f, $map) {
		return tink_core__Future_Future_Impl_::flatMap($f, array(new _hx_lambda(array(&$f, &$map), "tink_core__Future_Future_Impl__10"), 'execute'), null);
	}
	static function _tryFlatMap($f, $map) {
		return tink_core__Future_Future_Impl_::flatMap($f, array(new _hx_lambda(array(&$f, &$map), "tink_core__Future_Future_Impl__11"), 'execute'), null);
	}
	static function _tryFailingMap($f, $map) {
		return tink_core__Future_Future_Impl_::map($f, array(new _hx_lambda(array(&$f, &$map), "tink_core__Future_Future_Impl__12"), 'execute'), null);
	}
	static function _tryMap($f, $map) {
		return tink_core__Future_Future_Impl_::map($f, array(new _hx_lambda(array(&$f, &$map), "tink_core__Future_Future_Impl__13"), 'execute'), null);
	}
	static function _flatMap($f, $map) {
		return tink_core__Future_Future_Impl_::flatMap($f, $map, null);
	}
	static function _map($f, $map) {
		return tink_core__Future_Future_Impl_::map($f, $map, null);
	}
	static function trigger() {
		return new tink_core_FutureTrigger();
	}
	function __toString() { return 'tink.core._Future.Future_Impl_'; }
}
function tink_core__Future_Future_Impl__0(&$op, &$self, &$this1, $cb) {
	{
		if($self !== null) {
			call_user_func_array($this1, array((isset($op->trigger) ? $op->trigger: array($op, "trigger"))));
			$self = null;
		}
		return $op->future($cb);
	}
}
function tink_core__Future_Future_Impl__1(&$other, &$this1, $cb) {
	{
		call_user_func_array($this1, array($cb));
		call_user_func_array($other, array($cb));
	}
}
function tink_core__Future_Future_Impl__2(&$f, &$gather, &$this1, $callback) {
	{
		return call_user_func_array($this1, array(array(new _hx_lambda(array(&$callback, &$f, &$gather, &$this1), "tink_core__Future_Future_Impl__14"), 'execute')));
	}
}
function tink_core__Future_Future_Impl__3(&$gather, &$merger, &$other, &$this1, $t) {
	{
		return tink_core__Future_Future_Impl_::map($other, array(new _hx_lambda(array(&$gather, &$merger, &$other, &$t, &$this1), "tink_core__Future_Future_Impl__15"), 'execute'), false);
	}
}
function tink_core__Future_Future_Impl__4(&$f, $callback) {
	{
		$ret = null;
		$ret = call_user_func_array($f, array(array(new _hx_lambda(array(&$callback, &$f, &$ret), "tink_core__Future_Future_Impl__16"), 'execute')));
		return $ret;
	}
}
function tink_core__Future_Future_Impl__5(&$_g, &$f, &$futures, &$gather, &$ret, $results) {
	{
		return tink_core__Future_Future_Impl_::map($f, array(new _hx_lambda(array(&$_g, &$f, &$futures, &$gather, &$results, &$ret), "tink_core__Future_Future_Impl__17"), 'execute'), false);
	}
}
function tink_core__Future_Future_Impl__6(&$l, $cb) {
	{
		{
			$data = call_user_func($l);
			call_user_func_array($cb, array($data));
		}
		return null;
	}
}
function tink_core__Future_Future_Impl__7(&$v, $callback) {
	{
		call_user_func_array($callback, array($v));
		return null;
	}
}
function tink_core__Future_Future_Impl__8(&$f, &$lazy) {
	{
		$f1 = $f;
		return array(new _hx_lambda(array(&$f, &$f1, &$lazy), "tink_core__Future_Future_Impl__18"), 'execute');
	}
}
function tink_core__Future_Future_Impl__9(&$a, &$b, $a1, $b1) {
	{
		return new tink_core__Pair_Data($a1, $b1);
	}
}
function tink_core__Future_Future_Impl__10(&$f, &$map, $o) {
	{
		switch($o->index) {
		case 0:{
			$d = $o->params[0];
			return call_user_func_array($map, array($d));
		}break;
		case 1:{
			$f1 = $o->params[0];
			return tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Failure($f1));
		}break;
		}
	}
}
function tink_core__Future_Future_Impl__11(&$f, &$map, $o) {
	{
		switch($o->index) {
		case 0:{
			$d = $o->params[0];
			return tink_core__Future_Future_Impl_::map(call_user_func_array($map, array($d)), (isset(tink_core_Outcome::$Success) ? tink_core_Outcome::$Success: array("tink_core_Outcome", "Success")), null);
		}break;
		case 1:{
			$f1 = $o->params[0];
			return tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Failure($f1));
		}break;
		}
	}
}
function tink_core__Future_Future_Impl__12(&$f, &$map, $o) {
	{
		return tink_core_OutcomeTools::flatMap($o, tink_core__Outcome_OutcomeMapper_Impl_::withSameError($map));
	}
}
function tink_core__Future_Future_Impl__13(&$f, &$map, $o) {
	{
		switch($o->index) {
		case 0:{
			$a = $o->params[0];
			return tink_core_Outcome::Success(call_user_func_array($map, array($a)));
		}break;
		case 1:{
			$f1 = $o->params[0];
			return tink_core_Outcome::Failure($f1);
		}break;
		}
	}
}
function tink_core__Future_Future_Impl__14(&$callback, &$f, &$gather, &$this1, $result) {
	{
		$data = call_user_func_array($f, array($result));
		call_user_func_array($callback, array($data));
	}
}
function tink_core__Future_Future_Impl__15(&$gather, &$merger, &$other, &$t, &$this1, $a) {
	{
		return call_user_func_array($merger, array($t, $a));
	}
}
function tink_core__Future_Future_Impl__16(&$callback, &$f, &$ret, $next) {
	{
		$ret = call_user_func_array($next, array(array(new _hx_lambda(array(&$callback, &$f, &$next, &$ret), "tink_core__Future_Future_Impl__19"), 'execute')));
	}
}
function tink_core__Future_Future_Impl__17(&$_g, &$f, &$futures, &$gather, &$results, &$ret, $result) {
	{
		return $results->concat((new _hx_array(array($result))));
	}
}
function tink_core__Future_Future_Impl__18(&$f, &$f1, &$lazy) {
	{
		return tink_core__Future_Future_Impl_::async($f1, false);
	}
}
function tink_core__Future_Future_Impl__19(&$callback, &$f, &$next, &$ret, $result) {
	{
		call_user_func_array($callback, array($result));
	}
}
