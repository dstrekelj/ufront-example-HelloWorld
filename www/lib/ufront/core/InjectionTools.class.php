<?php

class ufront_core_InjectionTools {
	public function __construct(){}
	static function inject($injector, $cl, $val = null, $cl2 = null, $singleton = null, $named = null) {
		if($singleton === null) {
			$singleton = false;
		}
		if($cl !== null) {
			$existingMapping = $injector->getMapping($cl, $named);
			if($existingMapping !== null) {
				$existingMapping->setResult(null);
			}
			if($val !== null) {
				$injector->mapValue($cl, $val, $named);
				$implementationClass = Type::getClass($val);
				if($implementationClass !== $cl) {
					$existingMapping1 = $injector->getMapping($implementationClass, $named);
					if($existingMapping1 !== null) {
						$existingMapping1->setResult(null);
					}
					$injector->mapValue($implementationClass, $val, $named);
				}
			} else {
				if($singleton && $cl2 !== null) {
					$injector->mapSingletonOf($cl, $cl2, $named);
				} else {
					if($singleton && $cl2 === null) {
						$injector->mapSingleton($cl, $named);
					} else {
						if($cl2 !== null) {
							$injector->mapClass($cl, $cl2, $named);
						} else {
							$injector->mapClass($cl, $cl, $named);
						}
					}
				}
			}
		}
		return $injector;
	}
	static function listMappings($injector, $arr = null, $prefix = null) {
		if($prefix === null) {
			$prefix = "";
		}
		if($arr === null) {
			$arr = (new _hx_array(array()));
		}
		if($injector->parentInjector !== null) {
			ufront_core_InjectionTools::listMappings($injector->parentInjector, $arr, "(parent)" . _hx_string_or_null($prefix));
		}
		if(null == $injector->injectionConfigs) throw new HException('null iterable');
		$__hx__it = $injector->injectionConfigs->iterator();
		while($__hx__it->hasNext()) {
			$c = $__hx__it->next();
			$arr->push(_hx_string_or_null($prefix) . _hx_string_or_null($c->toString()));
		}
		return $arr;
	}
	function __toString() { return 'ufront.core.InjectionTools'; }
}
