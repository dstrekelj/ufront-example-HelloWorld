<?php

class ufront_web_context_RequestCompletion extends Enum {
	public static $CErrorHandlersComplete;
	public static $CFlushComplete;
	public static $CLogHandlersComplete;
	public static $CRequestHandlersComplete;
	public static $CRequestMiddlewareComplete;
	public static $CResponseMiddlewareComplete;
	public static $__constructors = array(5 => 'CErrorHandlersComplete', 4 => 'CFlushComplete', 3 => 'CLogHandlersComplete', 1 => 'CRequestHandlersComplete', 0 => 'CRequestMiddlewareComplete', 2 => 'CResponseMiddlewareComplete');
	}
ufront_web_context_RequestCompletion::$CErrorHandlersComplete = new ufront_web_context_RequestCompletion("CErrorHandlersComplete", 5);
ufront_web_context_RequestCompletion::$CFlushComplete = new ufront_web_context_RequestCompletion("CFlushComplete", 4);
ufront_web_context_RequestCompletion::$CLogHandlersComplete = new ufront_web_context_RequestCompletion("CLogHandlersComplete", 3);
ufront_web_context_RequestCompletion::$CRequestHandlersComplete = new ufront_web_context_RequestCompletion("CRequestHandlersComplete", 1);
ufront_web_context_RequestCompletion::$CRequestMiddlewareComplete = new ufront_web_context_RequestCompletion("CRequestMiddlewareComplete", 0);
ufront_web_context_RequestCompletion::$CResponseMiddlewareComplete = new ufront_web_context_RequestCompletion("CResponseMiddlewareComplete", 2);
