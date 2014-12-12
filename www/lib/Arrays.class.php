<?php

class Arrays {
	public function __construct(){}
	static function addIf($arr, $condition = null, $value) {
		if(null !== $condition) {
			if($condition) {
				$arr->push($value);
			}
		} else {
			if(null !== $value) {
				$arr->push($value);
			}
		}
		return $arr;
	}
	static function add($arr, $value) {
		$arr->push($value);
		return $arr;
	}
	static function delete($arr, $value) {
		$arr->remove($value);
		return $arr;
	}
	static function removef($arr, $f) {
		$index = -1;
		{
			$_g1 = 0;
			$_g = $arr->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if(call_user_func_array($f, array($arr[$i]))) {
					$index = $i;
					break;
				}
				unset($i);
			}
		}
		if($index < 0) {
			return false;
		}
		$arr->splice($index, 1);
		return true;
	}
	static function deletef($arr, $f) {
		Arrays::removef($arr, $f);
		return $arr;
	}
	static function filter($arr, $f) {
		$result = (new _hx_array(array()));
		{
			$_g = 0;
			while($_g < $arr->length) {
				$i = $arr[$_g];
				++$_g;
				if(call_user_func_array($f, array($i))) {
					$result->push($i);
				}
				unset($i);
			}
		}
		return $result;
	}
	static function min($arr, $f = null) {
		if($arr->length === 0) {
			return null;
		}
		if(null === $f) {
			$a = $arr[0];
			$p = 0;
			$comp = Dynamics::comparef($a);
			{
				$_g1 = 1;
				$_g = $arr->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					if(call_user_func_array($comp, array($a, $arr[$i])) > 0) {
						$a = $arr[$p = $i];
					}
					unset($i);
				}
			}
			return $arr[$p];
		} else {
			$a1 = call_user_func_array($f, array($arr[0]));
			$p1 = 0;
			$b = null;
			{
				$_g11 = 1;
				$_g2 = $arr->length;
				while($_g11 < $_g2) {
					$i1 = $_g11++;
					if($a1 > ($b = call_user_func_array($f, array($arr[$i1])))) {
						$a1 = $b;
						$p1 = $i1;
					}
					unset($i1);
				}
			}
			return $arr[$p1];
		}
	}
	static function floatMin($arr, $f) {
		if($arr->length === 0) {
			return Math::$NaN;
		}
		$a = call_user_func_array($f, array($arr[0]));
		$b = null;
		{
			$_g1 = 1;
			$_g = $arr->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if($a > ($b = call_user_func_array($f, array($arr[$i])))) {
					$a = $b;
				}
				unset($i);
			}
		}
		return $a;
	}
	static function bounds($arr, $f = null) {
		if($arr->length === 0) {
			return null;
		}
		if(null === $f) {
			$a = $arr[0];
			$p = 0;
			$b = $arr[0];
			$q = 0;
			{
				$_g1 = 1;
				$_g = $arr->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					$comp = Dynamics::comparef($a);
					if(call_user_func_array($comp, array($a, $arr[$i])) > 0) {
						$a = $arr[$p = $i];
					}
					if(call_user_func_array($comp, array($b, $arr[$i])) < 0) {
						$b = $arr[$q = $i];
					}
					unset($i,$comp);
				}
			}
			return (new _hx_array(array($arr[$p], $arr[$q])));
		} else {
			$a1 = call_user_func_array($f, array($arr[0]));
			$p1 = 0;
			$b1 = null;
			$c = call_user_func_array($f, array($arr[0]));
			$q1 = 0;
			$d = null;
			{
				$_g11 = 1;
				$_g2 = $arr->length;
				while($_g11 < $_g2) {
					$i1 = $_g11++;
					if($a1 > ($b1 = call_user_func_array($f, array($arr[$i1])))) {
						$a1 = $b1;
						$p1 = $i1;
					}
					unset($i1);
				}
			}
			{
				$_g12 = 1;
				$_g3 = $arr->length;
				while($_g12 < $_g3) {
					$i2 = $_g12++;
					if($c < ($d = call_user_func_array($f, array($arr[$i2])))) {
						$c = $d;
						$q1 = $i2;
					}
					unset($i2);
				}
			}
			return (new _hx_array(array($arr[$p1], $arr[$q1])));
		}
	}
	static function boundsFloat($arr, $f) {
		if($arr->length === 0) {
			return null;
		}
		$a = call_user_func_array($f, array($arr[0]));
		$b = null;
		$c = call_user_func_array($f, array($arr[0]));
		$d = null;
		{
			$_g1 = 1;
			$_g = $arr->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if($a > ($b = call_user_func_array($f, array($arr[$i])))) {
					$a = $b;
				}
				if($c < ($d = call_user_func_array($f, array($arr[$i])))) {
					$c = $d;
				}
				unset($i);
			}
		}
		return (new _hx_array(array($a, $c)));
	}
	static function max($arr, $f = null) {
		if($arr->length === 0) {
			return null;
		}
		if(null === $f) {
			$a = $arr[0];
			$p = 0;
			$comp = Dynamics::comparef($a);
			{
				$_g1 = 1;
				$_g = $arr->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					if(call_user_func_array($comp, array($a, $arr[$i])) < 0) {
						$a = $arr[$p = $i];
					}
					unset($i);
				}
			}
			return $arr[$p];
		} else {
			$a1 = call_user_func_array($f, array($arr[0]));
			$p1 = 0;
			$b = null;
			{
				$_g11 = 1;
				$_g2 = $arr->length;
				while($_g11 < $_g2) {
					$i1 = $_g11++;
					if($a1 < ($b = call_user_func_array($f, array($arr[$i1])))) {
						$a1 = $b;
						$p1 = $i1;
					}
					unset($i1);
				}
			}
			return $arr[$p1];
		}
	}
	static function floatMax($arr, $f) {
		if($arr->length === 0) {
			return Math::$NaN;
		}
		$a = call_user_func_array($f, array($arr[0]));
		$b = null;
		{
			$_g1 = 1;
			$_g = $arr->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if($a < ($b = call_user_func_array($f, array($arr[$i])))) {
					$a = $b;
				}
				unset($i);
			}
		}
		return $a;
	}
	static function flatten($arr) {
		$r = (new _hx_array(array()));
		{
			$_g = 0;
			while($_g < $arr->length) {
				$v = $arr[$_g];
				++$_g;
				$r = $r->concat($v);
				unset($v);
			}
		}
		return $r;
	}
	static function map($arr, $f) {
		return Iterators::map($arr->iterator(), $f);
	}
	static function reduce($arr, $f, $initialValue) {
		return Iterators::reduce($arr->iterator(), $f, $initialValue);
	}
	static function order($arr, $f = null) {
		$arr->sort(Arrays_0($arr, $f));
		return $arr;
	}
	static function orderMultiple($arr, $f = null, $rest) {
		$swap = true;
		$t = null;
		$rest->remove($arr);
		while($swap) {
			$swap = false;
			{
				$_g1 = 0;
				$_g = $arr->length - 1;
				while($_g1 < $_g) {
					$i = $_g1++;
					if(call_user_func_array($f, array($arr[$i], $arr[$i + 1])) > 0) {
						$swap = true;
						$t = $arr[$i];
						$arr[$i] = $arr[$i + 1];
						$arr[$i + 1] = $t;
						{
							$_g2 = 0;
							while($_g2 < $rest->length) {
								$a = $rest[$_g2];
								++$_g2;
								$t = $a[$i];
								$a[$i] = $a[$i + 1];
								$a[$i + 1] = $t;
								unset($a);
							}
							unset($_g2);
						}
					}
					unset($i);
				}
				unset($_g1,$_g);
			}
		}
	}
	static function split($arr, $f = null) {
		if(null === $f) {
			$f = array(new _hx_lambda(array(&$arr, &$f), "Arrays_1"), 'execute');
		}
		$arrays = (new _hx_array(array()));
		$i = -1;
		$values = (new _hx_array(array()));
		$value = null;
		{
			$_g1 = 0;
			$_g = $arr->length;
			while($_g1 < $_g) {
				$i1 = $_g1++;
				if(call_user_func_array($f, array($value = $arr[$i1], $i1))) {
					$values = (new _hx_array(array()));
				} else {
					if($values->length === 0) {
						$arrays->push($values);
					}
					$values->push($value);
				}
				unset($i1);
			}
		}
		return $arrays;
	}
	static function exists($arr, $value = null, $f = null) {
		if(null !== $f) {
			$_g = 0;
			while($_g < $arr->length) {
				$v = $arr[$_g];
				++$_g;
				if(call_user_func_array($f, array($v))) {
					return true;
				}
				unset($v);
			}
		} else {
			$_g1 = 0;
			while($_g1 < $arr->length) {
				$v1 = $arr[$_g1];
				++$_g1;
				if((is_object($_t = $v1) && !($_t instanceof Enum) ? $_t === $value : $_t == $value)) {
					return true;
				}
				unset($v1,$_t);
			}
		}
		return false;
	}
	static function format($v, $param = null, $params = null, $culture = null) {
		$params = thx_culture_FormatParams::params($param, $params, "J");
		$format = $params->shift();
		switch($format) {
		case "J":{
			if($v->length === 0) {
				$empty = null;
				if(null === $params[1]) {
					$empty = "[]";
				} else {
					$empty = $params[1];
				}
				return $empty;
			}
			$sep = null;
			if(null === $params[2]) {
				$sep = ", ";
			} else {
				$sep = $params[2];
			}
			$max = null;
			if($params[3] === null) {
				$max = null;
			} else {
				if("" === $params[3]) {
					$max = null;
				} else {
					$max = Std::parseInt($params[3]);
				}
			}
			if(null !== $max && $max < $v->length) {
				$elipsis = null;
				if(null === $params[4]) {
					$elipsis = " ...";
				} else {
					$elipsis = $params[4];
				}
				return _hx_string_or_null(_hx_deref((Arrays_2($culture, $elipsis, $format, $max, $param, $params, $sep, $v)))->join($sep)) . _hx_string_or_null($elipsis);
			} else {
				return Iterators::map($v->iterator(), array(new _hx_lambda(array(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v), "Arrays_3"), 'execute'))->join($sep);
			}
		}break;
		case "C":{
			return Ints::format($v->length, "I", (new _hx_array(array())), $culture);
		}break;
		default:{
			throw new HException("Unsupported array format: " . _hx_string_or_null($format));
		}break;
		}
	}
	static function formatf($param = null, $params = null, $culture = null) {
		$params = thx_culture_FormatParams::params($param, $params, "J");
		$format = $params->shift();
		switch($format) {
		case "J":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Arrays_4"), 'execute');
		}break;
		case "C":{
			$f = Ints::formatf("I", (new _hx_array(array())), $culture);
			return array(new _hx_lambda(array(&$culture, &$f, &$format, &$param, &$params), "Arrays_5"), 'execute');
		}break;
		default:{
			throw new HException("Unsupported array format: " . _hx_string_or_null($format));
		}break;
		}
	}
	static function interpolate($v, $a, $b, $equation = null) {
		return call_user_func_array(Arrays::interpolatef($a, $b, $equation), array($v));
	}
	static function interpolatef($a, $b, $equation = null) {
		$functions = (new _hx_array(array()));
		$i = 0;
		$min = null;
		{
			$a1 = $a->length;
			$b1 = $b->length;
			if($a1 < $b1) {
				$min = $a1;
			} else {
				$min = $b1;
			}
		}
		while($i < $min) {
			if($a[$i] === $b[$i]) {
				$v = $b[$i];
				$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v), "Arrays_6"), 'execute'));
				unset($v);
			} else {
				$functions->push(Floats::interpolatef($a[$i], $b[$i], $equation));
			}
			$i++;
		}
		while($i < $b->length) {
			$v1 = $b[$i];
			$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v1), "Arrays_7"), 'execute'));
			$i++;
			unset($v1);
		}
		return array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min), "Arrays_8"), 'execute');
	}
	static function interpolateStrings($v, $a, $b, $equation = null) {
		return call_user_func_array(Arrays::interpolateStringsf($a, $b, $equation), array($v));
	}
	static function interpolateStringsf($a, $b, $equation = null) {
		$functions = (new _hx_array(array()));
		$i = 0;
		$min = null;
		{
			$a1 = $a->length;
			$b1 = $b->length;
			if($a1 < $b1) {
				$min = $a1;
			} else {
				$min = $b1;
			}
		}
		while($i < $min) {
			if($a[$i] === $b[$i]) {
				$v = $b[$i];
				$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v), "Arrays_9"), 'execute'));
				unset($v);
			} else {
				$functions->push(Strings::interpolatef($a[$i], $b[$i], $equation));
			}
			$i++;
		}
		while($i < $b->length) {
			$v1 = $b[$i];
			$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v1), "Arrays_10"), 'execute'));
			$i++;
			unset($v1);
		}
		return array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min), "Arrays_11"), 'execute');
	}
	static function interpolateInts($v, $a, $b, $equation = null) {
		return call_user_func_array(Arrays::interpolateIntsf($a, $b, $equation), array($v));
	}
	static function interpolateIntsf($a, $b, $equation = null) {
		$functions = (new _hx_array(array()));
		$i = 0;
		$min = null;
		{
			$a1 = $a->length;
			$b1 = $b->length;
			if($a1 < $b1) {
				$min = $a1;
			} else {
				$min = $b1;
			}
		}
		while($i < $min) {
			if($a[$i] === $b[$i]) {
				$v = $b[$i];
				$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v), "Arrays_12"), 'execute'));
				unset($v);
			} else {
				$functions->push(Ints::interpolatef($a[$i], $b[$i], $equation));
			}
			$i++;
		}
		while($i < $b->length) {
			$v1 = $b[$i];
			$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v1), "Arrays_13"), 'execute'));
			$i++;
			unset($v1);
		}
		return array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min), "Arrays_14"), 'execute');
	}
	static function indexOf($arr, $el) {
		$len = $arr->length;
		{
			$_g = 0;
			while($_g < $len) {
				$i = $_g++;
				if((is_object($_t = $arr[$i]) && !($_t instanceof Enum) ? $_t === $el : $_t == $el)) {
					return $i;
				}
				unset($i,$_t);
			}
		}
		return -1;
	}
	static function every($arr, $f) {
		{
			$_g1 = 0;
			$_g = $arr->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if(!call_user_func_array($f, array($arr[$i], $i))) {
					return false;
				}
				unset($i);
			}
		}
		return true;
	}
	static function each($arr, $f) {
		$_g1 = 0;
		$_g = $arr->length;
		while($_g1 < $_g) {
			$i = $_g1++;
			call_user_func_array($f, array($arr[$i], $i));
			unset($i);
		}
	}
	static function any($arr, $f) {
		return Iterators::any($arr->iterator(), $f);
	}
	static function all($arr, $f) {
		return Iterators::all($arr->iterator(), $f);
	}
	static function random($arr) {
		return $arr[Std::random($arr->length)];
	}
	static function string($arr) {
		return "[" . _hx_string_or_null(Iterators::map($arr->iterator(), array(new _hx_lambda(array(&$arr), "Arrays_15"), 'execute'))->join(", ")) . "]";
	}
	static function last($arr) {
		return $arr[$arr->length - 1];
	}
	static function lastf($arr, $f) {
		$i = $arr->length;
		while(--$i >= 0) {
			if(call_user_func_array($f, array($arr[$i]))) {
				return $arr[$i];
			}
		}
		return null;
	}
	static function first($arr) {
		return $arr[0];
	}
	static function firstf($arr, $f) {
		{
			$_g = 0;
			while($_g < $arr->length) {
				$v = $arr[$_g];
				++$_g;
				if(call_user_func_array($f, array($v))) {
					return $v;
				}
				unset($v);
			}
		}
		return null;
	}
	static function bisect($a, $x, $lo = null, $hi = null) {
		if($lo === null) {
			$lo = 0;
		}
		return Arrays::bisectRight($a, $x, $lo, $hi);
	}
	static function bisectRight($a, $x, $lo = null, $hi = null) {
		if($lo === null) {
			$lo = 0;
		}
		if(null === $hi) {
			$hi = $a->length;
		}
		while($lo < $hi) {
			$mid = $lo + $hi >> 1;
			if($x < $a[$mid]) {
				$hi = $mid;
			} else {
				$lo = $mid + 1;
			}
			unset($mid);
		}
		return $lo;
	}
	static function bisectLeft($a, $x, $lo = null, $hi = null) {
		if($lo === null) {
			$lo = 0;
		}
		if(null === $hi) {
			$hi = $a->length;
		}
		while($lo < $hi) {
			$mid = $lo + $hi >> 1;
			if($a->a[$mid] < $x) {
				$lo = $mid + 1;
			} else {
				$hi = $mid;
			}
			unset($mid);
		}
		return $lo;
	}
	static function nearest($a, $x, $f) {
		$delta = (new _hx_array(array()));
		{
			$_g1 = 0;
			$_g = $a->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$delta->push(_hx_anonymous(array("i" => $i, "v" => Math::abs(call_user_func_array($f, array($a[$i])) - $x))));
				unset($i);
			}
		}
		$delta->sort(array(new _hx_lambda(array(&$a, &$delta, &$f, &$x), "Arrays_16"), 'execute'));
		return $a[_hx_array_get($delta, 0)->i];
	}
	static function compare($a, $b) {
		$v = null;
		if(($v = $a->length - $b->length) !== 0) {
			return $v;
		}
		{
			$_g1 = 0;
			$_g = $a->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if(($v = Dynamics::compare($a[$i], $b[$i])) !== 0) {
					return $v;
				}
				unset($i);
			}
		}
		return 0;
	}
	static function product($a) {
		if($a->length === 0) {
			return (new _hx_array(array()));
		}
		$arr = $a->copy();
		$result = (new _hx_array(array()));
		$temp = null;
		{
			$_g = 0;
			$_g1 = $arr[0];
			while($_g < $_g1->length) {
				$value = $_g1[$_g];
				++$_g;
				$result->push((new _hx_array(array($value))));
				unset($value);
			}
		}
		{
			$_g11 = 1;
			$_g2 = $arr->length;
			while($_g11 < $_g2) {
				$i = $_g11++;
				$temp = (new _hx_array(array()));
				{
					$_g21 = 0;
					while($_g21 < $result->length) {
						$acc = $result[$_g21];
						++$_g21;
						$_g3 = 0;
						$_g4 = $arr[$i];
						while($_g3 < $_g4->length) {
							$value1 = $_g4[$_g3];
							++$_g3;
							$temp->push($acc->copy()->concat((new _hx_array(array($value1)))));
							unset($value1);
						}
						unset($acc,$_g4,$_g3);
					}
					unset($_g21);
				}
				$result = $temp;
				unset($i);
			}
		}
		return $result;
	}
	static function rotate($a) {
		if($a->length === 0) {
			return (new _hx_array(array()));
		}
		$result = (new _hx_array(array()));
		{
			$_g1 = 0;
			$_g = _hx_array_get($a, 0)->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$result[$i] = (new _hx_array(array()));
				unset($i);
			}
		}
		{
			$_g11 = 0;
			$_g2 = $a->length;
			while($_g11 < $_g2) {
				$j = $_g11++;
				$_g3 = 0;
				$_g21 = _hx_array_get($a, 0)->length;
				while($_g3 < $_g21) {
					$i1 = $_g3++;
					$result[$i1][$j] = $a[$j][$i1];
					unset($i1);
				}
				unset($j,$_g3,$_g21);
			}
		}
		return $result;
	}
	static function shuffle($a) {
		$t = Ints::range($a->length, null, null);
		$arr = (new _hx_array(array()));
		while($t->length > 0) {
			$pos = Std::random($t->length);
			$index = $t[$pos];
			$t->splice($pos, 1);
			$arr->push($a[$index]);
			unset($pos,$index);
		}
		return $arr;
	}
	static function scanf($arr, $weightf, $incremental = null) {
		if($incremental === null) {
			$incremental = true;
		}
		$tot = 0.0;
		$weights = (new _hx_array(array()));
		if($incremental) {
			$_g1 = 0;
			$_g = $arr->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$weights[$i] = $tot += call_user_func_array($weightf, array($arr[$i], $i));
				unset($i);
			}
		} else {
			{
				$_g11 = 0;
				$_g2 = $arr->length;
				while($_g11 < $_g2) {
					$i1 = $_g11++;
					$weights[$i1] = call_user_func_array($weightf, array($arr[$i1], $i1));
					unset($i1);
				}
			}
			$tot = $weights[$weights->length - 1];
		}
		$scan = null;
		{
			$scan1 = null;
			$scan1 = array(new _hx_lambda(array(&$arr, &$incremental, &$scan, &$scan1, &$tot, &$weightf, &$weights), "Arrays_17"), 'execute');
			$scan = $scan1;
		}
		return array(new _hx_lambda(array(&$arr, &$incremental, &$scan, &$tot, &$weightf, &$weights), "Arrays_18"), 'execute');
	}
	function __toString() { return 'Arrays'; }
}
function Arrays_0(&$arr, &$f) {
	if(null === $f) {
		return (isset(Dynamics::$compare) ? Dynamics::$compare: array("Dynamics", "compare"));
	} else {
		return $f;
	}
}
function Arrays_1(&$arr, &$f, $v, $_) {
	{
		return $v === null;
	}
}
function Arrays_2(&$culture, &$elipsis, &$format, &$max, &$param, &$params, &$sep, &$v) {
	{
		$arr = $v->copy()->splice(0, $max);
		return Iterators::map($arr->iterator(), array(new _hx_lambda(array(&$arr, &$culture, &$elipsis, &$format, &$max, &$param, &$params, &$sep, &$v), "Arrays_19"), 'execute'));
	}
}
function Arrays_3(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v, $d1, $i1) {
	{
		return Dynamics::format($d1, $params[0], null, null, $culture);
	}
}
function Arrays_4(&$culture, &$format, &$param, &$params, $v) {
	{
		if($v->length === 0) {
			$empty = null;
			if(null === $params[1]) {
				$empty = "[]";
			} else {
				$empty = $params[1];
			}
			return $empty;
		}
		$sep = null;
		if(null === $params[2]) {
			$sep = ", ";
		} else {
			$sep = $params[2];
		}
		$max = null;
		if($params[3] === null) {
			$max = null;
		} else {
			if("" === $params[3]) {
				$max = null;
			} else {
				$max = Std::parseInt($params[3]);
			}
		}
		if(null !== $max && $max < $v->length) {
			$elipsis = null;
			if(null === $params[4]) {
				$elipsis = " ...";
			} else {
				$elipsis = $params[4];
			}
			return _hx_string_or_null(_hx_deref((Arrays_20($culture, $elipsis, $format, $max, $param, $params, $sep, $v)))->join($sep)) . _hx_string_or_null($elipsis);
		} else {
			return Iterators::map($v->iterator(), array(new _hx_lambda(array(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v), "Arrays_21"), 'execute'))->join($sep);
		}
	}
}
function Arrays_5(&$culture, &$f, &$format, &$param, &$params, $v1) {
	{
		return call_user_func_array($f, array($v1->length));
	}
}
function Arrays_6(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v, $_) {
	{
		return $v;
	}
}
function Arrays_7(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v1, $_1) {
	{
		return $v1;
	}
}
function Arrays_8(&$a, &$b, &$equation, &$functions, &$i, &$min, $t) {
	{
		return Iterators::map($functions->iterator(), array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t), "Arrays_22"), 'execute'));
	}
}
function Arrays_9(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v, $_) {
	{
		return $v;
	}
}
function Arrays_10(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v1, $_1) {
	{
		return $v1;
	}
}
function Arrays_11(&$a, &$b, &$equation, &$functions, &$i, &$min, $t) {
	{
		return Iterators::map($functions->iterator(), array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t), "Arrays_23"), 'execute'));
	}
}
function Arrays_12(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v, $_) {
	{
		return $v;
	}
}
function Arrays_13(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v1, $_1) {
	{
		return $v1;
	}
}
function Arrays_14(&$a, &$b, &$equation, &$functions, &$i, &$min, $t) {
	{
		return Iterators::map($functions->iterator(), array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t), "Arrays_24"), 'execute'));
	}
}
function Arrays_15(&$arr, $v, $_) {
	{
		return Dynamics::string($v);
	}
}
function Arrays_16(&$a, &$delta, &$f, &$x, $a1, $b) {
	{
		$a2 = $a1->v;
		$b1 = $b->v;
		if($a2 < $b1) {
			return -1;
		} else {
			if($a2 > $b1) {
				return 1;
			} else {
				return 0;
			}
		}
	}
}
function Arrays_17(&$arr, &$incremental, &$scan, &$scan1, &$tot, &$weightf, &$weights, $v, $start, $end) {
	{
		if($start === $end) {
			return $arr[$start];
		}
		$mid = Math::floor(($end - $start) / 2) + $start;
		$value = $weights[$mid];
		if($v < $value) {
			return call_user_func_array($scan1, array($v, $start, $mid));
		} else {
			return call_user_func_array($scan1, array($v, $mid + 1, $end));
		}
	}
}
function Arrays_18(&$arr, &$incremental, &$scan, &$tot, &$weightf, &$weights, $v1) {
	{
		if($v1 < 0 || $v1 > $tot) {
			return null;
		}
		return call_user_func_array($scan, array($v1, 0, $weights->length - 1));
	}
}
function Arrays_19(&$arr, &$culture, &$elipsis, &$format, &$max, &$param, &$params, &$sep, &$v, $d, $i) {
	{
		return Dynamics::format($d, $params[0], null, null, $culture);
	}
}
function Arrays_20(&$culture, &$elipsis, &$format, &$max, &$param, &$params, &$sep, &$v) {
	{
		$arr = $v->copy()->splice(0, $max);
		return Iterators::map($arr->iterator(), array(new _hx_lambda(array(&$arr, &$culture, &$elipsis, &$format, &$max, &$param, &$params, &$sep, &$v), "Arrays_25"), 'execute'));
	}
}
function Arrays_21(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v, $d1, $i1) {
	{
		return Dynamics::format($d1, $params[0], null, null, $culture);
	}
}
function Arrays_22(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t, $f, $_2) {
	{
		return call_user_func_array($f, array($t));
	}
}
function Arrays_23(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t, $f, $_2) {
	{
		return call_user_func_array($f, array($t));
	}
}
function Arrays_24(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t, $f, $_2) {
	{
		return call_user_func_array($f, array($t));
	}
}
function Arrays_25(&$arr, &$culture, &$elipsis, &$format, &$max, &$param, &$params, &$sep, &$v, $d, $i) {
	{
		return Dynamics::format($d, $params[0], null, null, $culture);
	}
}
