<?php

class sys_io__Process_Stdin extends haxe_io_Output {
	public function __construct($p) {
		if(!php_Boot::$skip_constructor) {
		$this->p = $p;
		$this->buf = haxe_io_Bytes::alloc(1);
	}}
	public $p;
	public $buf;
	public function close() {
		parent::close();
		fclose($this->p);
	}
	public function writeByte($c) {
		$this->buf->b[0] = chr($c);
		$this->writeBytes($this->buf, 0, 1);
	}
	public function writeBytes($b, $pos, $l) {
		$s = $b->getString($pos, $l);
		if(feof($this->p)) {
			throw new HException(new haxe_io_Eof());
		}
		$r = fwrite($this->p, $s, $l);
		if(($r === false)) {
			throw new HException(haxe_io_Error::Custom("An error occurred"));
		}
		return $r;
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
	function __toString() { return 'sys.io._Process.Stdin'; }
}
