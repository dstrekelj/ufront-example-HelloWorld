<?php

class _PBKDF2_SHA1Helpers {
	public function __construct(){}
	static $hexcase = 0;
	static $b64pad = "";
	static $chrsz = 8;
	static function hex_sha1($s) {
		return _PBKDF2_SHA1Helpers::binb2hex(_PBKDF2_SHA1Helpers::core_sha1(_PBKDF2_SHA1Helpers::str2binb($s), strlen($s) * _PBKDF2_SHA1Helpers::$chrsz));
	}
	static function b64_sha1($s) {
		return _PBKDF2_SHA1Helpers::binb2b64(_PBKDF2_SHA1Helpers::core_sha1(_PBKDF2_SHA1Helpers::str2binb($s), strlen($s) * _PBKDF2_SHA1Helpers::$chrsz));
	}
	static function str_sha1($s) {
		return _PBKDF2_SHA1Helpers::binb2str(_PBKDF2_SHA1Helpers::core_sha1(_PBKDF2_SHA1Helpers::str2binb($s), strlen($s) * _PBKDF2_SHA1Helpers::$chrsz));
	}
	static function hex_hmac_sha1($key, $data) {
		return _PBKDF2_SHA1Helpers::binb2hex(_PBKDF2_SHA1Helpers::core_hmac_sha1($key, $data));
	}
	static function b64_hmac_sha1($key, $data) {
		return _PBKDF2_SHA1Helpers::binb2b64(_PBKDF2_SHA1Helpers::core_hmac_sha1($key, $data));
	}
	static function str_hmac_sha1($key, $data) {
		return _PBKDF2_SHA1Helpers::binb2str(_PBKDF2_SHA1Helpers::core_hmac_sha1($key, $data));
	}
	static function sha1_vm_test() {
		return _PBKDF2_SHA1Helpers::hex_sha1("abc") === "a9993e364706816aba3e25717850c26c9cd0d89d";
	}
	static function core_sha1($x, $len) {
		$x->a[$len >> 5] |= 128 << 24 - _hx_mod($len, 32);
		$x[($len + 64 >> 9 << 4) + 15] = $len;
		$w = new _hx_array(array());
		$a = 1732584193;
		$b = -271733879;
		$c = -1732584194;
		$d = 271733878;
		$e = -1009589776;
		$i = 0;
		while($i < $x->length) {
			$olda = $a;
			$oldb = $b;
			$oldc = $c;
			$oldd = $d;
			$olde = $e;
			{
				$_g = 0;
				while($_g < 80) {
					$j = $_g++;
					if($j < 16) {
						$w[$j] = $x[$i + $j];
					} else {
						$w[$j] = _PBKDF2_SHA1Helpers::rol($w->a[$j - 3] ^ $w[$j - 8] ^ $w[$j - 14] ^ $w[$j - 16], 1);
					}
					$t = _PBKDF2_SHA1Helpers::safe_add(_PBKDF2_SHA1Helpers::safe_add(_PBKDF2_SHA1Helpers::rol($a, 5), _PBKDF2_SHA1Helpers::sha1_ft($j, $b, $c, $d)), _PBKDF2_SHA1Helpers::safe_add(_PBKDF2_SHA1Helpers::safe_add($e, $w[$j]), _PBKDF2_SHA1Helpers::sha1_kt($j)));
					$e = $d;
					$d = $c;
					$c = _PBKDF2_SHA1Helpers::rol($b, 30);
					$b = $a;
					$a = $t;
					unset($t,$j);
				}
				unset($_g);
			}
			$a = _PBKDF2_SHA1Helpers::safe_add($a, $olda);
			$b = _PBKDF2_SHA1Helpers::safe_add($b, $oldb);
			$c = _PBKDF2_SHA1Helpers::safe_add($c, $oldc);
			$d = _PBKDF2_SHA1Helpers::safe_add($d, $oldd);
			$e = _PBKDF2_SHA1Helpers::safe_add($e, $olde);
			$i = $i + 16;
			unset($olde,$oldd,$oldc,$oldb,$olda);
		}
		return (new _hx_array(array($a, $b, $c, $d, $e)));
	}
	static function sha1_ft($t, $b, $c, $d) {
		if($t < 20) {
			return $b & $c | ~$b & $d;
		}
		if($t < 40) {
			return $b ^ $c ^ $d;
		}
		if($t < 60) {
			return $b & $c | $b & $d | $c & $d;
		}
		return $b ^ $c ^ $d;
	}
	static function sha1_kt($t) {
		if($t < 20) {
			return 1518500249;
		} else {
			if($t < 40) {
				return 1859775393;
			} else {
				if($t < 60) {
					return -1894007588;
				} else {
					return -899497514;
				}
			}
		}
	}
	static function core_hmac_sha1($key, $data) {
		$bkey = _PBKDF2_SHA1Helpers::str2binb($key);
		if($bkey->length > 16) {
			$bkey = _PBKDF2_SHA1Helpers::core_sha1($bkey, strlen($key) * _PBKDF2_SHA1Helpers::$chrsz);
		}
		$ipad = new _hx_array(array());
		$opad = new _hx_array(array());
		{
			$_g = 0;
			while($_g < 16) {
				$i = $_g++;
				$ipad[$i] = $bkey->a[$i] ^ 909522486;
				$opad[$i] = $bkey->a[$i] ^ 1549556828;
				unset($i);
			}
		}
		$hash = _PBKDF2_SHA1Helpers::core_sha1($ipad->concat(_PBKDF2_SHA1Helpers::str2binb($data)), 512 + strlen($data) * _PBKDF2_SHA1Helpers::$chrsz);
		return _PBKDF2_SHA1Helpers::core_sha1($opad->concat($hash), 672);
	}
	static function safe_add($x, $y) {
		$lsw = ($x & 65535) + ($y & 65535);
		$msw = ($x >> 16) + ($y >> 16) + ($lsw >> 16);
		return $msw << 16 | $lsw & 65535;
	}
	static function rol($num, $cnt) {
		return $num << $cnt | _hx_shift_right($num, 32 - $cnt);
	}
	static function str2binb($str) {
		$bin = new _hx_array(array());
		$mask = (1 << _PBKDF2_SHA1Helpers::$chrsz) - 1;
		$i = 0;
		while($i < strlen($str) * _PBKDF2_SHA1Helpers::$chrsz) {
			$bin->a[$i >> 5] |= (_hx_char_code_at($str, Std::int($i / _PBKDF2_SHA1Helpers::$chrsz)) & $mask) << 32 - _PBKDF2_SHA1Helpers::$chrsz - _hx_mod($i, 32);
			$i = $i + _PBKDF2_SHA1Helpers::$chrsz;
		}
		return $bin;
	}
	static function binb2str($bin) {
		$str = "";
		$mask = (1 << _PBKDF2_SHA1Helpers::$chrsz) - 1;
		$i = 0;
		while($i < $bin->length * 32) {
			$str .= _hx_string_or_null(chr(_hx_shift_right($bin[$i >> 5], 32 - _PBKDF2_SHA1Helpers::$chrsz - _hx_mod($i, 32)) & $mask));
			$i = $i + _PBKDF2_SHA1Helpers::$chrsz;
		}
		return $str;
	}
	static function binb2hex($binarray) {
		$hex_tab = null;
		if(_PBKDF2_SHA1Helpers::$hexcase === 1) {
			$hex_tab = "0123456789ABCDEF";
		} else {
			$hex_tab = "0123456789abcdef";
		}
		$str = "";
		{
			$_g1 = 0;
			$_g = $binarray->length * 4;
			while($_g1 < $_g) {
				$i = $_g1++;
				$str .= _hx_string_or_null(_hx_char_at($hex_tab, $binarray->a[$i >> 2] >> (3 - _hx_mod($i, 4)) * 8 + 4 & 15)) . _hx_string_or_null(_hx_char_at($hex_tab, $binarray->a[$i >> 2] >> (3 - _hx_mod($i, 4)) * 8 & 15));
				unset($i);
			}
		}
		return $str;
	}
	static function binb2b64($binarray) {
		$tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
		$str = "";
		$i = 0;
		while($i < $binarray->length * 4) {
			$triplet = ($binarray->a[$i >> 2] >> 8 * (3 - _hx_mod($i, 4)) & 255) << 16 | ($binarray->a[$i + 1 >> 2] >> 8 * (3 - _hx_mod(($i + 1), 4)) & 255) << 8 | $binarray->a[$i + 2 >> 2] >> 8 * (3 - _hx_mod(($i + 2), 4)) & 255;
			{
				$_g = 0;
				while($_g < 4) {
					$j = $_g++;
					if($i * 8 + $j * 6 > $binarray->length * 32) {
						$str .= _hx_string_or_null(_PBKDF2_SHA1Helpers::$b64pad);
					} else {
						$str .= _hx_string_or_null(_hx_char_at($tab, $triplet >> 6 * (3 - $j) & 63));
					}
					unset($j);
				}
				unset($_g);
			}
			$i = $i + 3;
			unset($triplet);
		}
		return $str;
	}
	function __toString() { return '_PBKDF2.SHA1Helpers'; }
}
