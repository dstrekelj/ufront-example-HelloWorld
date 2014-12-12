<?php

class ufront_app_UfrontApplication extends ufront_app_HttpApplication {
	public function __construct($optionsIn = null) {
		if(!php_Boot::$skip_constructor) {
		$this->appTemplatingEngines = new HList();
		$this->firstRun = true;
		parent::__construct();
		$this->configuration = ufront_web_DefaultUfrontConfiguration::get();
		Objects::merge($this->configuration, $optionsIn);
		$this->mvcHandler = new ufront_handler_MVCHandler();
		$this->remotingHandler = new ufront_handler_RemotingHandler();
		if(null == $this->configuration->controllers) throw new HException('null iterable');
		$__hx__it = $this->configuration->controllers->iterator();
		while($__hx__it->hasNext()) {
			$controller = $__hx__it->next();
			ufront_core_InjectionTools::inject($this->injector, $controller, null, null, null, null);
		}
		if(null == $this->configuration->apis) throw new HException('null iterable');
		$__hx__it = $this->configuration->apis->iterator();
		while($__hx__it->hasNext()) {
			$api = $__hx__it->next();
			ufront_core_InjectionTools::inject($this->injector, $api, null, null, null, null);
		}
		$this->addModule($this->requestMiddleware, null, $this->configuration->requestMiddleware, false);
		$this->addModule($this->requestHandlers, null, (new _hx_array(array($this->remotingHandler, $this->mvcHandler))), false);
		$this->addModule($this->responseMiddleware, null, $this->configuration->responseMiddleware, false);
		$this->addModule($this->errorHandlers, null, $this->configuration->errorHandlers, false);
		if(!$this->configuration->disableBrowserTrace) {
			{
				$logger = new ufront_log_BrowserConsoleLogger();
				$this->addModule($this->logHandlers, $logger, null, false);
			}
			{
				$logger1 = new ufront_log_RemotingLogger();
				$this->addModule($this->logHandlers, $logger1, null, false);
			}
		}
		if(null !== $this->configuration->logFile) {
			$logger2 = new ufront_log_FileLogger($this->configuration->logFile);
			$this->addModule($this->logHandlers, $logger2, null, false);
		}
		$path = trim($this->configuration->basePath, "/");
		if(strlen($path) > 0) {
			parent::addUrlFilter(new ufront_web_url_filter_DirectoryUrlFilter($path));
		}
		if($this->configuration->urlRewrite !== true) {
			parent::addUrlFilter(new ufront_web_url_filter_PathInfoUrlFilter(null, null));
		}
		if($this->configuration->sessionImplementation !== null) {
			$this->inject(_hx_qtype("ufront.web.session.UFHttpSession"), null, $this->configuration->sessionImplementation, null, null);
		}
		if($this->configuration->authImplementation !== null) {
			$this->inject(_hx_qtype("ufront.auth.UFAuthHandler"), null, $this->configuration->authImplementation, null, null);
		}
		if($this->configuration->viewEngine !== null) {
			$this->inject(_hx_qtype("String"), $this->configuration->viewPath, null, null, "viewPath");
			$this->inject(_hx_qtype("ufront.view.UFViewEngine"), null, $this->configuration->viewEngine, true, null);
		}
		if($this->configuration->contentDirectory !== null) {
			$this->setContentDirectory($this->configuration->contentDirectory);
		}
		if($this->configuration->defaultLayout !== null) {
			$this->inject(_hx_qtype("String"), $this->configuration->defaultLayout, null, null, "defaultLayout");
		}
		if(_hx_field($this->configuration, "adminModules") !== null) {
			$this->inject(_hx_qtype("List"), Lambda::hlist($this->configuration->adminModules), null, null, "adminModules");
		}
		{
			$_g = 0;
			$_g1 = $this->configuration->templatingEngines;
			while($_g < $_g1->length) {
				$te = $_g1[$_g];
				++$_g;
				$this->addTemplatingEngine($te);
				unset($te);
			}
		}
	}}
	public $configuration;
	public $mvcHandler;
	public $remotingHandler;
	public $viewEngine;
	public function execute($httpContext) {
		if(null === $httpContext) {
			throw new HException(new thx_error_NullArgument("httpContext", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "UfrontApplication.hx", "lineNumber" => 161, "className" => "ufront.app.UfrontApplication", "methodName" => "execute"))));
		}
		if($this->firstRun) {
			$this->initOnFirstExecute($httpContext);
		}
		return parent::execute($httpContext);
	}
	public $firstRun;
	public function initOnFirstExecute($httpContext) {
		$this->firstRun = false;
		$this->inject(_hx_qtype("String"), $httpContext->request->get_scriptDirectory(), null, null, "scriptDirectory");
		$this->inject(_hx_qtype("String"), $httpContext->get_contentDirectory(), null, null, "contentDirectory");
		if($this->configuration->viewEngine !== null) {
			try {
				$this->inject($this->configuration->viewEngine, null, null, null, null);
				$this->viewEngine = $this->injector->getInstance(_hx_qtype("ufront.view.UFViewEngine"), null);
				if(null == $this->appTemplatingEngines) throw new HException('null iterable');
				$__hx__it = $this->appTemplatingEngines->iterator();
				while($__hx__it->hasNext()) {
					$te = $__hx__it->next();
					$this->viewEngine->engines->push($te);
				}
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e = $_ex_;
				{
					$msg = "Failed to load view engine " . _hx_string_or_null(Type::getClassName($this->configuration->viewEngine)) . ": " . Std::string($e);
					$httpContext->messages->push(_hx_anonymous(array("msg" => $msg, "pos" => _hx_anonymous(array("fileName" => "UfrontApplication.hx", "lineNumber" => 185, "className" => "ufront.app.UfrontApplication", "methodName" => "initOnFirstExecute")), "type" => ufront_log_MessageType::$Warning)));
				}
			}
		}
	}
	public function loadApiContext($apiContext) {
		$this->remotingHandler->apiContexts->push($apiContext);
		return $this;
	}
	public $appTemplatingEngines;
	public function addTemplatingEngine($engine) {
		$this->appTemplatingEngines->add($engine);
		if($this->viewEngine !== null) {
			$this->viewEngine->engines->push($engine);
		}
		return $this;
	}
	public function inject($cl, $val = null, $cl2 = null, $singleton = null, $named = null) {
		if($singleton === null) {
			$singleton = false;
		}
		return parent::inject($cl,$val,$cl2,$singleton,$named);
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
	function __toString() { return 'ufront.app.UfrontApplication'; }
}
