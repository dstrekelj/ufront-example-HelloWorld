<?php

class hscript_Parser {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->uid = 0;
		$this->line = 1;
		$this->opChars = "+*/-=!><&|^%~";
		$this->identChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_";
		$priorities = (new _hx_array(array((new _hx_array(array("%"))), (new _hx_array(array("*", "/"))), (new _hx_array(array("+", "-"))), (new _hx_array(array("<<", ">>", ">>>"))), (new _hx_array(array("|", "&", "^"))), (new _hx_array(array("==", "!=", ">", "<", ">=", "<="))), (new _hx_array(array("..."))), (new _hx_array(array("&&"))), (new _hx_array(array("||"))), (new _hx_array(array("=", "+=", "-=", "*=", "/=", "%=", "<<=", ">>=", ">>>=", "|=", "&=", "^="))))));
		$this->opPriority = new haxe_ds_StringMap();
		$this->opRightAssoc = new haxe_ds_StringMap();
		$this->unops = new haxe_ds_StringMap();
		{
			$_g1 = 0;
			$_g = $priorities->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$_g2 = 0;
				$_g3 = $priorities[$i];
				while($_g2 < $_g3->length) {
					$x = $_g3[$_g2];
					++$_g2;
					$this->opPriority->set($x, $i);
					if($i === 9) {
						$this->opRightAssoc->set($x, true);
					}
					unset($x);
				}
				unset($i,$_g3,$_g2);
			}
		}
		{
			$_g4 = 0;
			$_g11 = (new _hx_array(array("!", "++", "--", "-", "~")));
			while($_g4 < $_g11->length) {
				$x1 = $_g11[$_g4];
				++$_g4;
				$this->unops->set($x1, $x1 === "++" || $x1 === "--");
				unset($x1);
			}
		}
	}}
	public $line;
	public $opChars;
	public $identChars;
	public $opPriority;
	public $opRightAssoc;
	public $unops;
	public $allowJSON;
	public $allowTypes;
	public $input;
	public $char;
	public $ops;
	public $idents;
	public $uid;
	public $tokens;
	public function error($err, $pmin, $pmax) {
		throw new HException($err);
	}
	public function invalidChar($c) {
		$err = hscript_Error::EInvalidChar($c);
		throw new HException($err);
	}
	public function parseString($s) {
		$this->line = 1;
		$this->uid = 0;
		return $this->parse(new haxe_io_StringInput($s));
	}
	public function parse($s) {
		$this->tokens = new haxe_ds_GenericStack();
		$this->char = -1;
		$this->input = $s;
		$this->ops = new _hx_array(array());
		$this->idents = new _hx_array(array());
		{
			$_g1 = 0;
			$_g = strlen($this->opChars);
			while($_g1 < $_g) {
				$i = $_g1++;
				$this->ops[_hx_char_code_at($this->opChars, $i)] = true;
				unset($i);
			}
		}
		{
			$_g11 = 0;
			$_g2 = strlen($this->identChars);
			while($_g11 < $_g2) {
				$i1 = $_g11++;
				$this->idents[_hx_char_code_at($this->identChars, $i1)] = true;
				unset($i1);
			}
		}
		$a = new _hx_array(array());
		while(true) {
			$tk = $this->token();
			if($tk === hscript_Token::$TEof) {
				break;
			}
			{
				$_this = $this->tokens;
				$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
				unset($_this);
			}
			$a->push($this->parseFullExpr());
			unset($tk);
		}
		if($a->length === 1) {
			return $a[0];
		} else {
			$e = hscript_Expr::EBlock($a);
			return $e;
		}
	}
	public function unexpected($tk) {
		{
			$err = hscript_Error::EUnexpected($this->tokenString($tk));
			throw new HException($err);
		}
		return null;
	}
	public function push($tk) {
		$_this = $this->tokens;
		$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
	}
	public function ensure($tk) {
		$t = $this->token();
		if($t !== $tk) {
			$this->unexpected($t);
		}
	}
	public function expr($e) {
		return $e;
	}
	public function pmin($e) {
		return 0;
	}
	public function pmax($e) {
		return 0;
	}
	public function mk($e, $pmin = null, $pmax = null) {
		return $e;
	}
	public function isBlock($e) {
		switch($e->index) {
		case 4:case 21:case 23:{
			return true;
		}break;
		case 14:{
			$e1 = $e->params[1];
			return $this->isBlock($e1);
		}break;
		case 2:{
			$e2 = $e->params[2];
			return $e2 !== null && $this->isBlock($e2);
		}break;
		case 9:{
			$e21 = $e->params[2];
			$e11 = $e->params[1];
			if($e21 !== null) {
				return $this->isBlock($e21);
			} else {
				return $this->isBlock($e11);
			}
		}break;
		case 6:{
			$e3 = $e->params[2];
			return $this->isBlock($e3);
		}break;
		case 7:{
			$e4 = $e->params[2];
			$prefix = $e->params[1];
			return !$prefix && $this->isBlock($e4);
		}break;
		case 10:{
			$e5 = $e->params[1];
			return $this->isBlock($e5);
		}break;
		case 11:{
			$e6 = $e->params[2];
			return $this->isBlock($e6);
		}break;
		case 15:{
			$e7 = $e->params[0];
			return $e7 !== null && $this->isBlock($e7);
		}break;
		default:{
			return false;
		}break;
		}
	}
	public function parseFullExpr() {
		$e = $this->parseExpr();
		$tk = $this->token();
		if($tk !== hscript_Token::$TSemicolon && $tk !== hscript_Token::$TEof) {
			if($this->isBlock($e)) {
				$_this = $this->tokens;
				$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
			} else {
				$this->unexpected($tk);
			}
		}
		return $e;
	}
	public function parseObject($p1) {
		$fl = new _hx_array(array());
		while(true) {
			$tk = $this->token();
			$id = null;
			switch($tk->index) {
			case 2:{
				$i = $tk->params[0];
				$id = $i;
			}break;
			case 1:{
				$c = $tk->params[0];
				{
					if(!$this->allowJSON) {
						$this->unexpected($tk);
					}
					switch($c->index) {
					case 2:{
						$s = $c->params[0];
						$id = $s;
					}break;
					default:{
						$this->unexpected($tk);
					}break;
					}
				}
			}break;
			case 7:{
				break 2;
			}break;
			default:{
				$this->unexpected($tk);
			}break;
			}
			{
				$t = $this->token();
				if($t !== hscript_Token::$TDoubleDot) {
					$this->unexpected($t);
				}
				unset($t);
			}
			$fl->push(_hx_anonymous(array("name" => $id, "e" => $this->parseExpr())));
			$tk = $this->token();
			switch($tk->index) {
			case 7:{
				break 2;
			}break;
			case 9:{
			}break;
			default:{
				$this->unexpected($tk);
			}break;
			}
			unset($tk,$id);
		}
		return $this->parseExprNext(hscript_Parser_0($this, $fl, $p1));
	}
	public function parseExpr() {
		$tk = $this->token();
		switch($tk->index) {
		case 2:{
			$id = $tk->params[0];
			{
				$e = $this->parseStructure($id);
				if($e === null) {
					$e1 = hscript_Expr::EIdent($id);
					$e = $e1;
				}
				return $this->parseExprNext($e);
			}
		}break;
		case 1:{
			$c = $tk->params[0];
			return $this->parseExprNext(hscript_Parser_1($this, $c, $tk));
		}break;
		case 4:{
			$e3 = $this->parseExpr();
			{
				$t = $this->token();
				if($t !== hscript_Token::$TPClose) {
					$this->unexpected($t);
				}
			}
			return $this->parseExprNext(hscript_Parser_2($this, $e3, $tk));
		}break;
		case 6:{
			$tk = $this->token();
			switch($tk->index) {
			case 7:{
				return $this->parseExprNext(hscript_Parser_3($this, $tk));
			}break;
			case 2:{
				$tk2 = $this->token();
				{
					$_this = $this->tokens;
					$_this->head = new haxe_ds_GenericCell($tk2, $_this->head);
				}
				{
					$_this1 = $this->tokens;
					$_this1->head = new haxe_ds_GenericCell($tk, $_this1->head);
				}
				switch($tk2->index) {
				case 14:{
					return $this->parseExprNext($this->parseObject(0));
				}break;
				default:{
				}break;
				}
			}break;
			case 1:{
				$c1 = $tk->params[0];
				if($this->allowJSON) {
					switch($c1->index) {
					case 2:{
						$tk21 = $this->token();
						{
							$_this2 = $this->tokens;
							$_this2->head = new haxe_ds_GenericCell($tk21, $_this2->head);
						}
						{
							$_this3 = $this->tokens;
							$_this3->head = new haxe_ds_GenericCell($tk, $_this3->head);
						}
						switch($tk21->index) {
						case 14:{
							return $this->parseExprNext($this->parseObject(0));
						}break;
						default:{
						}break;
						}
					}break;
					default:{
						$_this4 = $this->tokens;
						$_this4->head = new haxe_ds_GenericCell($tk, $_this4->head);
					}break;
					}
				} else {
					$_this5 = $this->tokens;
					$_this5->head = new haxe_ds_GenericCell($tk, $_this5->head);
				}
			}break;
			default:{
				$_this6 = $this->tokens;
				$_this6->head = new haxe_ds_GenericCell($tk, $_this6->head);
			}break;
			}
			$a = new _hx_array(array());
			while(true) {
				$a->push($this->parseFullExpr());
				$tk = $this->token();
				if($tk === hscript_Token::$TBrClose) {
					break;
				}
				{
					$_this7 = $this->tokens;
					$_this7->head = new haxe_ds_GenericCell($tk, $_this7->head);
					unset($_this7);
				}
			}
			{
				$e6 = hscript_Expr::EBlock($a);
				return $e6;
			}
		}break;
		case 3:{
			$op = $tk->params[0];
			{
				if($this->unops->exists($op)) {
					return $this->makeUnop($op, $this->parseExpr());
				}
				return $this->unexpected($tk);
			}
		}break;
		case 11:{
			$a1 = new _hx_array(array());
			$tk = $this->token();
			while($tk !== hscript_Token::$TBkClose) {
				{
					$_this8 = $this->tokens;
					$_this8->head = new haxe_ds_GenericCell($tk, $_this8->head);
					unset($_this8);
				}
				$a1->push($this->parseExpr());
				$tk = $this->token();
				if($tk === hscript_Token::$TComma) {
					$tk = $this->token();
				}
			}
			if($a1->length === 1) {
				{
					$_g = $a1[0];
					switch($_g->index) {
					case 11:case 10:{
						$tmp = "__a_" . _hx_string_rec($this->uid++, "");
						$e7 = null;
						{
							$e8 = hscript_Expr::EBlock((new _hx_array(array(hscript_Parser_4($this, $_g, $a1, $e7, $tk, $tmp), $this->mapCompr($tmp, $a1[0]), hscript_Parser_5($this, $_g, $a1, $e7, $tk, $tmp)))));
							$e7 = $e8;
						}
						return $this->parseExprNext($e7);
					}break;
					default:{
					}break;
					}
				}
			}
			return $this->parseExprNext(hscript_Parser_6($this, $a1, $tk));
		}break;
		default:{
			return $this->unexpected($tk);
		}break;
		}
	}
	public function mapCompr($tmp, $e) {
		$edef = null;
		switch($e->index) {
		case 11:{
			$e2 = $e->params[2];
			$it = $e->params[1];
			$v = $e->params[0];
			$edef = hscript_Expr::EFor($v, $it, $this->mapCompr($tmp, $e2));
		}break;
		case 10:{
			$e21 = $e->params[1];
			$cond = $e->params[0];
			$edef = hscript_Expr::EWhile($cond, $this->mapCompr($tmp, $e21));
		}break;
		case 9:{
			$e22 = $e->params[2];
			$e1 = $e->params[1];
			$cond1 = $e->params[0];
			if($e22 === null) {
				$edef = hscript_Expr::EIf($cond1, $this->mapCompr($tmp, $e1), null);
			} else {
				$edef = hscript_Expr::ECall(hscript_Parser_7($this, $cond1, $e, $e1, $e22, $edef, $tmp), (new _hx_array(array($e))));
			}
		}break;
		case 4:{
			switch($e->params[0]->length) {
			case 1:{
				$e5 = $e->params[0][0];
				$edef = hscript_Expr::EBlock((new _hx_array(array($this->mapCompr($tmp, $e5)))));
			}break;
			default:{
				$edef = hscript_Expr::ECall(hscript_Parser_8($this, $e, $edef, $tmp), (new _hx_array(array($e))));
			}break;
			}
		}break;
		case 3:{
			$e23 = $e->params[0];
			$edef = hscript_Expr::EParent($this->mapCompr($tmp, $e23));
		}break;
		default:{
			$edef = hscript_Expr::ECall(hscript_Parser_9($this, $e, $edef, $tmp), (new _hx_array(array($e))));
		}break;
		}
		return $edef;
	}
	public function makeUnop($op, $e) {
		switch($e->index) {
		case 6:{
			$e2 = $e->params[2];
			$e1 = $e->params[1];
			$bop = $e->params[0];
			{
				$e3 = hscript_Expr::EBinop($bop, $this->makeUnop($op, $e1), $e2);
				return $e3;
			}
		}break;
		case 22:{
			$e31 = $e->params[2];
			$e21 = $e->params[1];
			$e11 = $e->params[0];
			{
				$e4 = hscript_Expr::ETernary($this->makeUnop($op, $e11), $e21, $e31);
				return $e4;
			}
		}break;
		default:{
			$e5 = hscript_Expr::EUnop($op, true, $e);
			return $e5;
		}break;
		}
	}
	public function makeBinop($op, $e1, $e) {
		switch($e->index) {
		case 6:{
			$e3 = $e->params[2];
			$e2 = $e->params[1];
			$op2 = $e->params[0];
			if($this->opPriority->get($op) <= $this->opPriority->get($op2) && !$this->opRightAssoc->exists($op)) {
				$e4 = hscript_Expr::EBinop($op2, $this->makeBinop($op, $e1, $e2), $e3);
				return $e4;
			} else {
				$e5 = hscript_Expr::EBinop($op, $e1, $e);
				return $e5;
			}
		}break;
		case 22:{
			$e41 = $e->params[2];
			$e31 = $e->params[1];
			$e21 = $e->params[0];
			if($this->opRightAssoc->exists($op)) {
				$e6 = hscript_Expr::EBinop($op, $e1, $e);
				return $e6;
			} else {
				$e7 = hscript_Expr::ETernary($this->makeBinop($op, $e1, $e21), $e31, $e41);
				return $e7;
			}
		}break;
		default:{
			$e8 = hscript_Expr::EBinop($op, $e1, $e);
			return $e8;
		}break;
		}
	}
	public function parseStructure($id) {
		switch($id) {
		case "if":{
			$cond = $this->parseExpr();
			$e1 = $this->parseExpr();
			$e2 = null;
			$semic = false;
			$tk = $this->token();
			if($tk === hscript_Token::$TSemicolon) {
				$semic = true;
				$tk = $this->token();
			}
			if(Type::enumEq($tk, hscript_Token::TId("else"))) {
				$e2 = $this->parseExpr();
			} else {
				{
					$_this = $this->tokens;
					$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
				}
				if($semic) {
					$_this1 = $this->tokens;
					$_this1->head = new haxe_ds_GenericCell(hscript_Token::$TSemicolon, $_this1->head);
				}
			}
			{
				$e = hscript_Expr::EIf($cond, $e1, $e2);
				return $e;
			}
		}break;
		case "var":{
			$tk1 = $this->token();
			$ident = null;
			switch($tk1->index) {
			case 2:{
				$id1 = $tk1->params[0];
				$ident = $id1;
			}break;
			default:{
				$this->unexpected($tk1);
			}break;
			}
			$tk1 = $this->token();
			$t = null;
			if($tk1 === hscript_Token::$TDoubleDot && $this->allowTypes) {
				$t = $this->parseType();
				$tk1 = $this->token();
			}
			$e3 = null;
			if(Type::enumEq($tk1, hscript_Token::TOp("="))) {
				$e3 = $this->parseExpr();
			} else {
				$_this2 = $this->tokens;
				$_this2->head = new haxe_ds_GenericCell($tk1, $_this2->head);
			}
			{
				$e4 = hscript_Expr::EVar($ident, $t, $e3);
				return $e4;
			}
		}break;
		case "while":{
			$econd = $this->parseExpr();
			$e5 = $this->parseExpr();
			{
				$e6 = hscript_Expr::EWhile($econd, $e5);
				return $e6;
			}
		}break;
		case "for":{
			{
				$t1 = $this->token();
				if($t1 !== hscript_Token::$TPOpen) {
					$this->unexpected($t1);
				}
			}
			$tk2 = $this->token();
			$vname = null;
			switch($tk2->index) {
			case 2:{
				$id2 = $tk2->params[0];
				$vname = $id2;
			}break;
			default:{
				$this->unexpected($tk2);
			}break;
			}
			$tk2 = $this->token();
			if(!Type::enumEq($tk2, hscript_Token::TId("in"))) {
				$this->unexpected($tk2);
			}
			$eiter = $this->parseExpr();
			{
				$t2 = $this->token();
				if($t2 !== hscript_Token::$TPClose) {
					$this->unexpected($t2);
				}
			}
			$e7 = $this->parseExpr();
			{
				$e8 = hscript_Expr::EFor($vname, $eiter, $e7);
				return $e8;
			}
		}break;
		case "break":{
			return hscript_Expr::$EBreak;
		}break;
		case "continue":{
			return hscript_Expr::$EContinue;
		}break;
		case "else":{
			return $this->unexpected(hscript_Token::TId($id));
		}break;
		case "function":{
			$tk3 = $this->token();
			$name = null;
			switch($tk3->index) {
			case 2:{
				$id3 = $tk3->params[0];
				$name = $id3;
			}break;
			default:{
				$_this3 = $this->tokens;
				$_this3->head = new haxe_ds_GenericCell($tk3, $_this3->head);
			}break;
			}
			{
				$t3 = $this->token();
				if($t3 !== hscript_Token::$TPOpen) {
					$this->unexpected($t3);
				}
			}
			$args = new _hx_array(array());
			$tk3 = $this->token();
			if($tk3 !== hscript_Token::$TPClose) {
				$done = false;
				while(!$done) {
					$name1 = null;
					$opt = false;
					switch($tk3->index) {
					case 13:{
						$opt = true;
						$tk3 = $this->token();
					}break;
					default:{
					}break;
					}
					switch($tk3->index) {
					case 2:{
						$id4 = $tk3->params[0];
						$name1 = $id4;
					}break;
					default:{
						$this->unexpected($tk3);
					}break;
					}
					$tk3 = $this->token();
					$arg = _hx_anonymous(array("name" => $name1));
					$args->push($arg);
					if($opt) {
						$arg->opt = true;
					}
					if($tk3 === hscript_Token::$TDoubleDot && $this->allowTypes) {
						$arg->t = $this->parseType();
						$tk3 = $this->token();
					}
					switch($tk3->index) {
					case 9:{
						$tk3 = $this->token();
					}break;
					case 5:{
						$done = true;
					}break;
					default:{
						$this->unexpected($tk3);
					}break;
					}
					unset($opt,$name1,$arg);
				}
			}
			$ret = null;
			if($this->allowTypes) {
				$tk3 = $this->token();
				if($tk3 !== hscript_Token::$TDoubleDot) {
					$_this4 = $this->tokens;
					$_this4->head = new haxe_ds_GenericCell($tk3, $_this4->head);
				} else {
					$ret = $this->parseType();
				}
			}
			$body = $this->parseExpr();
			{
				$e9 = hscript_Expr::EFunction($args, $body, $name, $ret);
				return $e9;
			}
		}break;
		case "return":{
			$tk4 = $this->token();
			{
				$_this5 = $this->tokens;
				$_this5->head = new haxe_ds_GenericCell($tk4, $_this5->head);
			}
			$e10 = null;
			if($tk4 === hscript_Token::$TSemicolon) {
				$e10 = null;
			} else {
				$e10 = $this->parseExpr();
			}
			{
				$e11 = hscript_Expr::EReturn($e10);
				return $e11;
			}
		}break;
		case "new":{
			$a = new _hx_array(array());
			$tk5 = $this->token();
			switch($tk5->index) {
			case 2:{
				$id5 = $tk5->params[0];
				$a->push($id5);
			}break;
			default:{
				$this->unexpected($tk5);
			}break;
			}
			$next = true;
			while($next) {
				$tk5 = $this->token();
				switch($tk5->index) {
				case 8:{
					$tk5 = $this->token();
					switch($tk5->index) {
					case 2:{
						$id6 = $tk5->params[0];
						$a->push($id6);
					}break;
					default:{
						$this->unexpected($tk5);
					}break;
					}
				}break;
				case 4:{
					$next = false;
				}break;
				default:{
					$this->unexpected($tk5);
				}break;
				}
			}
			$args1 = $this->parseExprList(hscript_Token::$TPClose);
			{
				$e12 = hscript_Expr::ENew($a->join("."), $args1);
				return $e12;
			}
		}break;
		case "throw":{
			$e13 = $this->parseExpr();
			{
				$e14 = hscript_Expr::EThrow($e13);
				return $e14;
			}
		}break;
		case "try":{
			$e15 = $this->parseExpr();
			$tk6 = $this->token();
			if(!Type::enumEq($tk6, hscript_Token::TId("catch"))) {
				$this->unexpected($tk6);
			}
			{
				$t4 = $this->token();
				if($t4 !== hscript_Token::$TPOpen) {
					$this->unexpected($t4);
				}
			}
			$tk6 = $this->token();
			$vname1 = null;
			switch($tk6->index) {
			case 2:{
				$id7 = $tk6->params[0];
				$vname1 = $id7;
			}break;
			default:{
				$vname1 = $this->unexpected($tk6);
			}break;
			}
			{
				$t5 = $this->token();
				if($t5 !== hscript_Token::$TDoubleDot) {
					$this->unexpected($t5);
				}
			}
			$t6 = null;
			if($this->allowTypes) {
				$t6 = $this->parseType();
			} else {
				$tk6 = $this->token();
				if(!Type::enumEq($tk6, hscript_Token::TId("Dynamic"))) {
					$this->unexpected($tk6);
				}
			}
			{
				$t7 = $this->token();
				if($t7 !== hscript_Token::$TPClose) {
					$this->unexpected($t7);
				}
			}
			$ec = $this->parseExpr();
			{
				$e16 = hscript_Expr::ETry($e15, $vname1, $t6, $ec);
				return $e16;
			}
		}break;
		case "switch":{
			$e17 = $this->parseExpr();
			$def = null;
			$cases = (new _hx_array(array()));
			{
				$t8 = $this->token();
				if($t8 !== hscript_Token::$TBrOpen) {
					$this->unexpected($t8);
				}
			}
			while(true) {
				$tk7 = $this->token();
				switch($tk7->index) {
				case 2:{
					switch($tk7->params[0]) {
					case "case":{
						$c = _hx_anonymous(array("values" => (new _hx_array(array())), "expr" => null));
						$cases->push($c);
						while(true) {
							$e18 = $this->parseExpr();
							$c->values->push($e18);
							$tk7 = $this->token();
							switch($tk7->index) {
							case 9:{
							}break;
							case 14:{
								break 2;
							}break;
							default:{
								$this->unexpected($tk7);
							}break;
							}
							unset($e18);
						}
						$exprs = (new _hx_array(array()));
						while(true) {
							$tk7 = $this->token();
							{
								$_this6 = $this->tokens;
								$_this6->head = new haxe_ds_GenericCell($tk7, $_this6->head);
								unset($_this6);
							}
							switch($tk7->index) {
							case 2:{
								switch($tk7->params[0]) {
								case "case":case "default":{
									break 3;
								}break;
								default:{
									$exprs->push($this->parseFullExpr());
								}break;
								}
							}break;
							case 7:{
								break 2;
							}break;
							default:{
								$exprs->push($this->parseFullExpr());
							}break;
							}
						}
						if($exprs->length === 1) {
							$c->expr = $exprs[0];
						} else {
							if($exprs->length === 0) {
								$e19 = hscript_Expr::EBlock((new _hx_array(array())));
								$c->expr = $e19;
							} else {
								$e20 = hscript_Expr::EBlock($exprs);
								$c->expr = $e20;
							}
						}
					}break;
					case "default":{
						if($def !== null) {
							$this->unexpected($tk7);
						}
						{
							$t9 = $this->token();
							if($t9 !== hscript_Token::$TDoubleDot) {
								$this->unexpected($t9);
							}
						}
						$exprs1 = (new _hx_array(array()));
						while(true) {
							$tk7 = $this->token();
							{
								$_this7 = $this->tokens;
								$_this7->head = new haxe_ds_GenericCell($tk7, $_this7->head);
								unset($_this7);
							}
							switch($tk7->index) {
							case 2:{
								switch($tk7->params[0]) {
								case "case":case "default":{
									break 3;
								}break;
								default:{
									$exprs1->push($this->parseFullExpr());
								}break;
								}
							}break;
							case 7:{
								break 2;
							}break;
							default:{
								$exprs1->push($this->parseFullExpr());
							}break;
							}
						}
						if($exprs1->length === 1) {
							$def = $exprs1[0];
						} else {
							if($exprs1->length === 0) {
								$e21 = hscript_Expr::EBlock((new _hx_array(array())));
								$def = $e21;
							} else {
								$e22 = hscript_Expr::EBlock($exprs1);
								$def = $e22;
							}
						}
					}break;
					default:{
						$this->unexpected($tk7);
					}break;
					}
				}break;
				case 7:{
					break 2;
				}break;
				default:{
					$this->unexpected($tk7);
				}break;
				}
				unset($tk7);
			}
			{
				$e23 = hscript_Expr::ESwitch($e17, $cases, $def);
				return $e23;
			}
		}break;
		default:{
			return null;
		}break;
		}
	}
	public function parseExprNext($e1) {
		$tk = $this->token();
		switch($tk->index) {
		case 3:{
			$op = $tk->params[0];
			{
				if($this->unops->get($op)) {
					if($this->isBlock($e1) || hscript_Parser_10($this, $e1, $op, $tk)) {
						{
							$_this = $this->tokens;
							$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
						}
						return $e1;
					}
					return $this->parseExprNext(hscript_Parser_11($this, $e1, $op, $tk));
				}
				return $this->makeBinop($op, $e1, $this->parseExpr());
			}
		}break;
		case 8:{
			$tk = $this->token();
			$field = null;
			switch($tk->index) {
			case 2:{
				$id = $tk->params[0];
				$field = $id;
			}break;
			default:{
				$this->unexpected($tk);
			}break;
			}
			return $this->parseExprNext(hscript_Parser_12($this, $e1, $field, $tk));
		}break;
		case 4:{
			return $this->parseExprNext(hscript_Parser_13($this, $e1, $tk));
		}break;
		case 11:{
			$e21 = $this->parseExpr();
			{
				$t = $this->token();
				if($t !== hscript_Token::$TBkClose) {
					$this->unexpected($t);
				}
			}
			return $this->parseExprNext(hscript_Parser_14($this, $e1, $e21, $tk));
		}break;
		case 13:{
			$e22 = $this->parseExpr();
			{
				$t1 = $this->token();
				if($t1 !== hscript_Token::$TDoubleDot) {
					$this->unexpected($t1);
				}
			}
			$e31 = $this->parseExpr();
			{
				$e5 = hscript_Expr::ETernary($e1, $e22, $e31);
				return $e5;
			}
		}break;
		default:{
			{
				$_this1 = $this->tokens;
				$_this1->head = new haxe_ds_GenericCell($tk, $_this1->head);
			}
			return $e1;
		}break;
		}
	}
	public function parseType() {
		$t = $this->token();
		switch($t->index) {
		case 2:{
			$v = $t->params[0];
			{
				$path = (new _hx_array(array($v)));
				while(true) {
					$t = $this->token();
					if($t !== hscript_Token::$TDot) {
						break;
					}
					$t = $this->token();
					switch($t->index) {
					case 2:{
						$v1 = $t->params[0];
						$path->push($v1);
					}break;
					default:{
						$this->unexpected($t);
					}break;
					}
				}
				$params = null;
				switch($t->index) {
				case 3:{
					$op = $t->params[0];
					if($op === "<") {
						$params = (new _hx_array(array()));
						while(true) {
							$params->push($this->parseType());
							$t = $this->token();
							switch($t->index) {
							case 9:{
								continue 2;
							}break;
							case 3:{
								$op1 = $t->params[0];
								if($op1 === ">") {
									break 2;
								}
							}break;
							default:{
							}break;
							}
							$this->unexpected($t);
						}
					}
				}break;
				default:{
					$_this = $this->tokens;
					$_this->head = new haxe_ds_GenericCell($t, $_this->head);
				}break;
				}
				return $this->parseTypeNext(hscript_CType::CTPath($path, $params));
			}
		}break;
		case 4:{
			$t1 = $this->parseType();
			{
				$t2 = $this->token();
				if($t2 !== hscript_Token::$TPClose) {
					$this->unexpected($t2);
				}
			}
			return $this->parseTypeNext(hscript_CType::CTParent($t1));
		}break;
		case 6:{
			$fields = (new _hx_array(array()));
			while(true) {
				$t = $this->token();
				switch($t->index) {
				case 7:{
					break 2;
				}break;
				case 2:{
					$name = $t->params[0];
					{
						{
							$t3 = $this->token();
							if($t3 !== hscript_Token::$TDoubleDot) {
								$this->unexpected($t3);
							}
						}
						$fields->push(_hx_anonymous(array("name" => $name, "t" => $this->parseType())));
						$t = $this->token();
						switch($t->index) {
						case 9:{
						}break;
						case 7:{
							break 3;
						}break;
						default:{
							$this->unexpected($t);
						}break;
						}
					}
				}break;
				default:{
					$this->unexpected($t);
				}break;
				}
			}
			return $this->parseTypeNext(hscript_CType::CTAnon($fields));
		}break;
		default:{
			return $this->unexpected($t);
		}break;
		}
	}
	public function parseTypeNext($t) {
		$tk = $this->token();
		switch($tk->index) {
		case 3:{
			$op = $tk->params[0];
			if($op !== "->") {
				{
					$_this = $this->tokens;
					$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
				}
				return $t;
			}
		}break;
		default:{
			{
				$_this1 = $this->tokens;
				$_this1->head = new haxe_ds_GenericCell($tk, $_this1->head);
			}
			return $t;
		}break;
		}
		$t2 = $this->parseType();
		switch($t2->index) {
		case 1:{
			$args = $t2->params[0];
			{
				$args->unshift($t);
				return $t2;
			}
		}break;
		default:{
			return hscript_CType::CTFun((new _hx_array(array($t))), $t2);
		}break;
		}
	}
	public function parseExprList($etk) {
		$args = new _hx_array(array());
		$tk = $this->token();
		if($tk === $etk) {
			return $args;
		}
		{
			$_this = $this->tokens;
			$_this->head = new haxe_ds_GenericCell($tk, $_this->head);
		}
		while(true) {
			$args->push($this->parseExpr());
			$tk = $this->token();
			switch($tk->index) {
			case 9:{
			}break;
			default:{
				if($tk === $etk) {
					break 2;
				}
				$this->unexpected($tk);
			}break;
			}
		}
		return $args;
	}
	public function incPos() {
	}
	public function readChar() {
		try {
			return $this->input->readByte();
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				return 0;
			}
		}
	}
	public function readString($until) {
		$c = 0;
		$b = new haxe_io_BytesOutput();
		$esc = false;
		$old = $this->line;
		$s = $this->input;
		while(true) {
			try {
				$c = $s->readByte();
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e = $_ex_;
				{
					$this->line = $old;
					throw new HException(hscript_Error::$EUnterminatedString);
				}
			}
			if($esc) {
				$esc = false;
				switch($c) {
				case 110:{
					$b->writeByte(10);
				}break;
				case 114:{
					$b->writeByte(13);
				}break;
				case 116:{
					$b->writeByte(9);
				}break;
				case 39:case 34:case 92:{
					$b->writeByte($c);
				}break;
				case 47:{
					if($this->allowJSON) {
						$b->writeByte($c);
					} else {
						$this->invalidChar($c);
					}
				}break;
				case 117:{
					if(!$this->allowJSON) {
						throw new HException($this->invalidChar($c));
					}
					$code = null;
					try {
						$code = $s->readString(4);
					}catch(Exception $__hx__e) {
						$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
						$e1 = $_ex_;
						{
							$this->line = $old;
							throw new HException(hscript_Error::$EUnterminatedString);
						}
					}
					$k = 0;
					{
						$_g = 0;
						while($_g < 4) {
							$i = $_g++;
							$k <<= 4;
							$char = _hx_char_code_at($code, $i);
							switch($char) {
							case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
								$k += $char - 48;
							}break;
							case 65:case 66:case 67:case 68:case 69:case 70:{
								$k += $char - 55;
							}break;
							case 97:case 98:case 99:case 100:case 101:case 102:{
								$k += $char - 87;
							}break;
							default:{
								$this->invalidChar($char);
							}break;
							}
							unset($i,$char);
						}
					}
					if($k <= 127) {
						$b->writeByte($k);
					} else {
						if($k <= 2047) {
							$b->writeByte(192 | $k >> 6);
							$b->writeByte(128 | $k & 63);
						} else {
							$b->writeByte(224 | $k >> 12);
							$b->writeByte(128 | $k >> 6 & 63);
							$b->writeByte(128 | $k & 63);
						}
					}
				}break;
				default:{
					$this->invalidChar($c);
				}break;
				}
			} else {
				if($c === 92) {
					$esc = true;
				} else {
					if($c === $until) {
						break;
					} else {
						if($c === 10) {
							$this->line++;
						}
						$b->writeByte($c);
					}
				}
			}
			unset($e);
		}
		return $b->getBytes()->toString();
	}
	public function token() {
		if(!($this->tokens->head === null)) {
			$_this = $this->tokens;
			$k = $_this->head;
			if($k === null) {
				return null;
			} else {
				$_this->head = $k->next;
				return $k->elt;
			}
		}
		$char = null;
		if($this->char < 0) {
			$char = $this->readChar();
		} else {
			$char = $this->char;
			$this->char = -1;
		}
		while(true) {
			switch($char) {
			case 0:{
				return hscript_Token::$TEof;
			}break;
			case 32:case 9:case 13:{
			}break;
			case 10:{
				$this->line++;
			}break;
			case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
				$n = ($char - 48) * 1.0;
				$exp = 0.;
				while(true) {
					$char = $this->readChar();
					$exp *= 10;
					switch($char) {
					case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
						$n = $n * 10 + ($char - 48);
					}break;
					case 46:{
						if($exp > 0) {
							if(_hx_equal($exp, 10) && $this->readChar() === 46) {
								{
									$tk = hscript_Token::TOp("...");
									{
										$_this1 = $this->tokens;
										$_this1->head = new haxe_ds_GenericCell($tk, $_this1->head);
									}
								}
								$i = Std::int($n);
								return hscript_Token::TConst(((_hx_equal($i, $n)) ? hscript_Const::CInt($i) : hscript_Const::CFloat($n)));
							}
							$this->invalidChar($char);
						}
						$exp = 1.;
					}break;
					case 120:{
						if($n > 0 || $exp > 0) {
							$this->invalidChar($char);
						}
						$n1 = 0;
						while(true) {
							$char = $this->readChar();
							switch($char) {
							case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
								$n1 = ($n1 << 4) + $char - 48;
							}break;
							case 65:case 66:case 67:case 68:case 69:case 70:{
								$n1 = ($n1 << 4) + ($char - 55);
							}break;
							case 97:case 98:case 99:case 100:case 101:case 102:{
								$n1 = ($n1 << 4) + ($char - 87);
							}break;
							default:{
								$this->char = $char;
								return hscript_Token::TConst(hscript_Const::CInt($n1));
							}break;
							}
						}
					}break;
					default:{
						$this->char = $char;
						$i1 = Std::int($n);
						return hscript_Token::TConst((($exp > 0) ? hscript_Const::CFloat($n * 10 / $exp) : ((_hx_equal($i1, $n)) ? hscript_Const::CInt($i1) : hscript_Const::CFloat($n))));
					}break;
					}
				}
			}break;
			case 59:{
				return hscript_Token::$TSemicolon;
			}break;
			case 40:{
				return hscript_Token::$TPOpen;
			}break;
			case 41:{
				return hscript_Token::$TPClose;
			}break;
			case 44:{
				return hscript_Token::$TComma;
			}break;
			case 46:{
				$char = $this->readChar();
				switch($char) {
				case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
					$n2 = $char - 48;
					$exp1 = 1;
					while(true) {
						$char = $this->readChar();
						$exp1 *= 10;
						switch($char) {
						case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
							$n2 = $n2 * 10 + ($char - 48);
						}break;
						default:{
							$this->char = $char;
							return hscript_Token::TConst(hscript_Const::CFloat($n2 / $exp1));
						}break;
						}
					}
				}break;
				case 46:{
					$char = $this->readChar();
					if($char !== 46) {
						$this->invalidChar($char);
					}
					return hscript_Token::TOp("...");
				}break;
				default:{
					$this->char = $char;
					return hscript_Token::$TDot;
				}break;
				}
			}break;
			case 123:{
				return hscript_Token::$TBrOpen;
			}break;
			case 125:{
				return hscript_Token::$TBrClose;
			}break;
			case 91:{
				return hscript_Token::$TBkOpen;
			}break;
			case 93:{
				return hscript_Token::$TBkClose;
			}break;
			case 39:{
				return hscript_Token::TConst(hscript_Const::CString($this->readString(39)));
			}break;
			case 34:{
				return hscript_Token::TConst(hscript_Const::CString($this->readString(34)));
			}break;
			case 63:{
				return hscript_Token::$TQuestion;
			}break;
			case 58:{
				return hscript_Token::$TDoubleDot;
			}break;
			default:{
				if($this->ops[$char]) {
					$op = chr($char);
					while(true) {
						$char = $this->readChar();
						if(!$this->ops[$char]) {
							if(_hx_char_code_at($op, 0) === 47) {
								return $this->tokenComment($op, $char);
							}
							$this->char = $char;
							return hscript_Token::TOp($op);
						}
						$op .= _hx_string_or_null(chr($char));
					}
				}
				if($this->idents[$char]) {
					$id = chr($char);
					while(true) {
						$char = $this->readChar();
						if(!$this->idents[$char]) {
							$this->char = $char;
							return hscript_Token::TId($id);
						}
						$id .= _hx_string_or_null(chr($char));
					}
				}
				$this->invalidChar($char);
			}break;
			}
			$char = $this->readChar();
		}
		return null;
	}
	public function tokenComment($op, $char) {
		$c = _hx_char_code_at($op, 1);
		$s = $this->input;
		if($c === 47) {
			try {
				while($char !== 10 && $char !== 13) {
					$char = $s->readByte();
				}
				$this->char = $char;
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e = $_ex_;
				{
				}
			}
			return $this->token();
		}
		if($c === 42) {
			$old = $this->line;
			try {
				while(true) {
					while($char !== 42) {
						if($char === 10) {
							$this->line++;
						}
						$char = $s->readByte();
					}
					$char = $s->readByte();
					if($char === 47) {
						break;
					}
				}
			}catch(Exception $__hx__e) {
				$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
				$e1 = $_ex_;
				{
					$this->line = $old;
					throw new HException(hscript_Error::$EUnterminatedComment);
				}
			}
			return $this->token();
		}
		$this->char = $char;
		return hscript_Token::TOp($op);
	}
	public function constString($c) {
		switch($c->index) {
		case 0:{
			$v = $c->params[0];
			return Std::string($v);
		}break;
		case 1:{
			$f = $c->params[0];
			return Std::string($f);
		}break;
		case 2:{
			$s = $c->params[0];
			return $s;
		}break;
		}
	}
	public function tokenString($t) {
		switch($t->index) {
		case 0:{
			return "<eof>";
		}break;
		case 1:{
			$c = $t->params[0];
			return $this->constString($c);
		}break;
		case 2:{
			$s = $t->params[0];
			return $s;
		}break;
		case 3:{
			$s1 = $t->params[0];
			return $s1;
		}break;
		case 4:{
			return "(";
		}break;
		case 5:{
			return ")";
		}break;
		case 6:{
			return "{";
		}break;
		case 7:{
			return "}";
		}break;
		case 8:{
			return ".";
		}break;
		case 9:{
			return ",";
		}break;
		case 10:{
			return ";";
		}break;
		case 11:{
			return "[";
		}break;
		case 12:{
			return "]";
		}break;
		case 13:{
			return "?";
		}break;
		case 14:{
			return ":";
		}break;
		}
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
	static $p1 = 0;
	static $readPos = 0;
	static $tokenMin = 0;
	static $tokenMax = 0;
	function __toString() { return 'hscript.Parser'; }
}
function hscript_Parser_0(&$__hx__this, &$fl, &$p1) {
	{
		$e = hscript_Expr::EObject($fl);
		return $e;
	}
}
function hscript_Parser_1(&$__hx__this, &$c, &$tk) {
	{
		$e2 = hscript_Expr::EConst($c);
		return $e2;
	}
}
function hscript_Parser_2(&$__hx__this, &$e3, &$tk) {
	{
		$e4 = hscript_Expr::EParent($e3);
		return $e4;
	}
}
function hscript_Parser_3(&$__hx__this, &$tk) {
	{
		$e5 = hscript_Expr::EObject((new _hx_array(array())));
		return $e5;
	}
}
function hscript_Parser_4(&$__hx__this, &$_g, &$a1, &$e7, &$tk, &$tmp) {
	{
		$e9 = hscript_Expr::EVar($tmp, null, hscript_Parser_15($_g, $a1, $e7, $tk, $tmp));
		return $e9;
	}
}
function hscript_Parser_5(&$__hx__this, &$_g, &$a1, &$e7, &$tk, &$tmp) {
	{
		$e11 = hscript_Expr::EIdent($tmp);
		return $e11;
	}
}
function hscript_Parser_6(&$__hx__this, &$a1, &$tk) {
	{
		$e12 = hscript_Expr::EArrayDecl($a1);
		return $e12;
	}
}
function hscript_Parser_7(&$__hx__this, &$cond1, &$e, &$e1, &$e22, &$edef, &$tmp) {
	{
		$e3 = hscript_Expr::EField(hscript_Parser_16($cond1, $e, $e1, $e22, $edef, $tmp), "push");
		return $e3;
	}
}
function hscript_Parser_8(&$__hx__this, &$e, &$edef, &$tmp) {
	{
		$e3 = hscript_Expr::EField(hscript_Parser_17($e, $edef, $tmp), "push");
		return $e3;
	}
}
function hscript_Parser_9(&$__hx__this, &$e, &$edef, &$tmp) {
	{
		$e3 = hscript_Expr::EField(hscript_Parser_18($e, $edef, $tmp), "push");
		return $e3;
	}
}
function hscript_Parser_10(&$__hx__this, &$e1, &$op, &$tk) {
	switch($e1->index) {
	case 3:{
		return true;
	}break;
	default:{
		return false;
	}break;
	}
}
function hscript_Parser_11(&$__hx__this, &$e1, &$op, &$tk) {
	{
		$e = hscript_Expr::EUnop($op, false, $e1);
		return $e;
	}
}
function hscript_Parser_12(&$__hx__this, &$e1, &$field, &$tk) {
	{
		$e2 = hscript_Expr::EField($e1, $field);
		return $e2;
	}
}
function hscript_Parser_13(&$__hx__this, &$e1, &$tk) {
	{
		$e3 = hscript_Expr::ECall($e1, $__hx__this->parseExprList(hscript_Token::$TPClose));
		return $e3;
	}
}
function hscript_Parser_14(&$__hx__this, &$e1, &$e21, &$tk) {
	{
		$e4 = hscript_Expr::EArray($e1, $e21);
		return $e4;
	}
}
function hscript_Parser_15(&$_g, &$a1, &$e7, &$tk, &$tmp) {
	{
		$e10 = hscript_Expr::EArrayDecl((new _hx_array(array())));
		return $e10;
	}
}
function hscript_Parser_16(&$cond1, &$e, &$e1, &$e22, &$edef, &$tmp) {
	{
		$e4 = hscript_Expr::EIdent($tmp);
		return $e4;
	}
}
function hscript_Parser_17(&$e, &$edef, &$tmp) {
	{
		$e4 = hscript_Expr::EIdent($tmp);
		return $e4;
	}
}
function hscript_Parser_18(&$e, &$edef, &$tmp) {
	{
		$e4 = hscript_Expr::EIdent($tmp);
		return $e4;
	}
}
