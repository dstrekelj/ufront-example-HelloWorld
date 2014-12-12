<?php

class spadm_Serialized {
	public function __construct($v) {
		if(!php_Boot::$skip_constructor) {
		$this->value = $v;
		$this->pos = 0;
		$this->tabs = 0;
	}}
	public $value;
	public $pos;
	public $buf;
	public $shash;
	public $scount;
	public $scache;
	public $useEnumIndex;
	public $cur;
	public $tabs;
	public function encode() {
		if($this->value === "") {
			return "";
		}
		$p = new hscript_Parser();
		$p->allowJSON = true;
		$e = $p->parse(new haxe_io_StringInput($this->value));
		$this->buf = new StringBuf();
		$this->shash = new haxe_ds_StringMap();
		$this->scount = 0;
		$this->encodeRec($e);
		return $this->buf->b;
	}
	public function getString($e) {
		if($e === null) {
			return null;
		} else {
			switch($e->index) {
			case 0:{
				$v = $e->params[0];
				switch($v->index) {
				case 2:{
					$s = $v->params[0];
					return $s;
				}break;
				default:{
					return null;
				}break;
				}
			}break;
			default:{
				return null;
			}break;
			}
		}
	}
	public function getPath($e) {
		if($e === null) {
			return null;
		}
		switch($e->index) {
		case 0:{
			$v = $e->params[0];
			switch($v->index) {
			case 2:{
				$s = $v->params[0];
				return $s;
			}break;
			default:{
				return null;
			}break;
			}
		}break;
		case 1:{
			$v1 = $e->params[0];
			return $v1;
		}break;
		case 5:{
			$f = $e->params[1];
			$e1 = $e->params[0];
			{
				$path = "." . _hx_string_or_null($f);
				while(true) {
					switch($e1->index) {
					case 1:{
						$i = $e1->params[0];
						return _hx_string_or_null($i) . _hx_string_or_null($path);
					}break;
					case 5:{
						$f1 = $e1->params[1];
						$p = $e1->params[0];
						{
							$path = "." . _hx_string_or_null($f1) . _hx_string_or_null($path);
							$e1 = $p;
						}
					}break;
					default:{
						return null;
					}break;
					}
				}
			}
		}break;
		default:{
		}break;
		}
		return null;
	}
	public function encodeRec($e) {
		switch($e->index) {
		case 0:{
			$v = $e->params[0];
			switch($v->index) {
			case 2:{
				$s = $v->params[0];
				$this->encodeString($s);
			}break;
			case 0:{
				$v1 = $v->params[0];
				{
					if($v1 === 0) {
						$this->buf->add("z");
						return;
					}
					$this->buf->add("i");
					$this->buf->add($v1);
				}
			}break;
			case 1:{
				$v2 = $v->params[0];
				if(Math::isNaN($v2)) {
					$this->buf->add("k");
				} else {
					if(!Math::isFinite($v2)) {
						$this->buf->add((($v2 < 0) ? "m" : "p"));
					} else {
						$this->buf->add("d");
						$this->buf->add($v2);
					}
				}
			}break;
			}
		}break;
		case 7:{
			$es = $e->params[2];
			$op = $e->params[0];
			{
				if($op === "-") {
					switch($es->index) {
					case 0:{
						$v3 = $es->params[0];
						switch($v3->index) {
						case 0:{
							$i = $v3->params[0];
							{
								$this->encodeRec(hscript_Expr::EConst(hscript_Const::CInt(-$i)));
								return;
							}
						}break;
						case 1:{
							$f = $v3->params[0];
							{
								$this->encodeRec(hscript_Expr::EConst(hscript_Const::CFloat(-$f)));
								return;
							}
						}break;
						default:{
						}break;
						}
					}break;
					default:{
					}break;
					}
				}
				throw new HException("Unsupported " . _hx_string_or_null(Type::enumConstructor($e)));
			}
		}break;
		case 1:{
			$v4 = $e->params[0];
			switch($v4) {
			case "null":{
				$this->buf->add("n");
			}break;
			case "true":{
				$this->buf->add("t");
			}break;
			case "false":{
				$this->buf->add("f");
			}break;
			case "NaN":{
				$this->buf->add("k");
			}break;
			case "Inf":{
				$this->buf->add("p");
			}break;
			case "NegInf":{
				$this->buf->add("m");
			}break;
			default:{
				throw new HException("Unknown identifier " . _hx_string_or_null($v4));
			}break;
			}
		}break;
		case 17:{
			$el = $e->params[0];
			{
				$ucount = 0;
				$this->buf->add("a");
				{
					$_g = 0;
					while($_g < $el->length) {
						$e1 = $el[$_g];
						++$_g;
						switch($e1->index) {
						case 1:{
							$i1 = $e1->params[0];
							if($i1 === "null") {
								$ucount++;
								continue 2;
							}
						}break;
						default:{
						}break;
						}
						if($ucount > 0) {
							if($ucount === 1) {
								$this->buf->add("n");
							} else {
								$this->buf->add("u");
								$this->buf->add($ucount);
							}
							$ucount = 0;
						}
						$this->encodeRec($e1);
						unset($e1);
					}
				}
				if($ucount > 0) {
					if($ucount === 1) {
						$this->buf->add("n");
					} else {
						$this->buf->add("u");
						$this->buf->add($ucount);
					}
				}
				$this->buf->add("h");
			}
		}break;
		case 21:{
			$fields = $e->params[0];
			{
				$this->buf->add("o");
				{
					$_g1 = 0;
					while($_g1 < $fields->length) {
						$f1 = $fields[$_g1];
						++$_g1;
						$this->encodeString($f1->name);
						$this->encodeRec($f1->e);
						unset($f1);
					}
				}
				$this->buf->add("g");
			}
		}break;
		case 8:{
			$params = $e->params[1];
			$e2 = $e->params[0];
			{
				switch($e2->index) {
				case 1:{
					$call = $e2->params[0];
					switch($call) {
					case "empty":{
						if($params->length === 0) {
							return;
						}
					}break;
					case "invalid":{
						$str = $this->getString($params[0]);
						if($params->length === 1 && $str !== null) {
							$this->buf->add($str);
							return;
						}
					}break;
					case "list":{
						$this->buf->add("l");
						{
							$_g2 = 0;
							while($_g2 < $params->length) {
								$e3 = $params[$_g2];
								++$_g2;
								$this->encodeRec($e3);
								unset($e3);
							}
						}
						$this->buf->add("h");
						return;
					}break;
					case "date":{
						$str1 = $this->getString($params[0]);
						if($params->length === 1 && $str1 !== null) {
							$d = Date::fromString($str1);
							$this->buf->add("v");
							$this->buf->add($d->toString());
							return;
						}
					}break;
					case "now":{
						if($params->length === 0) {
							$this->buf->add("v");
							$this->buf->add(Date::now());
							return;
						}
					}break;
					case "error":{
						if($params->length === 1) {
							$this->buf->add("x");
							$this->encodeRec($params[0]);
							return;
						}
					}break;
					case "hash":{
						if($params->length === 1) {
							{
								$_g3 = $params[0];
								switch($_g3->index) {
								case 21:{
									$fields1 = $_g3->params[0];
									{
										$this->buf->add("b");
										{
											$_g11 = 0;
											while($_g11 < $fields1->length) {
												$f2 = $fields1[$_g11];
												++$_g11;
												$this->encodeString($f2->name);
												$this->encodeRec($f2->e);
												unset($f2);
											}
										}
										$this->buf->add("h");
										return;
									}
								}break;
								default:{
								}break;
								}
							}
						}
					}break;
					case "inthash":{
						if($params->length === 1) {
							{
								$_g4 = $params[0];
								switch($_g4->index) {
								case 21:{
									$fields2 = $_g4->params[0];
									{
										$this->buf->add("q");
										{
											$_g12 = 0;
											while($_g12 < $fields2->length) {
												$f3 = $fields2[$_g12];
												++$_g12;
												if(!_hx_deref(new EReg("^-?[0-9]+\$", ""))->match($f3->name)) {
													throw new HException("Invalid IntHash key '" . _hx_string_or_null($f3->name) . "'");
												}
												$this->buf->add(":");
												$this->buf->add($f3->name);
												$this->encodeRec($f3->e);
												unset($f3);
											}
										}
										$this->buf->add("h");
										return;
									}
								}break;
								default:{
								}break;
								}
							}
						}
					}break;
					case "bytes":{
						$str2 = $this->getString($params[0]);
						if($params->length === 1 && $str2 !== null) {
							{
								$_g13 = 0;
								$_g5 = strlen($str2);
								while($_g13 < $_g5) {
									$i2 = $_g13++;
									if(_hx_index_of(spadm_Serialized::$BASE64, _hx_char_at($str2, $i2), null) === -1) {
										throw new HException("Invalid Base64 char");
									}
									unset($i2);
								}
							}
							$this->buf->add("s");
							$this->buf->add(strlen($str2));
							$this->buf->add(":");
							$this->buf->add($str2);
							return;
						}
					}break;
					case "indexes":{
						if($params->length === 1) {
							$this->useEnumIndex = true;
							$this->encodeRec($params[0]);
							return;
						}
					}break;
					case "ref":{
						if($params->length === 1) {
							{
								$_g6 = $params[0];
								switch($_g6->index) {
								case 0:{
									$v5 = $_g6->params[0];
									switch($v5->index) {
									case 0:{
										$i3 = $v5->params[0];
										{
											$this->buf->add("r");
											$this->buf->add($i3);
											return;
										}
									}break;
									default:{
									}break;
									}
								}break;
								default:{
								}break;
								}
							}
						}
					}break;
					default:{
						throw new HException("Unsupported call '" . _hx_string_or_null($call) . "'");
					}break;
					}
				}break;
				case 5:{
					$f4 = $e2->params[1];
					$e4 = $e2->params[0];
					{
						$this->encodeEnum($e4, $f4, null, $params);
						return;
					}
				}break;
				case 16:{
					$index = $e2->params[1];
					$e5 = $e2->params[0];
					{
						$this->encodeEnum($e5, null, $index, $params);
						return;
					}
				}break;
				default:{
				}break;
				}
				throw new HException("Unsupported call");
			}
		}break;
		case 5:{
			$f5 = $e->params[1];
			$e6 = $e->params[0];
			$this->encodeEnum($e6, $f5, null, (new _hx_array(array())));
		}break;
		case 16:{
			$index1 = $e->params[1];
			$e7 = $e->params[0];
			$this->encodeEnum($e7, null, $index1, (new _hx_array(array())));
		}break;
		case 18:{
			$params1 = $e->params[1];
			$c = $e->params[0];
			{
				$fields3 = null;
				$cname = null;
				if($c === "class") {
					if($params1->length === 2) {
						$cname = $this->getString($params1[0]);
						{
							$_g7 = $params1[1];
							switch($_g7->index) {
							case 21:{
								$fields4 = $_g7->params[0];
								$fields3 = $fields4;
							}break;
							default:{
								$fields3 = null;
							}break;
							}
						}
					}
				} else {
					if($c === "custom") {
						$cname = $this->getPath($params1[0]);
						if($cname !== null) {
							$this->buf->add("C");
							$this->encodeString($cname);
							{
								$_g14 = 1;
								$_g8 = $params1->length;
								while($_g14 < $_g8) {
									$i4 = $_g14++;
									$this->encodeRec($params1[$i4]);
									unset($i4);
								}
							}
							$this->buf->add("g");
							return;
						}
					} else {
						if($params1->length === 1) {
							$cname = $c;
							{
								$_g9 = $params1[0];
								switch($_g9->index) {
								case 21:{
									$fields5 = $_g9->params[0];
									$fields3 = $fields5;
								}break;
								default:{
									$fields3 = null;
								}break;
								}
							}
						}
					}
				}
				if($cname === null || $fields3 === null) {
					throw new HException("Invalid 'new'");
				}
				$this->buf->add("c");
				$this->encodeString($cname);
				{
					$_g10 = 0;
					while($_g10 < $fields3->length) {
						$f6 = $fields3[$_g10];
						++$_g10;
						$this->encodeString($f6->name);
						$this->encodeRec($f6->e);
						unset($f6);
					}
				}
				$this->buf->add("g");
			}
		}break;
		default:{
			throw new HException("Unsupported " . _hx_string_or_null(Type::enumConstructor($e)));
		}break;
		}
	}
	public function encodeEnum($e, $name = null, $eindex = null, $args) {
		$ename = $this->getPath($e);
		if($ename === null) {
			throw new HException("Invalid enum path");
		}
		$index = null;
		if($eindex !== null) {
			switch($eindex->index) {
			case 0:{
				$c = $eindex->params[0];
				switch($c->index) {
				case 0:{
					$i = $c->params[0];
					$index = $i;
				}break;
				case 2:{
					$s = $c->params[0];
					$name = $s;
				}break;
				default:{
				}break;
				}
			}break;
			default:{
			}break;
			}
			if($index === null && $name === null) {
				throw new HException("Invalid enum index");
			}
		}
		if($name !== null) {
			$e1 = null;
			try {
				$e1 = Type::resolveEnum($ename);
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e2 = $_ex_;
				{
					$e1 = null;
				}
			}
			if($e1 === null) {
				if($this->useEnumIndex) {
					throw new HException("Unknown enum '" . _hx_string_or_null($ename) . "' : use index");
				}
			} else {
				$index = Lambda::indexOf(Type::getEnumConstructs($e1), $name);
				if($index < 0) {
					throw new HException(_hx_string_or_null($name) . " is not part of enum " . _hx_string_or_null($ename) . "(" . _hx_string_or_null(Type::getEnumConstructs($e1)->join(",")) . ")");
				}
				if($this->useEnumIndex) {
					$name = null;
				} else {
					$index = null;
				}
			}
		}
		$this->buf->add((($index !== null) ? "j" : "w"));
		$this->encodeString($ename);
		if($index !== null) {
			$this->buf->add(":");
			$this->buf->add($index);
		} else {
			$this->encodeString($name);
		}
		$this->buf->add(":");
		$this->buf->add($args->length);
		{
			$_g = 0;
			while($_g < $args->length) {
				$a = $args[$_g];
				++$_g;
				$this->encodeRec($a);
				unset($a);
			}
		}
	}
	public function encodeString($s) {
		$x = $this->shash->get($s);
		if($x !== null) {
			$this->buf->add("R");
			$this->buf->add($x);
			return;
		}
		{
			$value = $this->scount++;
			$this->shash->set($s, $value);
		}
		$this->buf->add("y");
		$s = rawurlencode($s);
		$this->buf->add(strlen($s));
		$this->buf->add(":");
		$this->buf->add($s);
	}
	public function quote($s, $r = null) {
		if($r !== null && $r->match($s)) {
			return $s;
		}
		return "'" . _hx_string_or_null(_hx_explode("\x09", _hx_explode("\x0D", _hx_explode("\x0A", _hx_explode("'", _hx_explode("\\", $s)->join("\\\\"))->join("\\'"))->join("\\n"))->join("\\r"))->join("\\t")) . "'";
	}
	public function escape() {
		if($this->value === "") {
			return "empty()";
		}
		$this->buf = new StringBuf();
		$this->scache = new _hx_array(array());
		try {
			$this->loop();
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			if(($e = $_ex_) instanceof spadm__Serialized_Errors){
				$this->pos = -1;
			} else throw $__hx__e;;
		}
		if($this->pos !== strlen($this->value)) {
			return "invalid(" . _hx_string_or_null($this->quote($this->value, null)) . ")";
		}
		$str = $this->buf->b;
		if($this->useEnumIndex) {
			$str = "indexes(" . _hx_string_or_null($str) . ")";
		}
		return $str;
	}
	public function get($pos) {
		return _hx_char_code_at($this->value, $pos);
	}
	public function readDigits() {
		$k = 0;
		$s = false;
		$fpos = $this->pos;
		while(true) {
			$c = _hx_char_code_at($this->value, $this->pos);
			if($c === null) {
				break;
			}
			if($c === 45) {
				if($this->pos !== $fpos) {
					break;
				}
				$s = true;
				$this->pos++;
				continue;
			}
			if($c < 48 || $c > 57) {
				break;
			}
			$k = $k * 10 + ($c - 48);
			$this->pos++;
			unset($c);
		}
		if($s) {
			$k *= -1;
		}
		return $k;
	}
	public function loop() {
		$_g = null;
		{
			$pos = $this->pos++;
			$_g = _hx_char_code_at($this->value, $pos);
		}
		switch($_g) {
		case 110:{
			$this->buf->add(null);
		}break;
		case 105:{
			$this->buf->add($this->readDigits());
		}break;
		case 122:{
			$this->buf->add(0);
		}break;
		case 116:{
			$this->buf->add(true);
		}break;
		case 102:{
			$this->buf->add(false);
		}break;
		case 107:{
			$this->buf->add("NaN");
		}break;
		case 112:{
			$this->buf->add("Inf");
		}break;
		case 109:{
			$this->buf->add("NegInf");
		}break;
		case 100:{
			$p1 = $this->pos;
			while(true) {
				$c = _hx_char_code_at($this->value, $this->pos);
				if($c >= 43 && $c < 58 || $c === 101 || $c === 69) {
					$this->pos++;
				} else {
					break;
				}
				unset($c);
			}
			$this->buf->add(_hx_substr($this->value, $p1, $this->pos - $p1));
		}break;
		case 97:{
			$this->open("[", ", ", null);
			while(true) {
				$c1 = _hx_char_code_at($this->value, $this->pos);
				if($c1 === 104) {
					$this->pos++;
					break;
				}
				if($c1 === 117) {
					$this->pos++;
					{
						$_g2 = 0;
						$_g1 = $this->readDigits() - 1;
						while($_g2 < $_g1) {
							$i = $_g2++;
							$this->buf->add("null");
							$this->next();
							unset($i);
						}
						unset($_g2,$_g1);
					}
					$this->buf->add("null");
				} else {
					$this->loop();
				}
				$this->next();
				unset($c1);
			}
			$this->close("]", null);
		}break;
		case 121:case 82:{
			$this->pos--;
			$this->buf->add($this->quote($this->readString(), null));
		}break;
		case 108:{
			$this->open("list(", ", ", null);
			while(_hx_char_code_at($this->value, $this->pos) !== 104) {
				$this->loop();
				$this->next();
			}
			$this->close(")", null);
			$this->pos++;
		}break;
		case 118:{
			$this->buf->add("date(");
			$this->buf->add($this->quote(_hx_substr($this->value, $this->pos, 19), null));
			$this->buf->add(")");
			$this->pos += 19;
		}break;
		case 120:{
			$this->buf->add("error(");
			$this->loop();
			$this->buf->add(")");
		}break;
		case 111:{
			$this->loopObj(103);
		}break;
		case 98:{
			$this->buf->add("hash(");
			$this->loopObj(104);
			$this->buf->add(")");
		}break;
		case 113:{
			$this->buf->add("inthash(");
			$this->open("{", ", ", " ");
			$c2 = null;
			{
				$pos1 = $this->pos++;
				$c2 = _hx_char_code_at($this->value, $pos1);
			}
			while($c2 === 58) {
				$this->buf->add("'" . _hx_string_rec($this->readDigits(), "") . "'");
				$this->buf->add(" : ");
				$this->loop();
				{
					$pos2 = $this->pos++;
					$c2 = _hx_char_code_at($this->value, $pos2);
					unset($pos2);
				}
				$this->next();
			}
			if($c2 !== 104) {
				throw new HException(spadm__Serialized_Errors::$Invalid);
			}
			$this->close("}", " ");
			$this->buf->add(")");
		}break;
		case 115:{
			$len = $this->readDigits();
			if(spadm_Serialized_0($this, $_g, $len) !== 58 || strlen($this->value) - $this->pos < $len) {
				throw new HException(spadm__Serialized_Errors::$Invalid);
			}
			$this->buf->add("bytes(");
			$this->buf->add($this->quote(_hx_substr($this->value, $this->pos, $len), null));
			$this->buf->add(")");
			$this->pos += $len;
		}break;
		case 119:{
			$this->buf->add($this->quote($this->readString(), spadm_Serialized::$clname));
			$constr = $this->readString();
			if(spadm_Serialized::$ident->match($constr)) {
				$this->buf->add("." . _hx_string_or_null($constr));
			} else {
				$this->buf->add("[" . _hx_string_or_null($this->quote($constr, null)) . "]");
			}
			if(spadm_Serialized_1($this, $_g, $constr) !== 58) {
				throw new HException(spadm__Serialized_Errors::$Invalid);
			}
			$nargs = $this->readDigits();
			if($nargs > 0) {
				$this->buf->add("(");
				{
					$_g11 = 0;
					while($_g11 < $nargs) {
						$i1 = $_g11++;
						if($i1 > 0) {
							$this->buf->add(", ");
						}
						$this->loop();
						unset($i1);
					}
				}
				$this->buf->add(")");
			}
		}break;
		case 106:{
			$cl = $this->readString();
			$this->buf->add($this->quote($cl, spadm_Serialized::$clname));
			if(spadm_Serialized_2($this, $_g, $cl) !== 58) {
				throw new HException(spadm__Serialized_Errors::$Invalid);
			}
			$index = $this->readDigits();
			$e = Type::resolveEnum($cl);
			if($e === null) {
				$this->buf->add("[" . _hx_string_rec($index, "") . "]");
			} else {
				$this->useEnumIndex = true;
				$this->buf->add("." . _hx_string_or_null(_hx_array_get(Type::getEnumConstructs($e), $index)));
			}
			if(spadm_Serialized_3($this, $_g, $cl, $e, $index) !== 58) {
				throw new HException(spadm__Serialized_Errors::$Invalid);
			}
			$nargs1 = $this->readDigits();
			if($nargs1 > 0) {
				$this->buf->add("(");
				{
					$_g12 = 0;
					while($_g12 < $nargs1) {
						$i2 = $_g12++;
						if($i2 > 0) {
							$this->buf->add(", ");
						}
						$this->loop();
						unset($i2);
					}
				}
				$this->buf->add(")");
			}
		}break;
		case 99:{
			$this->buf->add("new ");
			$cl1 = $this->readString();
			if(spadm_Serialized::$clname->match($cl1)) {
				$this->buf->add(_hx_string_or_null($cl1) . "(");
			} else {
				$this->buf->add("class(");
				$this->buf->add($this->quote($cl1, null));
				$this->buf->add(",");
			}
			$this->loopObj(103);
			$this->buf->add(")");
		}break;
		case 67:{
			$this->open("new custom(", ", ", null);
			$this->buf->add($this->quote($this->readString(), spadm_Serialized::$clname));
			$this->next();
			while(_hx_char_code_at($this->value, $this->pos) !== 103) {
				$this->loop();
				$this->next();
			}
			$this->close(")", null);
			$this->pos++;
		}break;
		case 114:{
			$this->buf->add("ref(" . _hx_string_rec($this->readDigits(), "") . ")");
		}break;
		default:{
			throw new HException(spadm__Serialized_Errors::$Invalid);
		}break;
		}
	}
	public function readString() {
		$_g = _hx_char_code_at($this->value, $this->pos++);
		switch($_g) {
		case 121:{
			$len = $this->readDigits();
			if(spadm_Serialized_4($this, $_g, $len) !== 58 || strlen($this->value) - $this->pos < $len) {
				throw new HException(spadm__Serialized_Errors::$Invalid);
			}
			$s = _hx_substr($this->value, $this->pos, $len);
			$this->pos += $len;
			$s = urldecode($s);
			$this->scache->push($s);
			return $s;
		}break;
		case 82:{
			$n = $this->readDigits();
			if($n < 0 || $n >= $this->scache->length) {
				throw new HException("Invalid string reference");
			}
			return $this->scache[$n];
		}break;
		default:{
			throw new HException(spadm__Serialized_Errors::$Invalid);
		}break;
		}
	}
	public function loopObj($eof) {
		$this->open("{", ", ", " ");
		while(true) {
			if($this->pos >= strlen($this->value)) {
				throw new HException(spadm__Serialized_Errors::$Invalid);
			}
			if(_hx_char_code_at($this->value, $this->pos) === $eof) {
				break;
			}
			$this->buf->add($this->quote($this->readString(), spadm_Serialized::$ident));
			$this->buf->add(" : ");
			$this->loop();
			$this->next();
		}
		$this->close("}", " ");
		$this->pos++;
	}
	public function open($str, $sep, $prefix = null) {
		$this->buf->add($str);
		$this->tabs++;
		$this->cur = _hx_anonymous(array("old" => $this->cur, "sep" => $sep, "prefix" => $prefix, "lines" => (new _hx_array(array())), "buf" => $this->buf, "totalSize" => 0, "maxSize" => 0));
		$this->buf = new StringBuf();
	}
	public function next() {
		$line = $this->buf->b;
		if(strlen($line) > $this->cur->maxSize) {
			$this->cur->maxSize = strlen($line);
		}
		$this->cur->totalSize += strlen($line);
		$this->cur->lines->push($line);
		$this->buf = new StringBuf();
	}
	public function close($end, $postfix = null) {
		$this->buf = $this->cur->buf;
		$t = "\x0A";
		{
			$_g1 = 0;
			$_g = $this->tabs - 1;
			while($_g1 < $_g) {
				$i = $_g1++;
				$t .= _hx_string_or_null(spadm_Serialized::$IDENT);
				unset($i);
			}
		}
		if(strlen($t) + $this->cur->totalSize > 80 && $this->cur->maxSize > 10) {
			$first = true;
			{
				$_g2 = 0;
				$_g11 = $this->cur->lines;
				while($_g2 < $_g11->length) {
					$line = $_g11[$_g2];
					++$_g2;
					if($first) {
						$first = false;
					} else {
						$this->buf->add($this->cur->sep);
					}
					$this->buf->add(_hx_string_or_null($t) . _hx_string_or_null(spadm_Serialized::$IDENT) . _hx_string_or_null($line));
					unset($line);
				}
			}
			$this->buf->add($t);
			$this->buf->add($end);
		} else {
			if($this->cur->prefix !== null && $this->cur->lines->length > 0) {
				$this->buf->add($this->cur->prefix);
			}
			$first1 = true;
			{
				$_g3 = 0;
				$_g12 = $this->cur->lines;
				while($_g3 < $_g12->length) {
					$line1 = $_g12[$_g3];
					++$_g3;
					if($first1) {
						$first1 = false;
					} else {
						$this->buf->add($this->cur->sep);
					}
					$this->buf->add($line1);
					unset($line1);
				}
			}
			if(!$first1 && $postfix !== null) {
				$this->buf->add($postfix);
			}
			$this->buf->add($end);
		}
		$this->cur = $this->cur->old;
		$this->tabs--;
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
	static $IDENT = "  ";
	static $ident;
	static $clname;
	static $BASE64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789%:";
	function __toString() { return 'spadm.Serialized'; }
}
spadm_Serialized::$ident = new EReg("^[A-Za-z_][A-Za-z0-9_]*\$", "");
spadm_Serialized::$clname = new EReg("^[A-Za-z_][A-Z.a-z0-9_]*\$", "");
function spadm_Serialized_0(&$__hx__this, &$_g, &$len) {
	{
		$pos3 = $__hx__this->pos++;
		return _hx_char_code_at($__hx__this->value, $pos3);
	}
}
function spadm_Serialized_1(&$__hx__this, &$_g, &$constr) {
	{
		$pos4 = $__hx__this->pos++;
		return _hx_char_code_at($__hx__this->value, $pos4);
	}
}
function spadm_Serialized_2(&$__hx__this, &$_g, &$cl) {
	{
		$pos5 = $__hx__this->pos++;
		return _hx_char_code_at($__hx__this->value, $pos5);
	}
}
function spadm_Serialized_3(&$__hx__this, &$_g, &$cl, &$e, &$index) {
	{
		$pos6 = $__hx__this->pos++;
		return _hx_char_code_at($__hx__this->value, $pos6);
	}
}
function spadm_Serialized_4(&$__hx__this, &$_g, &$len) {
	{
		$pos = $__hx__this->pos++;
		return _hx_char_code_at($__hx__this->value, $pos);
	}
}
