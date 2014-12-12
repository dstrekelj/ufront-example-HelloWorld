<?php

class Strings {
	public function __construct(){}
	static $_re;
	static $_reSplitWC;
	static $_reReduceWS;
	static $_reFormat;
	static function format($pattern, $values, $nullstring = null, $culture = null) {
		if($nullstring === null) {
			$nullstring = "null";
		}
		if(null === $values || 0 === $values->length) {
			return $pattern;
		}
		return call_user_func_array(Strings::formatf($pattern, $nullstring, $culture), array($values));
	}
	static function formatf($pattern, $nullstring = null, $culture = null) {
		if($nullstring === null) {
			$nullstring = "null";
		}
		$buf = (new _hx_array(array()));
		while(true) {
			if(!Strings::$_reFormat->match($pattern)) {
				$buf->push(array(new _hx_lambda(array(&$buf, &$culture, &$nullstring, &$pattern), "Strings_0"), 'execute'));
				break;
			}
			$pos = Std::parseInt(Strings::$_reFormat->matched(1));
			$format = Strings::$_reFormat->matched(2);
			if($format === "") {
				$format = null;
			}
			$p = null;
			$params = (new _hx_array(array()));
			{
				$_g = 3;
				while($_g < 20) {
					$i = $_g++;
					$p = Strings::$_reFormat->matched($i);
					if($p === null || $p === "") {
						break;
					}
					$params->push(thx_culture_FormatParams::cleanQuotes($p));
					unset($i);
				}
				unset($_g);
			}
			$left = Strings::$_reFormat->matchedLeft();
			$buf->push(array(new _hx_lambda(array(&$buf, &$culture, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos), "Strings_1"), 'execute'));
			$df = Dynamics::formatf($format, $params, $nullstring, $culture);
			$buf->push(Strings_2($buf, $culture, $df, $format, $left, $nullstring, $p, $params, $pattern, $pos));
			$pattern = Strings::$_reFormat->matchedRight();
			unset($pos,$params,$p,$left,$format,$df);
		}
		return array(new _hx_lambda(array(&$buf, &$culture, &$nullstring, &$pattern), "Strings_3"), 'execute');
	}
	static function formatOne($v, $param = null, $params = null, $culture = null) {
		return call_user_func_array(Strings::formatOnef($param, $params, $culture), array($v));
	}
	static function formatOnef($param = null, $params = null, $culture = null) {
		$params = thx_culture_FormatParams::params($param, $params, "S");
		$format = $params->shift();
		switch($format) {
		case "S":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Strings_4"), 'execute');
		}break;
		case "T":{
			$len = null;
			if($params->length < 1) {
				$len = 20;
			} else {
				$len = Std::parseInt($params[0]);
			}
			$ellipsis = null;
			if($params->length < 2) {
				$ellipsis = "...";
			} else {
				$ellipsis = $params[1];
			}
			return Strings::ellipsisf($len, $ellipsis);
		}break;
		case "PR":{
			$len1 = null;
			if($params->length < 1) {
				$len1 = 10;
			} else {
				$len1 = Std::parseInt($params[0]);
			}
			$pad = null;
			if($params->length < 2) {
				$pad = " ";
			} else {
				$pad = $params[1];
			}
			return array(new _hx_lambda(array(&$culture, &$format, &$len1, &$pad, &$param, &$params), "Strings_5"), 'execute');
		}break;
		case "PL":{
			$len2 = null;
			if($params->length < 1) {
				$len2 = 10;
			} else {
				$len2 = Std::parseInt($params[0]);
			}
			$pad1 = null;
			if($params->length < 2) {
				$pad1 = " ";
			} else {
				$pad1 = $params[1];
			}
			return array(new _hx_lambda(array(&$culture, &$format, &$len2, &$pad1, &$param, &$params), "Strings_6"), 'execute');
		}break;
		default:{
			throw new HException("Unsupported string format: " . _hx_string_or_null($format));
		}break;
		}
	}
	static function upTo($value, $searchFor) {
		$pos = _hx_index_of($value, $searchFor, null);
		if($pos < 0) {
			return $value;
		} else {
			return _hx_substr($value, 0, $pos);
		}
	}
	static function startFrom($value, $searchFor) {
		$pos = _hx_index_of($value, $searchFor, null);
		if($pos < 0) {
			return $value;
		} else {
			return _hx_substr($value, $pos + strlen($searchFor), null);
		}
	}
	static function rtrim($value, $charlist) {
		return rtrim($value, $charlist);
	}
	static function ltrim($value, $charlist) {
		return ltrim($value, $charlist);
	}
	static function trim($value, $charlist) {
		return trim($value, $charlist);
	}
	static $_reCollapse;
	static function collapse($value) {
		return Strings::$_reCollapse->replace(trim($value), " ");
	}
	static function ucfirst($value) {
		if($value === null) {
			return null;
		} else {
			return _hx_string_or_null(strtoupper(_hx_char_at($value, 0))) . _hx_string_or_null(_hx_substr($value, 1, null));
		}
	}
	static function lcfirst($value) {
		if($value === null) {
			return null;
		} else {
			return _hx_string_or_null(strtolower(_hx_char_at($value, 0))) . _hx_string_or_null(_hx_substr($value, 1, null));
		}
	}
	static function hempty($value) {
		return $value === null || $value === "";
	}
	static function isAlphaNum($value) {
		return ctype_alnum($value);
	}
	static function digitsOnly($value) {
		return ctype_digit($value);
	}
	static function ucwords($value) {
		return Strings::$__ucwordsPattern->map(Strings_7($value), (isset(Strings::$__upperMatch) ? Strings::$__upperMatch: array("Strings", "__upperMatch")));
	}
	static function ucwordsws($value) {
		return ucwords($value);
	}
	static function __upperMatch($re) {
		return strtoupper($re->matched(0));
	}
	static $__ucwordsPattern;
	static function humanize($s) {
		$s1 = Strings::underscore($s);
		return str_replace("_", " ", $s1);
	}
	static function capitalize($s) {
		return _hx_string_or_null(strtoupper(_hx_substr($s, 0, 1))) . _hx_string_or_null(_hx_substr($s, 1, null));
	}
	static function succ($s) {
		return _hx_string_or_null(_hx_substr($s, 0, -1)) . _hx_string_or_null(chr(_hx_char_code_at(_hx_substr($s, -1, null), 0) + 1));
	}
	static function underscore($s) {
		$s = _hx_deref(new EReg("::", "g"))->replace($s, "/");
		$s = _hx_deref(new EReg("([A-Z]+)([A-Z][a-z])", "g"))->replace($s, "\$1_\$2");
		$s = _hx_deref(new EReg("([a-z\\d])([A-Z])", "g"))->replace($s, "\$1_\$2");
		$s = _hx_deref(new EReg("-", "g"))->replace($s, "_");
		return strtolower($s);
	}
	static function dasherize($s) {
		return str_replace("_", "-", $s);
	}
	static function repeat($s, $times) {
		$b = (new _hx_array(array()));
		{
			$_g = 0;
			while($_g < $times) {
				$i = $_g++;
				$b->push($s);
				unset($i);
			}
		}
		return $b->join("");
	}
	static function wrapColumns($s, $columns = null, $indent = null, $newline = null) {
		if($newline === null) {
			$newline = "\x0A";
		}
		if($indent === null) {
			$indent = "";
		}
		if($columns === null) {
			$columns = 78;
		}
		$parts = Strings::$_reSplitWC->split($s);
		$result = (new _hx_array(array()));
		{
			$_g = 0;
			while($_g < $parts->length) {
				$part = $parts[$_g];
				++$_g;
				$result->push(Strings::_wrapColumns(Strings_8($_g, $columns, $indent, $newline, $part, $parts, $result, $s), $columns, $indent, $newline));
				unset($part);
			}
		}
		return $result->join($newline);
	}
	static function _wrapColumns($s, $columns, $indent, $newline) {
		$parts = (new _hx_array(array()));
		$pos = 0;
		$len = strlen($s);
		$ilen = strlen($indent);
		$columns -= $ilen;
		while(true) {
			if($pos + $columns >= $len - $ilen) {
				$parts->push(_hx_substr($s, $pos, null));
				break;
			}
			$i = 0;
			while(!StringTools::isSpace($s, $pos + $columns - $i) && $i < $columns) {
				$i++;
			}
			if($i === $columns) {
				$i = 0;
				while(!StringTools::isSpace($s, $pos + $columns + $i) && $pos + $columns + $i < $len) {
					$i++;
				}
				$parts->push(_hx_substr($s, $pos, $columns + $i));
				$pos += $columns + $i + 1;
			} else {
				$parts->push(_hx_substr($s, $pos, $columns - $i));
				$pos += $columns - $i + 1;
			}
			unset($i);
		}
		return _hx_string_or_null($indent) . _hx_string_or_null($parts->join(_hx_string_or_null($newline) . _hx_string_or_null($indent)));
	}
	static function stripTags($s) {
		return strip_tags($s);
	}
	static $_reInterpolateNumber;
	static function interpolate($v, $a, $b, $equation = null) {
		return call_user_func_array(Strings::interpolatef($a, $b, $equation), array($v));
	}
	static function interpolatef($a, $b, $equation = null) {
		$extract = array(new _hx_lambda(array(&$a, &$b, &$equation), "Strings_9"), 'execute');
		$decimals = array(new _hx_lambda(array(&$a, &$b, &$equation, &$extract), "Strings_10"), 'execute');
		$sa = (new _hx_array(array()));
		$fa = (new _hx_array(array()));
		$sb = (new _hx_array(array()));
		$fb = (new _hx_array(array()));
		call_user_func_array($extract, array($a, $sa, $fa));
		call_user_func_array($extract, array($b, $sb, $fb));
		$functions = (new _hx_array(array()));
		$i = 0;
		$min = null;
		{
			$a1 = $sa->length;
			$b1 = $sb->length;
			if($a1 < $b1) {
				$min = $a1;
			} else {
				$min = $b1;
			}
		}
		while($i < $min) {
			if($sa[$i] !== $sb[$i]) {
				break;
			}
			if(null === $sa[$i]) {
				if($fa[$i] === $fb[$i]) {
					$s2 = "" . _hx_string_rec($fa[$i], "");
					$functions->push(array(new _hx_lambda(array(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$s2, &$sa, &$sb), "Strings_11"), 'execute'));
					unset($s2);
				} else {
					$f1 = Floats::interpolatef($fa[$i], $fb[$i], $equation);
					$dec = Math::pow(10, Strings_12($a, $b, $decimals, $equation, $extract, $f1, $fa, $fb, $functions, $i, $min, $sa, $sb));
					$functions->push(array(new _hx_lambda(array(&$a, &$b, &$dec, &$decimals, &$equation, &$extract, &$f1, &$fa, &$fb, &$functions, &$i, &$min, &$sa, &$sb), "Strings_13"), 'execute'));
					unset($f1,$dec);
				}
			} else {
				$s3 = $sa[$i];
				$functions->push(array(new _hx_lambda(array(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$s3, &$sa, &$sb), "Strings_14"), 'execute'));
				unset($s3);
			}
			$i++;
		}
		$rest = "";
		while($i < $sb->length) {
			if(null !== $sb[$i]) {
				$rest .= _hx_string_or_null($sb[$i]);
			} else {
				$rest .= _hx_string_rec($fb[$i], "");
			}
			$i++;
		}
		if("" !== $rest) {
			$functions->push(array(new _hx_lambda(array(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb), "Strings_15"), 'execute'));
		}
		return array(new _hx_lambda(array(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb), "Strings_16"), 'execute');
	}
	static function interpolateChars($v, $a, $b, $equation = null) {
		return call_user_func_array(Strings::interpolateCharsf($a, $b, $equation), array($v));
	}
	static function interpolateCharsf($a, $b, $equation = null) {
		$aa = _hx_explode("", $a);
		$ab = _hx_explode("", $b);
		while($aa->length > $ab->length) {
			$ab->insert(0, " ");
		}
		while($ab->length > $aa->length) {
			$aa->insert(0, " ");
		}
		$ai = (new _hx_array(array()));
		{
			$_g1 = 0;
			$_g = $aa->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$ai[$i] = Strings::interpolateCharf($aa[$i], $ab[$i], null);
				unset($i);
			}
		}
		return array(new _hx_lambda(array(&$a, &$aa, &$ab, &$ai, &$b, &$equation), "Strings_17"), 'execute');
	}
	static function interpolateChar($v, $a, $b, $equation = null) {
		return call_user_func_array(Strings::interpolateCharf($a, $b, $equation), array($v));
	}
	static function interpolateCharf($a, $b, $equation = null) {
		if(_hx_deref(new EReg("^\\d", ""))->match($b) && $a === " ") {
			$a = "0";
		}
		$r = new EReg("^[^a-zA-Z0-9]", "");
		if($r->match($b) && $a === " ") {
			$a = $r->matched(0);
		}
		$ca = _hx_char_code_at($a, 0);
		$cb = _hx_char_code_at($b, 0);
		$i = Ints::interpolatef($ca, $cb, $equation);
		return array(new _hx_lambda(array(&$a, &$b, &$ca, &$cb, &$equation, &$i, &$r), "Strings_18"), 'execute');
	}
	static function ellipsis($s, $maxlen = null, $symbol = null) {
		if($symbol === null) {
			$symbol = "...";
		}
		if($maxlen === null) {
			$maxlen = 20;
		}
		if(strlen($s) > $maxlen) {
			return _hx_string_or_null(_hx_substr($s, 0, Strings_19($maxlen, $s, $symbol))) . _hx_string_or_null($symbol);
		} else {
			return $s;
		}
	}
	static function ellipsisf($maxlen = null, $symbol = null) {
		if($symbol === null) {
			$symbol = "...";
		}
		if($maxlen === null) {
			$maxlen = 20;
		}
		return array(new _hx_lambda(array(&$maxlen, &$symbol), "Strings_20"), 'execute');
	}
	static function compare($a, $b) {
		if($a < $b) {
			return -1;
		} else {
			if($a > $b) {
				return 1;
			} else {
				return 0;
			}
		}
	}
	function __toString() { return 'Strings'; }
}
Strings::$_re = new EReg("[{](\\d+)(?::[^}]*)?[}]", "m");
Strings::$_reSplitWC = new EReg("(\x0D\x0A|\x0A\x0D|\x0A|\x0D)", "g");
Strings::$_reReduceWS = new EReg("\\s+", "");
Strings::$_reFormat = new EReg("{(\\d+)(?::([a-zA-Z]+))?(?:,([^\"',}]+|'[^']+'|\"[^\"]+\"))?(?:,([^\"',}]+|'[^']+'|\"[^\"]+\"))?(?:,([^\"',}]+|'[^']+'|\"[^\"]+\"))?}", "m");
Strings::$_reCollapse = new EReg("\\s+", "g");
Strings::$__ucwordsPattern = new EReg("[^a-zA-Z]([a-z])", "g");
Strings::$_reInterpolateNumber = new EReg("[-+]?(?:\\d+\\.\\d+|\\d+\\.|\\.\\d+|\\d+)(?:[eE][-]?\\d+)?", "");
function Strings_0(&$buf, &$culture, &$nullstring, &$pattern, $_) {
	{
		return $pattern;
	}
}
function Strings_1(&$buf, &$culture, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos, $_1) {
	{
		return $left;
	}
}
function Strings_2(&$buf, &$culture, &$df, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos) {
	{
		$f = array(new _hx_lambda(array(&$buf, &$culture, &$df, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos), "Strings_21"), 'execute');
		$i2 = $pos;
		return array(new _hx_lambda(array(&$buf, &$culture, &$df, &$f, &$format, &$i2, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos), "Strings_22"), 'execute');
	}
}
function Strings_3(&$buf, &$culture, &$nullstring, &$pattern, $values) {
	{
		if(null === $values) {
			$values = (new _hx_array(array()));
		}
		return $buf->map(array(new _hx_lambda(array(&$buf, &$culture, &$nullstring, &$pattern, &$values), "Strings_23"), 'execute'))->join("");
	}
}
function Strings_4(&$culture, &$format, &$param, &$params, $v) {
	{
		return $v;
	}
}
function Strings_5(&$culture, &$format, &$len1, &$pad, &$param, &$params, $v1) {
	{
		if(strlen($pad) === 0 || strlen($v1) >= $len1) {
			return $v1;
		} else {
			return str_pad($v1, Math::ceil(($len1 - strlen($v1)) / strlen($pad)) * strlen($pad) + strlen($v1), $pad, STR_PAD_RIGHT);
		}
	}
}
function Strings_6(&$culture, &$format, &$len2, &$pad1, &$param, &$params, $v2) {
	{
		if(strlen($pad1) === 0 || strlen($v2) >= $len2) {
			return $v2;
		} else {
			return str_pad($v2, Math::ceil(($len2 - strlen($v2)) / strlen($pad1)) * strlen($pad1) + strlen($v2), $pad1, STR_PAD_LEFT);
		}
	}
}
function Strings_7(&$value) {
	if($value === null) {
		return null;
	} else {
		return _hx_string_or_null(strtoupper(_hx_char_at($value, 0))) . _hx_string_or_null(_hx_substr($value, 1, null));
	}
}
function Strings_8(&$_g, &$columns, &$indent, &$newline, &$part, &$parts, &$result, &$s) {
	{
		$s1 = Strings::$_reReduceWS->replace($part, " ");
		return trim($s1);
	}
}
function Strings_9(&$a, &$b, &$equation, $value, $s, $f) {
	{
		while(Strings::$_reInterpolateNumber->match($value)) {
			$left = Strings::$_reInterpolateNumber->matchedLeft();
			if(!Strings::hempty($left)) {
				$s->push($left);
				$f->push(null);
			}
			$s->push(null);
			$f->push(Std::parseFloat(Strings::$_reInterpolateNumber->matched(0)));
			$value = Strings::$_reInterpolateNumber->matchedRight();
			unset($left);
		}
		if(!Strings::hempty($value)) {
			$s->push($value);
			$f->push(null);
		}
	}
}
function Strings_10(&$a, &$b, &$equation, &$extract, $v) {
	{
		$s1 = "" . _hx_string_rec($v, "");
		$p = _hx_index_of($s1, ".", null);
		if($p < 0) {
			return 0;
		}
		return strlen($s1) - $p - 1;
	}
}
function Strings_11(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$s2, &$sa, &$sb, $_) {
	{
		return $s2;
	}
}
function Strings_12(&$a, &$b, &$decimals, &$equation, &$extract, &$f1, &$fa, &$fb, &$functions, &$i, &$min, &$sa, &$sb) {
	{
		$a2 = call_user_func_array($decimals, array($fa[$i]));
		$b2 = call_user_func_array($decimals, array($fb[$i]));
		if($a2 > $b2) {
			return $a2;
		} else {
			return $b2;
		}
		unset($b2,$a2);
	}
}
function Strings_13(&$a, &$b, &$dec, &$decimals, &$equation, &$extract, &$f1, &$fa, &$fb, &$functions, &$i, &$min, &$sa, &$sb, $t) {
	{
		return "" . _hx_string_rec(Math::round(call_user_func_array($f1, array($t)) * $dec) / $dec, "");
	}
}
function Strings_14(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$s3, &$sa, &$sb, $_1) {
	{
		return $s3;
	}
}
function Strings_15(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb, $_2) {
	{
		return $rest;
	}
}
function Strings_16(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb, $t1) {
	{
		return Iterators::map($functions->iterator(), array(new _hx_lambda(array(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb, &$t1), "Strings_24"), 'execute'))->join("");
	}
}
function Strings_17(&$a, &$aa, &$ab, &$ai, &$b, &$equation, $v) {
	{
		$r = (new _hx_array(array()));
		{
			$_g11 = 0;
			$_g2 = $ai->length;
			while($_g11 < $_g2) {
				$i1 = $_g11++;
				$r[$i1] = call_user_func_array($ai[$i1], array($v));
				unset($i1);
			}
		}
		{
			$s = $r->join("");
			return trim($s);
		}
	}
}
function Strings_18(&$a, &$b, &$ca, &$cb, &$equation, &$i, &$r, $v) {
	{
		return chr(call_user_func_array($i, array($v)));
	}
}
function Strings_19(&$maxlen, &$s, &$symbol) {
	{
		$a = strlen($symbol);
		$b = $maxlen - strlen($symbol);
		if($a > $b) {
			return $a;
		} else {
			return $b;
		}
		unset($b,$a);
	}
}
function Strings_20(&$maxlen, &$symbol, $s) {
	{
		if(strlen($s) > $maxlen) {
			return _hx_string_or_null(_hx_substr($s, 0, Strings_25($maxlen, $s, $symbol))) . _hx_string_or_null($symbol);
		} else {
			return $s;
		}
	}
}
function Strings_21(&$buf, &$culture, &$df, &$format, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos, $i1, $v) {
	{
		return call_user_func_array($df, array($v[$i1]));
	}
}
function Strings_22(&$buf, &$culture, &$df, &$f, &$format, &$i2, &$left, &$nullstring, &$p, &$params, &$pattern, &$pos, $v1) {
	{
		return call_user_func_array($f, array($i2, $v1));
	}
}
function Strings_23(&$buf, &$culture, &$nullstring, &$pattern, &$values, $df1) {
	{
		return call_user_func_array($df1, array($values));
	}
}
function Strings_24(&$a, &$b, &$decimals, &$equation, &$extract, &$fa, &$fb, &$functions, &$i, &$min, &$rest, &$sa, &$sb, &$t1, $f2, $_3) {
	{
		return call_user_func_array($f2, array($t1));
	}
}
function Strings_25(&$maxlen, &$s, &$symbol) {
	{
		$a = strlen($symbol);
		$b = $maxlen - strlen($symbol);
		if($a > $b) {
			return $a;
		} else {
			return $b;
		}
		unset($b,$a);
	}
}
