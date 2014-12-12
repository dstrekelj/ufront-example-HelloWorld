<?php

class tink_core__Outcome_OutcomeMapper_Impl_ {
	public function __construct(){}
	static function _new($f) {
		return _hx_anonymous(array("f" => $f));
	}
	static function apply($this1, $o) {
		return $this1->f($o);
	}
	static function withSameError($f) {
		return tink_core__Outcome_OutcomeMapper_Impl_::_new(array(new _hx_lambda(array(&$f), "tink_core__Outcome_OutcomeMapper_Impl__0"), 'execute'));
	}
	static function withEitherError($f) {
		return tink_core__Outcome_OutcomeMapper_Impl_::_new(array(new _hx_lambda(array(&$f), "tink_core__Outcome_OutcomeMapper_Impl__1"), 'execute'));
	}
	function __toString() { return 'tink.core._Outcome.OutcomeMapper_Impl_'; }
}
function tink_core__Outcome_OutcomeMapper_Impl__0(&$f, $o) {
	{
		switch($o->index) {
		case 0:{
			$d = $o->params[0];
			return call_user_func_array($f, array($d));
		}break;
		case 1:{
			$f1 = $o->params[0];
			return tink_core_Outcome::Failure($f1);
		}break;
		}
	}
}
function tink_core__Outcome_OutcomeMapper_Impl__1(&$f, $o) {
	{
		switch($o->index) {
		case 0:{
			$d = $o->params[0];
			{
				$_g = call_user_func_array($f, array($d));
				switch($_g->index) {
				case 0:{
					$d1 = $_g->params[0];
					return tink_core_Outcome::Success($d1);
				}break;
				case 1:{
					$f1 = $_g->params[0];
					return tink_core_Outcome::Failure(tink_core_Either::Right($f1));
				}break;
				}
			}
		}break;
		case 1:{
			$f2 = $o->params[0];
			return tink_core_Outcome::Failure(tink_core_Either::Left($f2));
		}break;
		}
	}
}
