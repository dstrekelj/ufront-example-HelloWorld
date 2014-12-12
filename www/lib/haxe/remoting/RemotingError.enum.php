<?php

class haxe_remoting_RemotingError extends Enum {
	public static function ApiFailure($remotingCallString, $data) { return new haxe_remoting_RemotingError("ApiFailure", 5, array($remotingCallString, $data)); }
	public static function ClientCallbackException($remotingCallString, $e) { return new haxe_remoting_RemotingError("ClientCallbackException", 2, array($remotingCallString, $e)); }
	public static function HttpError($remotingCallString, $responseCode, $responseData) { return new haxe_remoting_RemotingError("HttpError", 0, array($remotingCallString, $responseCode, $responseData)); }
	public static function NoRemotingResult($remotingCallString, $responseData) { return new haxe_remoting_RemotingError("NoRemotingResult", 4, array($remotingCallString, $responseData)); }
	public static function ServerSideException($remotingCallString, $e, $stack) { return new haxe_remoting_RemotingError("ServerSideException", 1, array($remotingCallString, $e, $stack)); }
	public static function UnknownException($e) { return new haxe_remoting_RemotingError("UnknownException", 6, array($e)); }
	public static function UnserializeFailed($remotingCallString, $troubleLine, $err) { return new haxe_remoting_RemotingError("UnserializeFailed", 3, array($remotingCallString, $troubleLine, $err)); }
	public static $__constructors = array(5 => 'ApiFailure', 2 => 'ClientCallbackException', 0 => 'HttpError', 4 => 'NoRemotingResult', 1 => 'ServerSideException', 6 => 'UnknownException', 3 => 'UnserializeFailed');
	}
