<?php

class haxe_ds_GenericCell {
	public function __construct($elt, $next) {
		if(!php_Boot::$skip_constructor) {
		$this->elt = $elt;
		$this->next = $next;
	}}
	public $elt;
	public $next;
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->__dynamics[$m]) && is_callable($this->__dynamics[$m]))
			return call_user_func_array($this->__dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call <'.$m.'>');
	}
	function __toString() { return 'haxe.ds.GenericCell'; }
}
