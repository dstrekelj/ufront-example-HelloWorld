<?php

class minject_result_InjectionResult {
	public function __construct() { 
	}
	public function getResponse($injector) {
		return null;
	}
	public function toString() {
		return "";
	}
	function __toString() { return $this->toString(); }
}
