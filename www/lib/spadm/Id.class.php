<?php

class spadm_Id {
	public function __construct(){}
	static function encode($id) {
		$l = strlen($id);
		if($l > 6) {
			throw new HException("Invalid identifier '" . _hx_string_or_null($id) . "'");
		}
		$k = 0;
		$p = $l;
		while($p > 0) {
			$c = _hx_char_code_at($id, --$p) - 96;
			if($c < 1 || $c > 26) {
				$c = $c + 96 - 48;
				if($c >= 1 && $c <= 5) {
					$c += 26;
				} else {
					throw new HException("Invalid character " . _hx_string_rec(_hx_char_code_at($id, $p), "") . " in " . _hx_string_or_null($id));
				}
			}
			$k <<= 5;
			$k += $c;
			unset($c);
		}
		return $k;
	}
	static function decode($id) {
		$s = new StringBuf();
		if($id < 1) {
			if($id === 0) {
				return "";
			}
			throw new HException("Invalid ID " . _hx_string_rec($id, ""));
		}
		while($id > 0) {
			$k = $id & 31;
			if($k < 27) {
				$s->b .= _hx_string_or_null(chr($k + 96));
			} else {
				$s->b .= _hx_string_or_null(chr($k + 22));
			}
			$id >>= 5;
			unset($k);
		}
		return $s->b;
	}
	function __toString() { return 'spadm.Id'; }
}
