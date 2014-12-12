<?php

class thx_util_Message {
	public function __construct($message, $params = null, $param = null) {
		if(!php_Boot::$skip_constructor) {
		$this->message = $message;
		if(null === $params) {
			$this->params = (new _hx_array(array()));
		} else {
			$this->params = $params;
		}
		if(null !== $param) {
			$this->params->push($param);
		}
	}}
	public $message;
	public $params;
	public function toString() {
		return Strings::format($this->message, $this->params, null, null);
	}
	public function translatef($translator) {
		return Strings::format(call_user_func_array($translator, array($this->message)), $this->params, null, null);
	}
	public function translate($translator, $domain = null) {
		if(null === $domain) {
			$domain = $translator->get_domain();
		}
		$culture = thx_culture_Culture::get($domain);
		if($this->params->length === 1 && Std::is($this->params[0], _hx_qtype("Int"))) {
			return Strings::format($translator->plural(null, $this->message, $this->params[0], $domain), $this->params, null, $culture);
		} else {
			return Strings::format($translator->singular($this->message, $domain), $this->params, null, $culture);
		}
	}
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
	function __toString() { return $this->toString(); }
}
