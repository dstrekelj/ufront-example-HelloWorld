<?php

class php_ufront_web_context_HttpResponse extends ufront_web_context_HttpResponse {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function flush() {
		if($this->_flushed) {
			return;
		}
		$this->_flushed = true;
		$k = null;
		$v = null;
		header("X-Powered-By: ufront", true);
		header("HTTP/1.1 " . _hx_string_or_null(php_ufront_web_context_HttpResponse::statusDescription($this->status)), true, $this->status);
		try {
			if(null == $this->_cookies) throw new HException('null iterable');
			$__hx__it = $this->_cookies->iterator();
			while($__hx__it->hasNext()) {
				$cookie = $__hx__it->next();
				$expire = null;
				if($cookie->expires === null) {
					$expire = 0;
				} else {
					$expire = $cookie->expires->getTime() / 1000;
				}
				setcookie($cookie->name, $cookie->value, $expire, $cookie->path, $cookie->domain, $cookie->secure);
				unset($expire);
			}
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				throw new HException(new thx_error_Error("you can't set the cookie, output already sent", null, null, _hx_anonymous(array("fileName" => "HttpResponse.hx", "lineNumber" => 33, "className" => "php.ufront.web.context.HttpResponse", "methodName" => "flush"))));
			}
		}
		try {
			if(null == $this->_headers) throw new HException('null iterable');
			$__hx__it = $this->_headers->keys();
			while($__hx__it->hasNext()) {
				$key = $__hx__it->next();
				$k = $key;
				$v = $this->_headers->get($key);
				if($k === "Content-type" && null !== $this->charset && StringTools::startsWith($v, "text/")) {
					$v .= "; charset=" . _hx_string_or_null($this->charset);
				}
				header(php_ufront_web_context_HttpResponse_0($this, $e, $k, $key, $v), true);
			}
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e1 = $_ex_;
			{
				throw new HException(new thx_error_Error("invalid header: '{0}: {1}' or output already sent", (new _hx_array(array($k, $v))), null, _hx_anonymous(array("fileName" => "HttpResponse.hx", "lineNumber" => 50, "className" => "php.ufront.web.context.HttpResponse", "methodName" => "flush"))));
			}
		}
		php_Lib::hprint($this->_buff->b);
	}
	static function statusDescription($r) {
		switch($r) {
		case 100:{
			return "100 Continue";
		}break;
		case 101:{
			return "101 Switching Protocols";
		}break;
		case 200:{
			return "200 Continue";
		}break;
		case 201:{
			return "201 Created";
		}break;
		case 202:{
			return "202 Accepted";
		}break;
		case 203:{
			return "203 Non-Authoritative Information";
		}break;
		case 204:{
			return "204 No Content";
		}break;
		case 205:{
			return "205 Reset Content";
		}break;
		case 206:{
			return "206 Partial Content";
		}break;
		case 300:{
			return "300 Multiple Choices";
		}break;
		case 301:{
			return "301 Moved Permanently";
		}break;
		case 302:{
			return "302 Found";
		}break;
		case 303:{
			return "303 See Other";
		}break;
		case 304:{
			return "304 Not Modified";
		}break;
		case 305:{
			return "305 Use Proxy";
		}break;
		case 307:{
			return "307 Temporary Redirect";
		}break;
		case 400:{
			return "400 Bad Request";
		}break;
		case 401:{
			return "401 Unauthorized";
		}break;
		case 402:{
			return "402 Payment Required";
		}break;
		case 403:{
			return "403 Forbidden";
		}break;
		case 404:{
			return "404 Not Found";
		}break;
		case 405:{
			return "405 Method Not Allowed";
		}break;
		case 406:{
			return "406 Not Acceptable";
		}break;
		case 407:{
			return "407 Proxy Authentication Required";
		}break;
		case 408:{
			return "408 Request Timeout";
		}break;
		case 409:{
			return "409 Conflict";
		}break;
		case 410:{
			return "410 Gone";
		}break;
		case 411:{
			return "411 Length Required";
		}break;
		case 412:{
			return "412 Precondition Failed";
		}break;
		case 413:{
			return "413 Request Entity Too Large";
		}break;
		case 414:{
			return "414 Request-URI Too Long";
		}break;
		case 415:{
			return "415 Unsupported Media Type";
		}break;
		case 416:{
			return "416 Requested Range Not Satisfiable";
		}break;
		case 417:{
			return "417 Expectation Failed";
		}break;
		case 500:{
			return "500 Internal Server Error";
		}break;
		case 501:{
			return "501 Not Implemented";
		}break;
		case 502:{
			return "502 Bad Gateway";
		}break;
		case 503:{
			return "503 Service Unavailable";
		}break;
		case 504:{
			return "504 Gateway Timeout";
		}break;
		case 505:{
			return "505 HTTP Version Not Supported";
		}break;
		default:{
			return Std::string($r);
		}break;
		}
	}
	static $__properties__ = array("set_redirectLocation" => "set_redirectLocation","get_redirectLocation" => "get_redirectLocation","set_contentType" => "set_contentType","get_contentType" => "get_contentType");
	function __toString() { return 'php.ufront.web.context.HttpResponse'; }
}
function php_ufront_web_context_HttpResponse_0(&$__hx__this, &$e, &$k, &$key, &$v) {
	if($v === null) {
		return $key;
	} else {
		return _hx_string_or_null($key) . ": " . _hx_string_or_null($v);
	}
}
