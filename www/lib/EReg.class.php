<?php

class EReg {
	public function __construct($r, $opt) {
		if(!php_Boot::$skip_constructor) {
		$this->pattern = $r;
		$a = _hx_explode("g", $opt);
		$this->{"global"} = $a->length > 1;
		if($this->{"global"}) {
			$opt = $a->join("");
		}
		$this->options = $opt;
		$this->re = '"' . str_replace('"','\\"',$r) . '"' . $opt;
	}}
	public $last;
	public $global;
	public $pattern;
	public $options;
	public $re;
	public $matches;
	public function match($s) {
		$p = preg_match($this->re, $s, $this->matches, PREG_OFFSET_CAPTURE);
		if($p > 0) {
			$this->last = $s;
		} else {
			$this->last = null;
		}
		return $p > 0;
	}
	public function matched($n) {
		if($this->matches === null || $n < 0) {
			throw new HException("EReg::matched");
		}
		if($n >= count($this->matches)) {
			return null;
		}
		if($this->matches[$n][1] < 0) {
			return null;
		}
		return $this->matches[$n][0];
	}
	public function matchedLeft() {
		if(count($this->matches) === 0) {
			throw new HException("No string matched");
		}
		return _hx_substr($this->last, 0, $this->matches[0][1]);
	}
	public function matchedRight() {
		if(count($this->matches) === 0) {
			throw new HException("No string matched");
		}
		$x = $this->matches[0][1] + strlen($this->matches[0][0]);
		return _hx_substr($this->last, $x, null);
	}
	public function matchedPos() {
		return _hx_anonymous(array("pos" => $this->matches[0][1], "len" => strlen($this->matches[0][0])));
	}
	public function matchSub($s, $pos, $len = null) {
		if($len === null) {
			$len = -1;
		}
		$p = preg_match($this->re, (($len < 0) ? $s : _hx_substr($s, 0, $pos + $len)), $this->matches, PREG_OFFSET_CAPTURE, $pos);
		if($p > 0) {
			$this->last = $s;
		} else {
			$this->last = null;
		}
		return $p > 0;
	}
	public function split($s) {
		return new _hx_array(preg_split($this->re, $s, $this->{"global"} ? -1 : 2));
	}
	public function replace($s, $by) {
		$by = str_replace("\\\$", "\\\\\$", $by);
		$by = str_replace("\$\$", "\\\$", $by);
		if(!preg_match('/\\([^?].+?\\)/', $this->re)) $by = preg_replace('/\$(\d+)/', '\\\$\1', $by);
		return preg_replace($this->re, $by, $s, (($this->{"global"}) ? -1 : 1));
	}
	public function map($s, $f) {
		$offset = 0;
		$buf = new StringBuf();
		do {
			if($offset >= strlen($s)) {
				break;
			} else {
				if(!$this->matchSub($s, $offset, null)) {
					$buf->add(_hx_substr($s, $offset, null));
					break;
				}
			}
			$p = $this->matchedPos();
			$buf->add(_hx_substr($s, $offset, $p->pos - $offset));
			$buf->add(call_user_func_array($f, array($this)));
			if($p->len === 0) {
				$buf->add(_hx_substr($s, $p->pos, 1));
				$offset = $p->pos + 1;
			} else {
				$offset = $p->pos + $p->len;
			}
			unset($p);
		} while($this->{"global"});
		if(!$this->{"global"} && $offset > 0 && $offset < strlen($s)) {
			$buf->add(_hx_substr($s, $offset, null));
		}
		return $buf->b;
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
	function __toString() { return 'EReg'; }
}
