<?php

class spadm_TableInfos {
	public function __construct($cname) {
		if(!php_Boot::$skip_constructor) {
		$this->hfields = new haxe_ds_StringMap();
		$this->fields = new HList();
		$this->nulls = new haxe_ds_StringMap();
		$this->cl = Type::resolveClass("db." . _hx_string_or_null($cname));
		if($this->cl === null) {
			$this->cl = Type::resolveClass($cname);
		} else {
			$cname = "db." . _hx_string_or_null($cname);
		}
		if($this->cl === null) {
			throw new HException("Class not found : " . _hx_string_or_null($cname));
		}
		$this->manager = $this->cl->manager;
		if($this->manager === null) {
			throw new HException("No static manager for " . _hx_string_or_null($cname));
		}
		$this->className = $cname;
		if(_hx_substr($this->className, 0, 3) === "db.") {
			$this->className = _hx_substr($this->className, 3, null);
		}
		$a = _hx_explode(".", $cname);
		$this->name = $a->pop();
		$this->processClass();
	}}
	public $primary;
	public $cl;
	public $name;
	public $className;
	public $hfields;
	public $fields;
	public $nulls;
	public $relations;
	public $indexes;
	public $manager;
	public function processClass() {
		$rtti = haxe_rtti_Meta::getType($this->cl)->rtti;
		if($rtti === null) {
			throw new HException("Class " . _hx_string_or_null($this->name) . " does not have RTTI");
		}
		$infos = haxe_Unserializer::run($rtti[0]);
		$this->name = $infos->name;
		$this->primary = Lambda::hlist($infos->key);
		{
			$_g = 0;
			$_g1 = $infos->fields;
			while($_g < $_g1->length) {
				$f = $_g1[$_g];
				++$_g;
				$this->fields->add(_hx_anonymous(array("name" => $f->name, "type" => $f->t)));
				$this->hfields->set($f->name, $f->t);
				if($f->isNull) {
					$this->nulls->set($f->name, true);
				}
				unset($f);
			}
		}
		$this->relations = new _hx_array(array());
		{
			$_g2 = 0;
			$_g11 = $infos->relations;
			while($_g2 < $_g11->length) {
				$r = $_g11[$_g2];
				++$_g2;
				$t = Type::resolveClass($r->type);
				if($t === null) {
					throw new HException("Missing type " . _hx_string_or_null($r->type) . " for relation " . _hx_string_or_null($this->name) . "." . _hx_string_or_null($r->prop));
				}
				$manager = Reflect::field($t, "manager");
				if($manager === null) {
					throw new HException(_hx_string_or_null($r->type) . " does not have a static field manager");
				}
				$this->relations->push(_hx_anonymous(array("prop" => $r->prop, "key" => $r->key, "lock" => $r->lock, "manager" => $manager, "className" => Type::getClassName($manager->dbClass()), "cascade" => $r->cascade)));
				unset($t,$r,$manager);
			}
		}
		$this->indexes = new HList();
		{
			$_g3 = 0;
			$_g12 = $infos->indexes;
			while($_g3 < $_g12->length) {
				$i = $_g12[$_g3];
				++$_g3;
				$this->indexes->push(_hx_anonymous(array("keys" => Lambda::hlist($i->keys), "unique" => $i->unique)));
				unset($i);
			}
		}
	}
	public function escape($name) {
		$m = $this->manager;
		return $m->quoteField($name);
	}
	public function isRelationActive($r) {
		return true;
	}
	public function createRequest($full) {
		$str = "CREATE TABLE " . _hx_string_or_null($this->escape($this->name)) . " (\x0A";
		$keys = $this->fields->iterator();
		$__hx__it = $keys;
		while($__hx__it->hasNext()) {
			$f = $__hx__it->next();
			$str .= _hx_string_or_null($this->escape($f->name)) . " " . _hx_string_or_null($this->fieldInfos($f));
			if($keys->hasNext()) {
				$str .= ",";
			}
			$str .= "\x0A";
		}
		if($this->primary !== null) {
			$str .= ", PRIMARY KEY (" . _hx_string_or_null($this->primary->map((isset($this->escape) ? $this->escape: array($this, "escape")))->join(",")) . ")\x0A";
		}
		if($full) {
			{
				$_g = 0;
				$_g1 = $this->relations;
				while($_g < $_g1->length) {
					$r = $_g1[$_g];
					++$_g;
					if($this->isRelationActive($r)) {
						$str .= ", " . _hx_string_or_null($this->relationInfos($r));
					}
					unset($r);
				}
			}
			if(null == $this->indexes) throw new HException('null iterable');
			$__hx__it = $this->indexes->iterator();
			while($__hx__it->hasNext()) {
				$i = $__hx__it->next();
				$str .= ", " . _hx_string_or_null(((($i->unique) ? "UNIQUE " : ""))) . "KEY " . _hx_string_or_null($this->escape(_hx_string_or_null($this->name) . "_" . _hx_string_or_null($i->keys->join("_")))) . "(" . _hx_string_or_null($i->keys->map((isset($this->escape) ? $this->escape: array($this, "escape")))->join(",")) . ")\x0A";
			}
		}
		$str .= ")";
		if(spadm_TableInfos::$ENGINE !== null) {
			$str .= " ENGINE=" . _hx_string_or_null(spadm_TableInfos::$ENGINE);
		}
		return $str;
	}
	public function relationInfos($r) {
		if($r->manager->table_keys->length !== 1) {
			throw new HException("Relation on a multiple-keys table");
		}
		$rq = "CONSTRAINT " . _hx_string_or_null($this->escape(_hx_string_or_null($this->name) . "_" . _hx_string_or_null($r->prop))) . " FOREIGN KEY (" . _hx_string_or_null($this->escape($r->key)) . ") REFERENCES " . _hx_string_or_null($this->escape($r->manager->table_name)) . "(" . _hx_string_or_null($this->escape($r->manager->table_keys[0])) . ") ";
		$rq .= "ON DELETE " . _hx_string_or_null(((($this->nulls->get($r->key) && $r->cascade !== true) ? "SET NULL" : "CASCADE"))) . "\x0A";
		return $rq;
	}
	public function fieldInfos($f) {
		return _hx_string_or_null(spadm_TableInfos_0($this, $f)) . _hx_string_or_null(((($this->nulls->exists($f->name)) ? "" : " NOT NULL")));
	}
	public function dropRequest() {
		return "DROP TABLE " . _hx_string_or_null($this->escape($this->name));
	}
	public function truncateRequest() {
		return "TRUNCATE TABLE " . _hx_string_or_null($this->escape($this->name));
	}
	public function descriptionRequest() {
		return "SHOW CREATE TABLE " . _hx_string_or_null($this->escape($this->name));
	}
	public function existsRequest() {
		return "SELECT * FROM " . _hx_string_or_null($this->escape($this->name)) . " LIMIT 0";
	}
	public function addFieldRequest($fname) {
		$ftype = $this->hfields->get($fname);
		if($ftype === null) {
			throw new HException("No field " . _hx_string_or_null($fname));
		}
		$rq = "ALTER TABLE " . _hx_string_or_null($this->escape($this->name)) . " ADD ";
		return _hx_string_or_null($rq) . _hx_string_or_null($this->escape($fname)) . " " . _hx_string_or_null($this->fieldInfos(_hx_anonymous(array("name" => $fname, "type" => $ftype))));
	}
	public function removeFieldRequest($fname) {
		return "ALTER TABLE " . _hx_string_or_null($this->escape($this->name)) . " DROP " . _hx_string_or_null($this->escape($fname));
	}
	public function renameFieldRequest($old, $newname) {
		$ftype = $this->hfields->get($newname);
		if($ftype === null) {
			throw new HException("No field " . _hx_string_or_null($newname));
		}
		$rq = "ALTER TABLE " . _hx_string_or_null($this->escape($this->name)) . " CHANGE " . _hx_string_or_null($this->escape($old)) . " ";
		return _hx_string_or_null($rq) . _hx_string_or_null($this->escape($newname)) . " " . _hx_string_or_null($this->fieldInfos(_hx_anonymous(array("name" => $newname, "type" => $ftype))));
	}
	public function updateFieldRequest($fname) {
		$ftype = $this->hfields->get($fname);
		if($ftype === null) {
			throw new HException("No field " . _hx_string_or_null($fname));
		}
		$rq = "ALTER TABLE " . _hx_string_or_null($this->escape($this->name)) . " MODIFY ";
		return _hx_string_or_null($rq) . _hx_string_or_null($this->escape($fname)) . " " . _hx_string_or_null($this->fieldInfos(_hx_anonymous(array("name" => $fname, "type" => $ftype))));
	}
	public function addRelationRequest($key, $prop) {
		{
			$_g = 0;
			$_g1 = $this->relations;
			while($_g < $_g1->length) {
				$r = $_g1[$_g];
				++$_g;
				if($r->key === $key && $r->prop === $prop) {
					return "ALTER TABLE " . _hx_string_or_null($this->escape($this->name)) . " ADD " . _hx_string_or_null($this->relationInfos($r));
				}
				unset($r);
			}
		}
		throw new HException("No such relation : " . _hx_string_or_null($prop) . "(" . _hx_string_or_null($key) . ")");
	}
	public function deleteRelationRequest($rel) {
		return "ALTER TABLE " . _hx_string_or_null($this->escape($this->name)) . " DROP FOREIGN KEY " . _hx_string_or_null($this->escape($rel));
	}
	public function indexName($idx) {
		return _hx_string_or_null($this->name) . "_" . _hx_string_or_null($idx->join("_"));
	}
	public function addIndexRequest($idx, $unique) {
		$eidx = new _hx_array(array());
		{
			$_g = 0;
			while($_g < $idx->length) {
				$i = $idx[$_g];
				++$_g;
				$k = $this->escape($i);
				$f = $this->hfields->get($i);
				if($f !== null) {
					switch($f->index) {
					case 13:case 14:case 15:case 16:case 17:case 18:{
						$k .= "(4)";
					}break;
					default:{
					}break;
					}
				}
				$eidx->push($k);
				unset($k,$i,$f);
			}
		}
		return "ALTER TABLE " . _hx_string_or_null($this->escape($this->name)) . " ADD " . _hx_string_or_null(((($unique) ? "UNIQUE " : ""))) . "INDEX " . _hx_string_or_null($this->escape($this->indexName($idx))) . "(" . _hx_string_or_null($eidx->join(",")) . ")";
	}
	public function deleteIndexRequest($idx) {
		return "ALTER TABLE " . _hx_string_or_null($this->escape($this->name)) . " DROP INDEX " . _hx_string_or_null($this->escape($idx));
	}
	public function updateFields($o, $fields) {
		$me = $this;
		$s = new StringBuf();
		$s->add("UPDATE ");
		$s->add($this->escape($this->name));
		$s->add(" SET ");
		$first = true;
		if(null == $fields) throw new HException('null iterable');
		$__hx__it = $fields->iterator();
		while($__hx__it->hasNext()) {
			$f = $__hx__it->next();
			if($first) {
				$first = false;
			} else {
				$s->add(", ");
			}
			$s->add($this->escape($f->name));
			$s->add(" = ");
			sys_db_Manager::$cnx->addValue($s, $f->value);
		}
		$s->add(" WHERE ");
		$m = $this->manager;
		$m->addKeys($s, $o);
		return $s->b;
	}
	public function identifier($o) {
		if($this->primary === null) {
			throw new HException("No primary key");
		}
		return $this->primary->map(array(new _hx_lambda(array(&$o), "spadm_TableInfos_1"), 'execute'))->join("@");
	}
	public function fromIdentifier($id) {
		$ids = _hx_explode("@", $id);
		if($this->primary === null) {
			throw new HException("No primary key");
		}
		if($ids->length !== $this->primary->length) {
			throw new HException("Invalid identifier");
		}
		$keys = _hx_anonymous(array());
		if(null == $this->primary) throw new HException('null iterable');
		$__hx__it = $this->primary->iterator();
		while($__hx__it->hasNext()) {
			$p = $__hx__it->next();
			$value = $this->makeNativeValue($this->hfields->get($p), _hx_explode("~", $ids->shift())->join("."));
			$keys->{$p} = $value;
			unset($value);
		}
		return $this->manager->unsafeGetWithKeys($keys, null);
	}
	public function makeNativeValue($t, $v) {
		switch($t->index) {
		case 1:case 3:case 0:case 2:case 20:case 23:case 24:{
			return Std::parseInt($v);
		}break;
		case 25:case 26:case 27:case 29:case 28:{
			return Std::parseInt($v);
		}break;
		case 7:case 6:case 5:case 4:{
			return Std::parseFloat($v);
		}break;
		case 10:case 11:case 12:{
			return Date::fromString($v);
		}break;
		case 8:{
			return $v === "true";
		}break;
		case 15:case 9:case 14:case 13:case 18:case 16:case 17:case 21:case 22:case 19:{
			return $v;
		}break;
		case 30:{
			return $v;
		}break;
		case 31:{
			return $v;
		}break;
		case 33:case 32:{
			throw new HException("assert");
		}break;
		}
	}
	public function fromSearch($params, $order, $pos, $count) {
		$rop = new EReg("^([<>]=?)(.+)\$", "");
		$cond = "TRUE";
		$m = $this->manager;
		if(null == $params) throw new HException('null iterable');
		$__hx__it = $params->keys();
		while($__hx__it->hasNext()) {
			$p = $__hx__it->next();
			$f = $this->hfields->get($p);
			$v = $params->get($p);
			if($f === null) {
				continue;
			}
			$cond .= " AND " . _hx_string_or_null($this->escape($p));
			if($v === null || $v === "NULL") {
				$cond .= " IS NULL";
			} else {
				switch($f->index) {
				case 20:{
					$cond .= " = " . _hx_string_rec(spadm_TableInfos_2($this, $cond, $count, $f, $m, $order, $p, $params, $pos, $rop, $v), "");
				}break;
				case 9:case 13:case 14:case 15:{
					$cond .= " LIKE " . _hx_string_or_null($m->quote($v));
				}break;
				case 8:{
					$cond .= " = " . _hx_string_rec(((($v === "true") ? 1 : 0)), "");
				}break;
				case 0:case 2:case 1:case 3:case 6:case 7:case 10:case 11:case 5:case 4:{
					if($rop->match($v)) {
						$cond .= " " . _hx_string_or_null($rop->matched(1)) . " " . _hx_string_or_null($m->quote($rop->matched(2)));
					} else {
						$cond .= " = " . _hx_string_or_null($m->quote($v));
					}
				}break;
				default:{
					$cond .= " = " . _hx_string_or_null($m->quote($v));
				}break;
				}
			}
			unset($v,$f);
		}
		if($order !== null) {
			if(_hx_char_at($order, 0) === "-") {
				$cond .= " ORDER BY " . _hx_string_or_null($this->escape(_hx_substr($order, 1, null))) . " DESC";
			} else {
				$cond .= " ORDER BY " . _hx_string_or_null($this->escape($order));
			}
		}
		$sql = "SELECT * FROM " . _hx_string_or_null($this->escape($this->name)) . " WHERE " . _hx_string_or_null($cond) . " LIMIT " . _hx_string_rec($pos, "") . "," . _hx_string_rec($count, "");
		return $this->manager->unsafeObjects($sql, false);
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
	static $ENGINE = "InnoDB";
	static $OLD_COMPAT = false;
	static function unescape($field) {
		if(strlen($field) > 1 && _hx_char_at($field, 0) === "`" && _hx_char_at($field, strlen($field) - 1) === "`") {
			return _hx_substr($field, 1, strlen($field) - 2);
		}
		return $field;
	}
	static function countRequest($m, $max) {
		return "SELECT " . _hx_string_or_null($m->quoteField($m->table_keys[0])) . " FROM " . _hx_string_or_null($m->quoteField($m->table_name)) . " LIMIT " . _hx_string_rec($max, "");
	}
	static function fromTypeDescription($desc) {
		$fdesc = _hx_explode(" ", strtoupper($desc));
		$ftype = $fdesc->shift();
		$tparam = new EReg("^([A-Za-z]+)\\(([0-9]+)\\)\$", "");
		$param = null;
		if($tparam->match($ftype)) {
			$ftype = $tparam->matched(1);
			$param = Std::parseInt($tparam->matched(2));
		}
		$nullable = true;
		$t = null;
		switch($ftype) {
		case "VARCHAR":case "CHAR":{
			if($param === null) {
				$t = null;
			} else {
				$t = sys_db_RecordType::DString($param);
			}
		}break;
		case "INT":{
			if($param === 11 && $fdesc->remove("AUTO_INCREMENT")) {
				$t = sys_db_RecordType::$DId;
			} else {
				if($param === 10 && $fdesc->remove("UNSIGNED")) {
					if($fdesc->remove("AUTO_INCREMENT")) {
						$t = sys_db_RecordType::$DUId;
					} else {
						$t = sys_db_RecordType::$DUInt;
					}
				} else {
					if($param === 11) {
						$t = sys_db_RecordType::$DInt;
					} else {
						$t = null;
					}
				}
			}
		}break;
		case "BIGINT":{
			if($fdesc->remove("AUTO_INCREMENT")) {
				$t = sys_db_RecordType::$DBigId;
			} else {
				$t = sys_db_RecordType::$DBigInt;
			}
		}break;
		case "DOUBLE":{
			$t = sys_db_RecordType::$DFloat;
		}break;
		case "FLOAT":{
			$t = sys_db_RecordType::$DSingle;
		}break;
		case "DATE":{
			$t = sys_db_RecordType::$DDate;
		}break;
		case "DATETIME":{
			$t = sys_db_RecordType::$DDateTime;
		}break;
		case "TIMESTAMP":{
			$t = sys_db_RecordType::$DTimeStamp;
		}break;
		case "TINYTEXT":{
			$t = sys_db_RecordType::$DTinyText;
		}break;
		case "TEXT":{
			$t = sys_db_RecordType::$DSmallText;
		}break;
		case "MEDIUMTEXT":{
			$t = sys_db_RecordType::$DText;
		}break;
		case "BLOB":{
			$t = sys_db_RecordType::$DSmallBinary;
		}break;
		case "MEDIUMBLOB":{
			$t = sys_db_RecordType::$DBinary;
		}break;
		case "LONGBLOB":{
			$t = sys_db_RecordType::$DLongBinary;
		}break;
		case "TINYINT":{
			switch($param) {
			case 1:{
				$fdesc->remove("UNSIGNED");
				$t = sys_db_RecordType::$DBool;
			}break;
			case 4:{
				$t = sys_db_RecordType::$DTinyInt;
			}break;
			case 3:{
				if($fdesc->remove("UNSIGNED")) {
					$t = sys_db_RecordType::$DTinyUInt;
				} else {
					$t = null;
				}
			}break;
			default:{
				if(spadm_TableInfos::$OLD_COMPAT) {
					$t = sys_db_RecordType::$DInt;
				} else {
					$t = null;
				}
			}break;
			}
		}break;
		case "SMALLINT":{
			if($fdesc->remove("UNSIGNED")) {
				$t = sys_db_RecordType::$DSmallUInt;
			} else {
				$t = sys_db_RecordType::$DSmallInt;
			}
		}break;
		case "MEDIUMINT":{
			if($fdesc->remove("UNSIGNED")) {
				$t = sys_db_RecordType::$DMediumUInt;
			} else {
				$t = sys_db_RecordType::$DMediumInt;
			}
		}break;
		case "BINARY":{
			if($param === null) {
				$t = null;
			} else {
				$t = sys_db_RecordType::DBytes($param);
			}
		}break;
		default:{
			$t = null;
		}break;
		}
		if($t === null) {
			return null;
		}
		while($fdesc->length > 0) {
			$d = $fdesc->shift();
			switch($d) {
			case "NOT":{
				if($fdesc->shift() !== "NULL") {
					return null;
				}
				$nullable = false;
			}break;
			case "DEFAULT":{
				$v = $fdesc->shift();
				if($nullable) {
					if($v === "NULL") {
						continue 2;
					}
					return null;
				}
				$def = null;
				switch($t->index) {
				case 0:case 2:case 1:case 3:case 8:case 6:case 7:case 20:case 5:case 4:case 23:case 24:{
					$def = "'0'";
				}break;
				case 25:case 26:case 27:case 29:case 28:{
					$def = "'0'";
				}break;
				case 13:case 15:case 9:case 14:case 21:{
					$def = "''";
				}break;
				case 11:case 12:{
					if(strlen($v) > 0 && _hx_char_at($v, strlen($v) - 1) !== "'") {
						$v .= " " . _hx_string_or_null($fdesc->shift());
					}
					$def = "'0000-00-00 00:00:00'";
				}break;
				case 10:{
					$def = "'0000-00-00'";
				}break;
				case 16:case 18:case 17:case 22:case 19:case 33:case 32:{
					$def = null;
				}break;
				case 30:{
					$def = null;
				}break;
				case 31:{
					$def = "'0'";
				}break;
				}
				if($v !== $def && !spadm_TableInfos::$OLD_COMPAT) {
					return null;
				}
			}break;
			case "NULL":{
				if(!$nullable) {
					return null;
				}
				$nullable = true;
				continue 2;
			}break;
			default:{
				return null;
			}break;
			}
			unset($d);
		}
		return _hx_anonymous(array("t" => $t, "nullable" => $nullable));
	}
	static function fromDescription($desc) {
		$r = new EReg("^CREATE TABLE `([^`]*)` \\((.*)\\)( ENGINE=([^ ]+))?( AUTO_INCREMENT=[^ ]+)?( DEFAULT CHARSET=.*)?\$", "sm");
		if(!$r->match($desc)) {
			throw new HException("Invalid " . _hx_string_or_null($desc));
		}
		$tname = $r->matched(1);
		if(strtoupper($r->matched(4)) !== "INNODB") {
			throw new HException("Table " . _hx_string_or_null($tname) . " should be INNODB");
		}
		$matches = _hx_explode(",\x0A", $r->matched(2));
		$field_r = new EReg("^[ \x0D\x0A]*`(.*)` (.*)\$", "");
		$primary_r = new EReg("^[ \x0D\x0A]*PRIMARY KEY +\\((.*)\\)[ \x0D\x0A]*\$", "");
		$index_r = new EReg("^[ \x0D\x0A]*(UNIQUE )?KEY `(.*)` \\((.*)\\)[ \x0D\x0A]*\$", "");
		$foreign_r = new EReg("^[ \x0D\x0A]*CONSTRAINT `(.*)` FOREIGN KEY \\(`(.*)`\\) REFERENCES `(.*)` \\(`(.*)`\\) ON DELETE (SET NULL|CASCADE)[ \x0D\x0A]*\$", "");
		$index_key_r = new EReg("^`?(.*?)`?(\\([0-9+]\\))?\$", "");
		$fields = new haxe_ds_StringMap();
		$nulls = new haxe_ds_StringMap();
		$indexes = new haxe_ds_StringMap();
		$relations = new _hx_array(array());
		$primary = null;
		{
			$_g = 0;
			while($_g < $matches->length) {
				$f = $matches[$_g];
				++$_g;
				if($field_r->match($f)) {
					$fname = $field_r->matched(1);
					$ftype = spadm_TableInfos::fromTypeDescription($field_r->matched(2));
					if($ftype === null) {
						throw new HException("Unknown description '" . _hx_string_or_null($field_r->matched(2)) . "'");
					}
					$fields->set($fname, $ftype->t);
					if($ftype->nullable) {
						$nulls->set($fname, true);
					}
					unset($ftype,$fname);
				} else {
					if($primary_r->match($f)) {
						if($primary !== null) {
							throw new HException("Duplicate primary key");
						}
						$primary = _hx_explode(",", $primary_r->matched(1));
						{
							$_g2 = 0;
							$_g1 = $primary->length;
							while($_g2 < $_g1) {
								$i = $_g2++;
								$k = spadm_TableInfos::unescape($primary[$i]);
								$primary[$i] = $k;
								unset($k,$i);
							}
							unset($_g2,$_g1);
						}
					} else {
						if($index_r->match($f)) {
							$unique = $index_r->matched(1);
							$idxname = $index_r->matched(2);
							$fs = Lambda::hlist(_hx_explode(",", $index_r->matched(3)));
							{
								$value = _hx_anonymous(array("keys" => $fs->map(array(new _hx_lambda(array(&$_g, &$desc, &$f, &$field_r, &$fields, &$foreign_r, &$fs, &$idxname, &$index_key_r, &$index_r, &$indexes, &$matches, &$nulls, &$primary, &$primary_r, &$r, &$relations, &$tname, &$unique), "spadm_TableInfos_3"), 'execute')), "unique" => $unique !== "" && $unique !== null, "name" => $idxname));
								$indexes->set($idxname, $value);
								unset($value);
							}
							unset($unique,$idxname,$fs);
						} else {
							if($foreign_r->match($f)) {
								$name = $foreign_r->matched(1);
								$key = $foreign_r->matched(2);
								$table = $foreign_r->matched(3);
								$table = _hx_string_or_null(strtoupper(_hx_substr($table, 0, 1))) . _hx_string_or_null(_hx_substr($table, 1, null));
								$id = $foreign_r->matched(4);
								$setnull = null;
								if($foreign_r->matched(5) === "SET NULL") {
									$setnull = true;
								} else {
									$setnull = null;
								}
								$relations->push(_hx_anonymous(array("name" => $name, "key" => $key, "table" => $table, "id" => $id, "setnull" => $setnull)));
								unset($table,$setnull,$name,$key,$id);
							} else {
								throw new HException("Invalid " . _hx_string_or_null($f) . " in " . _hx_string_or_null($desc));
							}
						}
					}
				}
				unset($f);
			}
		}
		return _hx_anonymous(array("table" => $tname, "fields" => $fields, "nulls" => $nulls, "indexes" => $indexes, "relations" => $relations, "primary" => $primary));
	}
	static function sameDBStorage($dt, $rt) {
		switch($rt->index) {
		case 20:{
			return $dt === sys_db_RecordType::$DInt;
		}break;
		case 23:{
			$auto = $rt->params[1];
			$fl = $rt->params[0];
			if($auto) {
				if($fl->length <= 8) {
					return $dt === sys_db_RecordType::$DTinyUInt;
				} else {
					if($fl->length <= 16) {
						return $dt === sys_db_RecordType::$DSmallUInt;
					} else {
						if($fl->length <= 24) {
							return $dt === sys_db_RecordType::$DMediumUInt;
						} else {
							return $dt === sys_db_RecordType::$DInt;
						}
					}
				}
			} else {
				return $dt === sys_db_RecordType::$DInt;
			}
		}break;
		case 21:{
			return $dt === sys_db_RecordType::$DText;
		}break;
		case 22:{
			return $dt === sys_db_RecordType::$DBinary;
		}break;
		case 30:{
			return $dt === sys_db_RecordType::$DBinary;
		}break;
		case 31:{
			return $dt === sys_db_RecordType::$DTinyUInt;
		}break;
		default:{
			return false;
		}break;
		}
	}
	static function allTablesRequest() {
		return "SHOW TABLES";
	}
	function __toString() { return 'spadm.TableInfos'; }
}
function spadm_TableInfos_0(&$__hx__this, &$f) {
	{
		$_g = $f->type;
		switch($_g->index) {
		case 0:{
			return "INT AUTO_INCREMENT";
		}break;
		case 2:{
			return "INT UNSIGNED AUTO_INCREMENT";
		}break;
		case 1:case 20:{
			return "INT";
		}break;
		case 23:{
			$auto = $_g->params[1];
			$fl = $_g->params[0];
			if($auto) {
				if($fl->length <= 8) {
					return "TINYINT UNSIGNED";
				} else {
					if($fl->length <= 16) {
						return "SMALLINT UNSIGNED";
					} else {
						if($fl->length <= 24) {
							return "MEDIUMINT UNSIGNED";
						} else {
							return "INT";
						}
					}
				}
			} else {
				return "INT";
			}
			unset($fl,$auto);
		}break;
		case 24:{
			return "TINYINT";
		}break;
		case 3:{
			return "INT UNSIGNED";
		}break;
		case 6:{
			return "FLOAT";
		}break;
		case 7:{
			return "DOUBLE";
		}break;
		case 8:{
			return "TINYINT(1)";
		}break;
		case 9:{
			$n = $_g->params[0];
			return "VARCHAR(" . _hx_string_rec($n, "") . ")";
		}break;
		case 10:{
			return "DATE";
		}break;
		case 11:{
			return "DATETIME";
		}break;
		case 12:{
			return "TIMESTAMP" . _hx_string_or_null(((($__hx__this->nulls->exists($f->name)) ? " NULL DEFAULT NULL" : " DEFAULT 0")));
		}break;
		case 13:{
			return "TINYTEXT";
		}break;
		case 14:{
			return "TEXT";
		}break;
		case 15:case 21:{
			return "MEDIUMTEXT";
		}break;
		case 16:{
			return "BLOB";
		}break;
		case 18:case 22:{
			return "MEDIUMBLOB";
		}break;
		case 30:{
			return "MEDIUMBLOB";
		}break;
		case 31:{
			return "TINYINT UNSIGNED";
		}break;
		case 17:{
			return "LONGBLOB";
		}break;
		case 5:{
			return "BIGINT";
		}break;
		case 4:{
			return "BIGINT AUTO_INCREMENT";
		}break;
		case 19:{
			$n1 = $_g->params[0];
			return "BINARY(" . _hx_string_rec($n1, "") . ")";
		}break;
		case 25:{
			return "TINYINT UNSIGNED";
		}break;
		case 26:{
			return "SMALLINT";
		}break;
		case 27:{
			return "SMALLINT UNSIGNED";
		}break;
		case 28:{
			return "MEDIUMINT";
		}break;
		case 29:{
			return "MEDIUMINT UNSIGNED";
		}break;
		case 33:case 32:{
			throw new HException("assert");
		}break;
		}
		unset($_g);
	}
}
function spadm_TableInfos_1(&$o, $p) {
	{
		return _hx_explode(".", Std::string(Reflect::field($o, $p)))->join("~");
	}
}
function spadm_TableInfos_2(&$__hx__this, &$cond, &$count, &$f, &$m, &$order, &$p, &$params, &$pos, &$rop, &$v) {
	try {
		return spadm_Id::encode($v);
	}catch(Exception $__hx__e) {
		$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
		$e = $_ex_;
		{
			return 0;
		}
	}
}
function spadm_TableInfos_3(&$_g, &$desc, &$f, &$field_r, &$fields, &$foreign_r, &$fs, &$idxname, &$index_key_r, &$index_r, &$indexes, &$matches, &$nulls, &$primary, &$primary_r, &$r, &$relations, &$tname, &$unique, $r1) {
	{
		if(!$index_key_r->match($r1)) {
			throw new HException("Invalid index key " . _hx_string_or_null($r1));
		}
		return $index_key_r->matched(1);
	}
}
