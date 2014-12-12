<?php

class ufront_web_context_HttpResponse {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->clear();
		$this->_flushed = false;
	}}
	public $charset;
	public $status;
	public $_buff;
	public $_headers;
	public $_cookies;
	public $_flushed;
	public function preventFlush() {
		$this->_flushed = true;
	}
	public function flush() {
		throw new HException(new thx_error_NotImplemented(_hx_anonymous(array("fileName" => "HttpResponse.hx", "lineNumber" => 108, "className" => "ufront.web.context.HttpResponse", "methodName" => "flush"))));
	}
	public function clear() {
		$this->clearCookies();
		$this->clearHeaders();
		$this->clearContent();
		$this->set_contentType(null);
		$this->charset = "utf-8";
		$this->status = 200;
	}
	public function clearCookies() {
		$this->_cookies = new haxe_ds_StringMap();
	}
	public function clearContent() {
		$this->_buff = new StringBuf();
	}
	public function clearHeaders() {
		$this->_headers = new thx_collection_HashList();
	}
	public function write($s) {
		if(null !== $s) {
			$this->_buff->add($s);
		}
	}
	public function writeChar($c) {
		$this->_buff->b .= _hx_string_or_null(chr($c));
	}
	public function writeBytes($b, $pos, $len) {
		$this->_buff->add($b->getString($pos, $len));
	}
	public function setHeader($name, $value) {
		if(null === $name) {
			throw new HException(new thx_error_NullArgument("name", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "HttpResponse.hx", "lineNumber" => 169, "className" => "ufront.web.context.HttpResponse", "methodName" => "setHeader"))));
		}
		if(null === $value) {
			throw new HException(new thx_error_NullArgument("value", "invalid null argument '{0}' for method {1}.{2}()", _hx_anonymous(array("fileName" => "HttpResponse.hx", "lineNumber" => 170, "className" => "ufront.web.context.HttpResponse", "methodName" => "setHeader"))));
		}
		$this->_headers->set($name, $value);
	}
	public function setCookie($cookie) {
		$this->_cookies->set($cookie->name, $cookie);
	}
	public function getBuffer() {
		return $this->_buff->b;
	}
	public function getCookies() {
		return $this->_cookies;
	}
	public function getHeaders() {
		return $this->_headers;
	}
	public function redirect($url) {
		$this->status = 302;
		$this->set_redirectLocation($url);
	}
	public function setOk() {
		$this->status = 200;
	}
	public function setUnauthorized() {
		$this->status = 401;
	}
	public function requireAuthentication($message) {
		$this->setUnauthorized();
		$this->setHeader("WWW-Authenticate", "Basic realm=\"" . _hx_string_or_null($message) . "\"");
	}
	public function setNotFound() {
		$this->status = 404;
	}
	public function setInternalError() {
		$this->status = 500;
	}
	public function permanentRedirect($url) {
		$this->status = 301;
		$this->set_redirectLocation($url);
	}
	public function isRedirect() {
		return Math::floor($this->status / 100) === 3;
	}
	public function isPermanentRedirect() {
		return $this->status === 301;
	}
	public function get_contentType() {
		return $this->_headers->get("Content-type");
	}
	public function set_contentType($v) {
		if(null === $v) {
			$this->_headers->set("Content-type", "text/html");
		} else {
			$this->_headers->set("Content-type", $v);
		}
		return $v;
	}
	public function get_redirectLocation() {
		return $this->_headers->get("Location");
	}
	public function set_redirectLocation($v) {
		if(null === $v) {
			$this->_headers->remove("Location");
		} else {
			$this->_headers->set("Location", $v);
		}
		return $v;
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
	static function create() {
		return new php_ufront_web_context_HttpResponse();
	}
	static $CONTENT_TYPE = "Content-type";
	static $LOCATION = "Location";
	static $DEFAULT_CONTENT_TYPE = "text/html";
	static $DEFAULT_CHARSET = "utf-8";
	static $DEFAULT_STATUS = 200;
	static $MOVED_PERMANENTLY = 301;
	static $FOUND = 302;
	static $UNAUTHORIZED = 401;
	static $NOT_FOUND = 404;
	static $INTERNAL_SERVER_ERROR = 500;
	static $__properties__ = array("set_redirectLocation" => "set_redirectLocation","get_redirectLocation" => "get_redirectLocation","set_contentType" => "set_contentType","get_contentType" => "get_contentType");
	function __toString() { return 'ufront.web.context.HttpResponse'; }
}
