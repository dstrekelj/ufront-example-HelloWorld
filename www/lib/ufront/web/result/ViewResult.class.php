<?php

class ufront_web_result_ViewResult extends ufront_web_result_ActionResult {
	public function __construct($data = null, $viewPath = null, $templatingEngine = null) {
		if(!php_Boot::$skip_constructor) {
		$this->viewPath = $viewPath;
		$this->templatingEngine = $templatingEngine;
		if($data !== null) {
			$this->data = $data;
		} else {
			$d = _hx_anonymous(array());
			$this->data = (($d !== null) ? $d : _hx_anonymous(array()));
		}
		{
			$d1 = _hx_anonymous(array());
			$this->helpers = (($d1 !== null) ? $d1 : _hx_anonymous(array()));
		}
		$this->layout = null;
	}}
	public $viewPath;
	public $templatingEngine;
	public $data;
	public $layout;
	public $helpers;
	public $templateFromString;
	public $layoutFromString;
	public function withLayout($layoutPath, $templatingEngine = null) {
		$this->layout = haxe_ds_Option::Some(new tink_core__Pair_Data($layoutPath, $templatingEngine));
		return $this;
	}
	public function withoutLayout() {
		$this->layout = haxe_ds_Option::$None;
		return $this;
	}
	public function usingTemplateString($template, $layout = null, $templatingEngine = null) {
		if($templatingEngine === null) {
			$templatingEngine = ufront_view_TemplatingEngines::get_haxe();
		}
		if($template !== null) {
			$this->templateFromString = $templatingEngine->factory($template);
		} else {
			$this->templateFromString = null;
		}
		if($layout !== null) {
			$this->layoutFromString = $templatingEngine->factory($layout);
		} else {
			$this->layoutFromString = null;
		}
		return $this;
	}
	public function setVar($key, $val) {
		ufront_view__TemplateData_TemplateData_Impl_::array_set($this->data, $key, $val);
		return $this;
	}
	public function setVars($map = null, $obj = null) {
		if($obj !== null) {
			ufront_view__TemplateData_TemplateData_Impl_::setObject($this->data, $obj);
		}
		if($map !== null) {
			ufront_view__TemplateData_TemplateData_Impl_::setMap($this->data, $map);
		}
		return $this;
	}
	public function executeResult($actionContext) {
		$_g1 = $this;
		$viewEngine = null;
		try {
			$viewEngine = $actionContext->httpContext->injector->getInstance(_hx_qtype("ufront.view.UFViewEngine"), null);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				$viewEngine = null;
			}
		}
		if($viewEngine === null) {
			return ufront_core_Sync::httpError("Failed to find a UFViewEngine in ViewResult.executeResult(), please make sure that one is made available in your application's injector", null, _hx_anonymous(array("fileName" => "ViewResult.hx", "lineNumber" => 316, "className" => "ufront.web.result.ViewResult", "methodName" => "executeResult")));
		}
		$combinedData = ufront_view__TemplateData_TemplateData_Impl_::fromMany((new _hx_array(array(ufront_web_result_ViewResult::$globalValues, $this->helpers, $this->data))));
		$controller = Std::instance($actionContext->controller, _hx_qtype("ufront.web.Controller"));
		if($controller !== null && ufront_view__TemplateData_TemplateData_Impl_::exists($combinedData, "baseUri") === false) {
			ufront_view__TemplateData_TemplateData_Impl_::set($combinedData, "baseUri", $controller->baseUri);
		}
		$controllerCls = Type::getClass($actionContext->controller);
		$viewFolderMeta = haxe_rtti_Meta::getType($controllerCls)->viewFolder;
		$viewFolder = null;
		if($viewFolderMeta !== null && $viewFolderMeta->length > 0) {
			$viewFolder = "" . _hx_string_or_null($viewFolderMeta[0]);
			$viewFolder = haxe_io_Path::removeTrailingSlashes($viewFolder);
		} else {
			$controllerName = null;
			{
				$value = _hx_explode(".", Type::getClassName(Type::getClass($actionContext->controller)))->pop();
				if($value === null) {
					$controllerName = null;
				} else {
					$controllerName = _hx_string_or_null(strtolower(_hx_char_at($value, 0))) . _hx_string_or_null(_hx_substr($value, 1, null));
				}
			}
			if(StringTools::endsWith($controllerName, "Controller")) {
				$controllerName = _hx_substr($controllerName, 0, strlen($controllerName) - 10);
			}
			$viewFolder = $controllerName;
		}
		if($this->viewPath === null) {
			$fieldsMeta = haxe_rtti_Meta::getFields($controllerCls);
			$actionFieldMeta = Reflect::field($fieldsMeta, $actionContext->action);
			if($actionFieldMeta !== null && $actionFieldMeta->template !== null && $actionFieldMeta->template->length > 0) {
				$this->viewPath = "" . _hx_string_or_null($actionFieldMeta->template[0]);
			}
		}
		if($this->viewPath === null) {
			$action = $actionContext->action;
			if(StringTools::startsWith($action, "do")) {
				$action = _hx_substr($action, 2, null);
			}
			if($action === null) {
				$this->viewPath = null;
			} else {
				$this->viewPath = _hx_string_or_null(strtolower(_hx_char_at($action, 0))) . _hx_string_or_null(_hx_substr($action, 1, null));
			}
		}
		$layoutPath = null;
		if($this->layout === null) {
			$classMeta = haxe_rtti_Meta::getType($controllerCls);
			if($classMeta->layout !== null && $classMeta->layout->length > 0) {
				$layoutPath = "" . _hx_string_or_null($classMeta->layout[0]);
			}
		}
		if($this->layout === null && $layoutPath === null) {
			try {
				$layoutPath = $actionContext->httpContext->injector->getInstance(_hx_qtype("String"), "defaultLayout");
				if(StringTools::startsWith($layoutPath, "/") === false) {
					$layoutPath = "/" . _hx_string_or_null($layoutPath);
				}
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e1 = $_ex_;
				{
				}
			}
		}
		if(StringTools::startsWith($this->viewPath, "/")) {
			$this->viewPath = _hx_substr($this->viewPath, 1, null);
		} else {
			$this->viewPath = "" . _hx_string_or_null($viewFolder) . "/" . _hx_string_or_null($this->viewPath);
		}
		if($layoutPath !== null && StringTools::startsWith($layoutPath, "/")) {
			$layoutPath = _hx_substr($layoutPath, 1, null);
		} else {
			$layoutPath = "" . _hx_string_or_null($viewFolder) . "/" . _hx_string_or_null($layoutPath);
		}
		$layoutReady = null;
		if($this->layoutFromString !== null) {
			$layoutReady = tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Success($this->layoutFromString));
		} else {
			if($this->layout === null) {
				if($layoutPath !== null) {
					$this->layout = haxe_ds_Option::Some(new tink_core__Pair_Data($layoutPath, null));
				} else {
					$this->layout = haxe_ds_Option::$None;
				}
			}
			{
				$_g = $this->layout;
				switch($_g->index) {
				case 0:{
					$layoutData = $_g->params[0];
					$layoutReady = $viewEngine->getTemplate($layoutData->a, $layoutData->b);
				}break;
				case 1:{
					$layoutReady = tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Success(null));
				}break;
				}
			}
		}
		$templateReady = null;
		if($this->templateFromString !== null) {
			$templateReady = tink_core__Future_Future_Impl_::sync(tink_core_Outcome::Success($this->templateFromString));
		} else {
			$templateReady = $viewEngine->getTemplate($this->viewPath, $this->templatingEngine);
		}
		$done = tink_core__Future_Future_Impl_::_map(tink_core__Future_Future_Impl_::hand($templateReady, $layoutReady), array(new _hx_lambda(array(&$_g1, &$actionContext, &$combinedData, &$controller, &$controllerCls, &$e, &$layoutPath, &$layoutReady, &$templateReady, &$viewEngine, &$viewFolder, &$viewFolderMeta), "ufront_web_result_ViewResult_0"), 'execute'));
		return $done;
	}
	public function error($reason, $data) {
		return tink_core_Outcome::Failure(ufront_web_HttpError::internalServerError($reason, $data, _hx_anonymous(array("fileName" => "ViewResult.hx", "lineNumber" => 455, "className" => "ufront.web.result.ViewResult", "methodName" => "error"))));
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
	static $globalValues;
	function __toString() { return 'ufront.web.result.ViewResult'; }
}
ufront_web_result_ViewResult::$globalValues = _hx_anonymous(array());
function ufront_web_result_ViewResult_0(&$_g1, &$actionContext, &$combinedData, &$controller, &$controllerCls, &$e, &$layoutPath, &$layoutReady, &$templateReady, &$viewEngine, &$viewFolder, &$viewFolderMeta, $pair) {
	{
		$template = null;
		$layout = null;
		{
			$_g2 = $pair->a;
			switch($_g2->index) {
			case 0:{
				$tpl = $_g2->params[0];
				$template = $tpl;
			}break;
			case 1:{
				$err = $_g2->params[0];
				return $_g1->error("Unable to load view template", $err);
			}break;
			}
		}
		{
			$_g3 = $pair->b;
			switch($_g3->index) {
			case 0:{
				$tpl1 = $_g3->params[0];
				$layout = $tpl1;
			}break;
			case 1:{
				$err1 = $_g3->params[0];
				return $_g1->error("Unable to load layout template", $err1);
			}break;
			}
		}
		$viewOut = null;
		try {
			{
				$cb = $template;
				$viewOut = call_user_func_array($cb, array($combinedData));
			}
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e2 = $_ex_;
			{
				return $_g1->error("Unable to execute view template", $e2);
			}
		}
		$finalOut = null;
		if($layout === null) {
			$finalOut = $viewOut;
		} else {
			ufront_view__TemplateData_TemplateData_Impl_::set($combinedData, "viewContent", $viewOut);
			try {
				{
					$cb1 = $layout;
					$finalOut = call_user_func_array($cb1, array($combinedData));
				}
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e3 = $_ex_;
				{
					return $_g1->error("Unable to execute layout template", $e3);
				}
			}
		}
		$actionContext->httpContext->response->set_contentType("text/html");
		$actionContext->httpContext->response->write($finalOut);
		return tink_core_Outcome::Success(tink_core_Noise::$Noise);
	}
}
