<?php

class ufront_log_RemotingLogger implements ufront_app_UFLogHandler{
	public function __construct() { 
	}
	public function log($httpContext, $appMessages) {
		if($httpContext->response->get_contentType() === "application/x-haxe-remoting") {
			$results = (new _hx_array(array()));
			{
				$_g = 0;
				$_g1 = $httpContext->messages;
				while($_g < $_g1->length) {
					$msg = $_g1[$_g];
					++$_g;
					$results->push(ufront_log_RemotingLogger::formatMessage($msg));
					unset($msg);
				}
			}
			if($results->length > 0) {
				$httpContext->response->write("\x0A" . _hx_string_or_null($results->join("\x0A")));
			}
		}
		return ufront_core_Sync::success();
	}
	static function formatMessage($m) {
		$m->msg = "" . Std::string($m->msg);
		if($m->pos->customParams !== null) {
			$_g = (new _hx_array(array()));
			{
				$_g1 = 0;
				$_g2 = $m->pos->customParams;
				while($_g1 < $_g2->length) {
					$p = $_g2[$_g1];
					++$_g1;
					$_g->push("" . Std::string($p));
					unset($p);
				}
			}
			$m->pos->customParams = $_g;
		}
		return "hxt" . _hx_string_or_null(haxe_Serializer::run($m));
	}
	function __toString() { return 'ufront.log.RemotingLogger'; }
}
