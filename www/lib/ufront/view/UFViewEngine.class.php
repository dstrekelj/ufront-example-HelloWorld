<?php

class ufront_view_UFViewEngine {
	public function __construct($cachingEnabled = null) {
		if(!php_Boot::$skip_constructor) {
		if($cachingEnabled === null) {
			$cachingEnabled = true;
		}
		if($cachingEnabled) {
			$this->cache = new haxe_ds_StringMap();
		}
		$this->engines = (new _hx_array(array()));
	}}
	public $engines;
	public $cache;
	public function getTemplate($path, $templatingEngine = null) {
		$_g = $this;
		if($this->cache !== null && $this->cache->exists($path)) {
			$cached = $this->cache->get($path);
			if($templatingEngine === null || $templatingEngine->type === $cached->a) {
				return tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Success($cached->b));
			}
		}
		$tplStrReady = new tink_core_FutureTrigger();
		$ext = haxe_io_Path::extension($path);
		$finalPath = null;
		if($templatingEngine !== null && $ext !== "") {
			$finalPath = $path;
			{
				$this1 = $this->getTemplateString($finalPath);
				call_user_func_array($this1, array(array(new _hx_lambda(array(&$_g, &$ext, &$finalPath, &$path, &$templatingEngine, &$this1, &$tplStrReady), "ufront_view_UFViewEngine_0"), 'execute')));
			}
		} else {
			if($templatingEngine !== null && $ext === "") {
				$exts = $templatingEngine->extensions->copy();
				$testNextExtension = null;
				{
					$testNextExtension1 = null;
					$testNextExtension1 = array(new _hx_lambda(array(&$_g, &$ext, &$exts, &$finalPath, &$path, &$templatingEngine, &$testNextExtension, &$testNextExtension1, &$tplStrReady), "ufront_view_UFViewEngine_1"), 'execute');
					$testNextExtension = $testNextExtension1;
				}
				call_user_func($testNextExtension);
			} else {
				if($templatingEngine === null && $ext !== "") {
					$tplEngines = $this->engines->copy();
					$testNextEngine = null;
					{
						$testNextEngine1 = null;
						$testNextEngine1 = array(new _hx_lambda(array(&$_g, &$ext, &$finalPath, &$path, &$templatingEngine, &$testNextEngine, &$testNextEngine1, &$tplEngines, &$tplStrReady), "ufront_view_UFViewEngine_2"), 'execute');
						$testNextEngine = $testNextEngine1;
					}
					call_user_func($testNextEngine);
				} else {
					if($templatingEngine === null && $ext === "") {
						$tplEngines1 = $this->engines->copy();
						$engine1 = null;
						$extensions = (new _hx_array(array()));
						$extensionsUsed = (new _hx_array(array()));
						$ext2 = null;
						$testNextEngineOrExtension = null;
						{
							$testNextEngineOrExtension1 = null;
							$testNextEngineOrExtension1 = array(new _hx_lambda(array(&$_g, &$engine1, &$ext, &$ext2, &$extensions, &$extensionsUsed, &$finalPath, &$path, &$templatingEngine, &$testNextEngineOrExtension, &$testNextEngineOrExtension1, &$tplEngines1, &$tplStrReady), "ufront_view_UFViewEngine_3"), 'execute');
							$testNextEngineOrExtension = $testNextEngineOrExtension1;
						}
						call_user_func($testNextEngineOrExtension);
					}
				}
			}
		}
		return tink_core__Future_Future_Impl_::_tryFailingMap($tplStrReady->future, array(new _hx_lambda(array(&$_g, &$ext, &$finalPath, &$path, &$templatingEngine, &$tplStrReady), "ufront_view_UFViewEngine_4"), 'execute'));
	}
	public function getTemplateString($path) {
		return tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Failure(new tink_core_TypedError(null, "Attempting to fetch template " . _hx_string_or_null($path) . " with UFViewEngine.  This is an abstract class, you must use one of the ViewEngine implementations.", _hx_anonymous(array("fileName" => "UFViewEngine.hx", "lineNumber" => 214, "className" => "ufront.view.UFViewEngine", "methodName" => "getTemplateString")))));
	}
	public function addTemplatingEngine($engine) {
		$this->engines->push($engine);
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
	function __toString() { return 'ufront.view.UFViewEngine'; }
}
function ufront_view_UFViewEngine_0(&$_g, &$ext, &$finalPath, &$path, &$templatingEngine, &$this1, &$tplStrReady, $result) {
	{
		switch($result->index) {
		case 1:{
			$err = $result->params[0];
			{
				$result1 = tink_core_Outcome::Failure($err);
				if($tplStrReady->{"list"} === null) {
					false;
				} else {
					$list = $tplStrReady->{"list"};
					$tplStrReady->{"list"} = null;
					$tplStrReady->result = $result1;
					tink_core__Callback_CallbackList_Impl_::invoke($list, $result1);
					tink_core__Callback_CallbackList_Impl_::clear($list);
					true;
				}
			}
		}break;
		case 0:{
			switch($result->params[0]->index) {
			case 0:{
				$tpl = $result->params[0]->params[0];
				{
					$result2 = tink_core_Outcome::Success($tpl);
					if($tplStrReady->{"list"} === null) {
						false;
					} else {
						$list1 = $tplStrReady->{"list"};
						$tplStrReady->{"list"} = null;
						$tplStrReady->result = $result2;
						tink_core__Callback_CallbackList_Impl_::invoke($list1, $result2);
						tink_core__Callback_CallbackList_Impl_::clear($list1);
						true;
					}
				}
			}break;
			case 1:{
				$result3 = tink_core_Outcome::Failure(new tink_core_TypedError(null, "Template " . _hx_string_or_null($path) . " not found", _hx_anonymous(array("fileName" => "UFViewEngine.hx", "lineNumber" => 103, "className" => "ufront.view.UFViewEngine", "methodName" => "getTemplate"))));
				if($tplStrReady->{"list"} === null) {
					false;
				} else {
					$list2 = $tplStrReady->{"list"};
					$tplStrReady->{"list"} = null;
					$tplStrReady->result = $result3;
					tink_core__Callback_CallbackList_Impl_::invoke($list2, $result3);
					tink_core__Callback_CallbackList_Impl_::clear($list2);
					true;
				}
			}break;
			}
		}break;
		}
	}
}
function ufront_view_UFViewEngine_1(&$_g, &$ext, &$exts, &$finalPath, &$path, &$templatingEngine, &$testNextExtension, &$testNextExtension1, &$tplStrReady) {
	{
		if($exts->length > 0) {
			$ext1 = $exts->shift();
			$finalPath = haxe_io_Path::withExtension($path, $ext1);
			{
				$this2 = $_g->getTemplateString($finalPath);
				call_user_func_array($this2, array(array(new _hx_lambda(array(&$_g, &$ext, &$ext1, &$exts, &$finalPath, &$path, &$templatingEngine, &$testNextExtension, &$testNextExtension1, &$this2, &$tplStrReady), "ufront_view_UFViewEngine_5"), 'execute')));
			}
		} else {
			$result7 = tink_core_Outcome::Failure(new tink_core_TypedError(null, "No template found for " . _hx_string_or_null($path) . " with extensions " . Std::string($templatingEngine->extensions), _hx_anonymous(array("fileName" => "UFViewEngine.hx", "lineNumber" => 119, "className" => "ufront.view.UFViewEngine", "methodName" => "getTemplate"))));
			if($tplStrReady->{"list"} === null) {
				false;
			} else {
				$list5 = $tplStrReady->{"list"};
				$tplStrReady->{"list"} = null;
				$tplStrReady->result = $result7;
				tink_core__Callback_CallbackList_Impl_::invoke($list5, $result7);
				tink_core__Callback_CallbackList_Impl_::clear($list5);
				true;
			}
		}
	}
}
function ufront_view_UFViewEngine_2(&$_g, &$ext, &$finalPath, &$path, &$templatingEngine, &$testNextEngine, &$testNextEngine1, &$tplEngines, &$tplStrReady) {
	{
		if($tplEngines->length > 0) {
			$engine = $tplEngines->shift();
			if(Lambda::has($engine->extensions, $ext)) {
				$finalPath = $path;
				{
					$this3 = $_g->getTemplateString($finalPath);
					call_user_func_array($this3, array(array(new _hx_lambda(array(&$_g, &$engine, &$ext, &$finalPath, &$path, &$templatingEngine, &$testNextEngine, &$testNextEngine1, &$this3, &$tplEngines, &$tplStrReady), "ufront_view_UFViewEngine_6"), 'execute')));
				}
			} else {
				call_user_func($testNextEngine1);
			}
		} else {
			$result12 = tink_core_Outcome::Failure(new tink_core_TypedError(null, "No templating engine found for " . _hx_string_or_null($path) . " (None support extension " . _hx_string_or_null($ext) . ")", _hx_anonymous(array("fileName" => "UFViewEngine.hx", "lineNumber" => 139, "className" => "ufront.view.UFViewEngine", "methodName" => "getTemplate"))));
			if($tplStrReady->{"list"} === null) {
				false;
			} else {
				$list9 = $tplStrReady->{"list"};
				$tplStrReady->{"list"} = null;
				$tplStrReady->result = $result12;
				tink_core__Callback_CallbackList_Impl_::invoke($list9, $result12);
				tink_core__Callback_CallbackList_Impl_::clear($list9);
				true;
			}
		}
	}
}
function ufront_view_UFViewEngine_3(&$_g, &$engine1, &$ext, &$ext2, &$extensions, &$extensionsUsed, &$finalPath, &$path, &$templatingEngine, &$testNextEngineOrExtension, &$testNextEngineOrExtension1, &$tplEngines1, &$tplStrReady) {
	{
		if($extensions->length === 0 && $tplEngines1->length === 0) {
			{
				$result13 = tink_core_Outcome::Failure(new tink_core_TypedError(null, "No template found for " . _hx_string_or_null($path) . " with extensions " . Std::string($extensionsUsed), _hx_anonymous(array("fileName" => "UFViewEngine.hx", "lineNumber" => 153, "className" => "ufront.view.UFViewEngine", "methodName" => "getTemplate"))));
				if($tplStrReady->{"list"} === null) {
					false;
				} else {
					$list10 = $tplStrReady->{"list"};
					$tplStrReady->{"list"} = null;
					$tplStrReady->result = $result13;
					tink_core__Callback_CallbackList_Impl_::invoke($list10, $result13);
					tink_core__Callback_CallbackList_Impl_::clear($list10);
					true;
				}
			}
			return;
		} else {
			if($extensions->length === 0) {
				$engine1 = $tplEngines1->shift();
				$extensions = $engine1->extensions->copy();
				$ext2 = $extensions->shift();
			} else {
				$ext2 = $extensions->shift();
			}
		}
		$extensionsUsed->push($ext2);
		$finalPath = haxe_io_Path::withExtension($path, $ext2);
		{
			$this4 = $_g->getTemplateString($finalPath);
			call_user_func_array($this4, array(array(new _hx_lambda(array(&$_g, &$engine1, &$ext, &$ext2, &$extensions, &$extensionsUsed, &$finalPath, &$path, &$templatingEngine, &$testNextEngineOrExtension, &$testNextEngineOrExtension1, &$this4, &$tplEngines1, &$tplStrReady), "ufront_view_UFViewEngine_7"), 'execute')));
		}
		return;
	}
}
function ufront_view_UFViewEngine_4(&$_g, &$ext, &$finalPath, &$path, &$templatingEngine, &$tplStrReady, $tplStr) {
	{
		try {
			$tpl4 = $templatingEngine->factory($tplStr);
			{
				$v = new tink_core__Pair_Data($templatingEngine->type, $tpl4);
				$_g->cache->set($path, $v);
				$v;
			}
			return tink_core_Outcome::Success($tpl4);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				return tink_core_Outcome::Failure(tink_core_TypedError::withData(null, "Failed to pass template " . _hx_string_or_null($finalPath) . " using " . _hx_string_or_null($templatingEngine->type), $e, _hx_anonymous(array("fileName" => "UFViewEngine.hx", "lineNumber" => 192, "className" => "ufront.view.UFViewEngine", "methodName" => "getTemplate"))));
			}
		}
	}
}
function ufront_view_UFViewEngine_5(&$_g, &$ext, &$ext1, &$exts, &$finalPath, &$path, &$templatingEngine, &$testNextExtension, &$testNextExtension1, &$this2, &$tplStrReady, $result4) {
	{
		switch($result4->index) {
		case 1:{
			$err1 = $result4->params[0];
			{
				$result5 = tink_core_Outcome::Failure($err1);
				if($tplStrReady->{"list"} === null) {
					false;
				} else {
					$list3 = $tplStrReady->{"list"};
					$tplStrReady->{"list"} = null;
					$tplStrReady->result = $result5;
					tink_core__Callback_CallbackList_Impl_::invoke($list3, $result5);
					tink_core__Callback_CallbackList_Impl_::clear($list3);
					true;
				}
			}
		}break;
		case 0:{
			switch($result4->params[0]->index) {
			case 0:{
				$tpl1 = $result4->params[0]->params[0];
				{
					$result6 = tink_core_Outcome::Success($tpl1);
					if($tplStrReady->{"list"} === null) {
						false;
					} else {
						$list4 = $tplStrReady->{"list"};
						$tplStrReady->{"list"} = null;
						$tplStrReady->result = $result6;
						tink_core__Callback_CallbackList_Impl_::invoke($list4, $result6);
						tink_core__Callback_CallbackList_Impl_::clear($list4);
						true;
					}
				}
			}break;
			case 1:{
				call_user_func($testNextExtension1);
			}break;
			}
		}break;
		}
	}
}
function ufront_view_UFViewEngine_6(&$_g, &$engine, &$ext, &$finalPath, &$path, &$templatingEngine, &$testNextEngine, &$testNextEngine1, &$this3, &$tplEngines, &$tplStrReady, $result8) {
	{
		switch($result8->index) {
		case 1:{
			$err2 = $result8->params[0];
			{
				$result9 = tink_core_Outcome::Failure($err2);
				if($tplStrReady->{"list"} === null) {
					false;
				} else {
					$list6 = $tplStrReady->{"list"};
					$tplStrReady->{"list"} = null;
					$tplStrReady->result = $result9;
					tink_core__Callback_CallbackList_Impl_::invoke($list6, $result9);
					tink_core__Callback_CallbackList_Impl_::clear($list6);
					true;
				}
			}
		}break;
		case 0:{
			switch($result8->params[0]->index) {
			case 0:{
				$tpl2 = $result8->params[0]->params[0];
				{
					$templatingEngine = $engine;
					{
						$result10 = tink_core_Outcome::Success($tpl2);
						if($tplStrReady->{"list"} === null) {
							false;
						} else {
							$list7 = $tplStrReady->{"list"};
							$tplStrReady->{"list"} = null;
							$tplStrReady->result = $result10;
							tink_core__Callback_CallbackList_Impl_::invoke($list7, $result10);
							tink_core__Callback_CallbackList_Impl_::clear($list7);
							true;
						}
					}
				}
			}break;
			case 1:{
				$result11 = tink_core_Outcome::Failure(new tink_core_TypedError(null, "Template " . _hx_string_or_null($path) . " not found", _hx_anonymous(array("fileName" => "UFViewEngine.hx", "lineNumber" => 135, "className" => "ufront.view.UFViewEngine", "methodName" => "getTemplate"))));
				if($tplStrReady->{"list"} === null) {
					false;
				} else {
					$list8 = $tplStrReady->{"list"};
					$tplStrReady->{"list"} = null;
					$tplStrReady->result = $result11;
					tink_core__Callback_CallbackList_Impl_::invoke($list8, $result11);
					tink_core__Callback_CallbackList_Impl_::clear($list8);
					true;
				}
			}break;
			}
		}break;
		}
	}
}
function ufront_view_UFViewEngine_7(&$_g, &$engine1, &$ext, &$ext2, &$extensions, &$extensionsUsed, &$finalPath, &$path, &$templatingEngine, &$testNextEngineOrExtension, &$testNextEngineOrExtension1, &$this4, &$tplEngines1, &$tplStrReady, $result14) {
	{
		switch($result14->index) {
		case 1:{
			$err3 = $result14->params[0];
			{
				$result15 = tink_core_Outcome::Failure($err3);
				if($tplStrReady->{"list"} === null) {
					false;
				} else {
					$list11 = $tplStrReady->{"list"};
					$tplStrReady->{"list"} = null;
					$tplStrReady->result = $result15;
					tink_core__Callback_CallbackList_Impl_::invoke($list11, $result15);
					tink_core__Callback_CallbackList_Impl_::clear($list11);
					true;
				}
			}
		}break;
		case 0:{
			switch($result14->params[0]->index) {
			case 0:{
				$tpl3 = $result14->params[0]->params[0];
				{
					$templatingEngine = $engine1;
					{
						$result16 = tink_core_Outcome::Success($tpl3);
						if($tplStrReady->{"list"} === null) {
							false;
						} else {
							$list12 = $tplStrReady->{"list"};
							$tplStrReady->{"list"} = null;
							$tplStrReady->result = $result16;
							tink_core__Callback_CallbackList_Impl_::invoke($list12, $result16);
							tink_core__Callback_CallbackList_Impl_::clear($list12);
							true;
						}
					}
				}
			}break;
			case 1:{
				call_user_func($testNextEngineOrExtension1);
			}break;
			}
		}break;
		}
	}
}
