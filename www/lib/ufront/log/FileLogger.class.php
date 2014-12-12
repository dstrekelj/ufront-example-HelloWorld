<?php

class ufront_log_FileLogger implements ufront_app_UFInitRequired, ufront_app_UFLogHandler{
	public function __construct($path) {
		if(!php_Boot::$skip_constructor) {
		$this->path = $path;
	}}
	public $path;
	public function init($app) {
		return ufront_core_Sync::success();
	}
	public function dispose($app) {
		$this->path = null;
		return ufront_core_Sync::success();
	}
	public function log($context, $appMessages) {
		$logFile = _hx_string_or_null($context->get_contentDirectory()) . _hx_string_or_null($this->path);
		$req = $context->request;
		$res = $context->response;
		$userDetails = $req->get_clientIP();
		if((((null !== $context->session) ? $context->session->get_id() : null)) !== null) {
			$userDetails .= " " . _hx_string_or_null((((null !== $context->session) ? $context->session->get_id() : null)));
		}
		if(((($context->auth !== null && $context->auth->get_currentUser() !== null) ? $context->auth->get_currentUser()->get_userID() : null)) !== null) {
			$userDetails .= " " . _hx_string_or_null(((($context->auth !== null && $context->auth->get_currentUser() !== null) ? $context->auth->get_currentUser()->get_userID() : null)));
		}
		$content = "" . Std::string(Date::now()) . " [" . _hx_string_or_null($req->get_httpMethod()) . "] [" . _hx_string_or_null($req->get_uri()) . "] from [" . _hx_string_or_null($userDetails) . "], response: [" . _hx_string_rec($res->status, "") . " " . _hx_string_or_null($res->get_contentType()) . "]\x0A";
		{
			$_g = 0;
			$_g1 = $context->messages;
			while($_g < $_g1->length) {
				$msg = $_g1[$_g];
				++$_g;
				$content .= "\x09" . _hx_string_or_null(ufront_log_FileLogger::format($msg)) . "\x0A";
				unset($msg);
			}
		}
		if($appMessages !== null) {
			$_g2 = 0;
			while($_g2 < $appMessages->length) {
				$msg1 = $appMessages[$_g2];
				++$_g2;
				$content .= "\x09" . _hx_string_or_null(ufront_log_FileLogger::format($msg1)) . "\x0A";
				unset($msg1);
			}
		}
		ufront_sys_SysUtil::mkdir(haxe_io_Path::directory($logFile));
		$file = sys_io_File::append(_hx_string_or_null($context->get_contentDirectory()) . _hx_string_or_null($this->path), null);
		$file->writeString($content);
		$file->close();
		return ufront_core_Sync::success();
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
	static $REMOVENL;
	static function format($msg) {
		$text = ufront_log_FileLogger::$REMOVENL->replace(Dynamics::string($msg->msg), "\\n");
		$type = Type::enumConstructor($msg->type);
		$pos = $msg->pos;
		return "[" . _hx_string_or_null($type) . "] " . _hx_string_or_null($pos->className) . "." . _hx_string_or_null($pos->methodName) . "(" . _hx_string_rec($pos->lineNumber, "") . "): " . _hx_string_or_null($text);
	}
	function __toString() { return 'ufront.log.FileLogger'; }
}
ufront_log_FileLogger::$REMOVENL = new EReg("[\x0A\x0D]", "g");
