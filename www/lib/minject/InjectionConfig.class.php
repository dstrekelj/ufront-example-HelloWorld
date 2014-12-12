<?php

class minject_InjectionConfig {
	public function __construct($request, $injectionName) {
		if(!php_Boot::$skip_constructor) {
		$this->request = $request;
		$this->injectionName = $injectionName;
	}}
	public $request;
	public $injectionName;
	public $injector;
	public $result;
	public function getResponse($injector) {
		if($this->injector !== null) {
			$injector = $this->injector;
		}
		if($this->result !== null) {
			return $this->result->getResponse($injector);
		}
		$parentConfig = $injector->getAncestorMapping($this->request, $this->injectionName);
		if($parentConfig !== null) {
			return $parentConfig->getResponse($injector);
		}
		return null;
	}
	public function hasResponse($injector) {
		return $this->result !== null;
	}
	public function hasOwnResponse() {
		return $this->result !== null;
	}
	public function setResult($result) {
		if($this->result !== null && $result !== null) {
			haxe_Log::trace("Warning: Injector contains " . Std::string($this) . "." . "\x0AAttempting to overwrite this with mapping for [" . Std::string($result) . "]." . "\x0AIf you have overwritten this mapping intentionally " . "you can use \"injector.unmap()\" prior to your replacement " . "mapping in order to avoid seeing this message.", _hx_anonymous(array("fileName" => "InjectionConfig.hx", "lineNumber" => 74, "className" => "minject.InjectionConfig", "methodName" => "setResult")));
		}
		$this->result = $result;
	}
	public function setInjector($injector) {
		$this->injector = $injector;
	}
	public function toString() {
		$named = null;
		if($this->injectionName !== null && $this->injectionName !== "") {
			$named = " named \"" . _hx_string_or_null($this->injectionName) . "\" and";
		} else {
			$named = "";
		}
		return "rule: [" . _hx_string_or_null(Type::getClassName($this->request)) . "]" . _hx_string_or_null($named) . " mapped to [" . Std::string($this->result) . "]";
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
