<?php

class PBKDF2 {
	public function __construct(){}
	static function encode($value, $salt, $iterations = null, $numBytes = null) {
		if($numBytes === null) {
			$numBytes = 512;
		}
		if($iterations === null) {
			$iterations = 1000;
		}
		return PBKDF2::pbkdf2("sha1", $value, $salt, $iterations, $numBytes, false);
	}
	static function pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = null) {
		if($raw_output === null) {
			$raw_output = false;
		}
		$algorithm = strtolower($algorithm);
		if(in_array($algorithm, hash_algos(), true) === false) {
			die("PBKDF2 ERROR: Invalid hash algorithm.");
		}
		if($count <= 0 || $key_length <= 0) {
			die("PBKDF2 ERROR: Invalid parameters.");
		}
		$testHash = hash($algorithm, "", true);
		$hash_length = strlen($testHash);
		$block_count = Math::ceil($key_length / $hash_length);
		$output = "";
		$i = 1;
		while($i <= $block_count) {
			$last = _hx_string_or_null($salt) . _hx_string_or_null(pack("N", $i));
			$xorsum = hash_hmac($algorithm, $last, $password, true);
			$last = $xorsum;
			$j = 1;
			while($j < $count) {
				$xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
				$j++;
			}
			$output = _hx_string_or_null($output) . _hx_string_or_null($xorsum);
			$i++;
			unset($xorsum,$last,$j);
		}
		if($raw_output) {
			return substr($output, 0, $key_length);
		} else {
			return bin2hex(substr($output, 0, $key_length));
		}
	}
	function __toString() { return 'PBKDF2'; }
}
