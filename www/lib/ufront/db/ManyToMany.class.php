<?php

class ufront_db_ManyToMany {
	public function __construct($aObject, $bClass, $initialise = null) {
		if(!php_Boot::$skip_constructor) {
		if($initialise === null) {
			$initialise = true;
		}
		if($aObject === null) {
			throw new HException("Error creating ManyToMany: aObject must not be null");
		}
		$this->aObject = $aObject;
		$this->a = Type::getClass($aObject);
		$this->b = $bClass;
		$this->bManager = $bClass->manager;
		$this->tableName = ufront_db_ManyToMany::generateTableName($this->a, $this->b);
		$this->manager = ufront_db_ManyToMany::getManager($this->tableName);
		$this->unsavedBObjects = new HList();
		if($initialise) {
			$this->refreshList();
		} else {
			$this->bList = new HList();
			$this->bListIDs = new HList();
		}
	}}
	public $a;
	public $b;
	public $aObject;
	public $bList;
	public $bListIDs;
	public $unsavedBObjects;
	public $length;
	public $tableName;
	public $bManager;
	public $manager;
	public function first() {
		return $this->bList->first();
	}
	public function isEmpty() {
		return $this->bList->isEmpty();
	}
	public function join($sep) {
		return $this->bList->join($sep);
	}
	public function last() {
		return $this->bList->last();
	}
	public function iterator() {
		return $this->bList->iterator();
	}
	public function filter($predicate) {
		return $this->bList->filter($predicate);
	}
	public function map($fn) {
		return $this->bList->map($fn);
	}
	public function toString() {
		return $this->bList->toString();
	}
	public function refreshList() {
		$this->unsavedBObjects->clear();
		if($this->aObject->id !== null) {
			$id = $this->aObject->id;
			$bTableName = $this->bManager->table_name;
			$aColumn = null;
			if(ufront_db_ManyToMany::isABeforeB($this->a, $this->b)) {
				$aColumn = "r1";
			} else {
				$aColumn = "r2";
			}
			$bColumn = null;
			if(ufront_db_ManyToMany::isABeforeB($this->a, $this->b)) {
				$bColumn = "r2";
			} else {
				$bColumn = "r1";
			}
			$this->bList = $this->bManager->unsafeObjects("SELECT " . _hx_string_or_null($bTableName) . ".* FROM `" . _hx_string_or_null($this->tableName) . "` JOIN " . _hx_string_or_null($bTableName) . " ON `" . _hx_string_or_null($this->tableName) . "`." . _hx_string_or_null($bColumn) . "=" . _hx_string_or_null($bTableName) . ".id WHERE `" . _hx_string_or_null($this->tableName) . "`." . _hx_string_or_null($aColumn) . "=" . _hx_string_or_null(sys_db_Manager::quoteAny($id)) . " ORDER BY " . _hx_string_or_null($this->tableName) . ".modified ASC", false);
			$this->bListIDs = $this->bList->map(array(new _hx_lambda(array(&$aColumn, &$bColumn, &$bTableName, &$id), "ufront_db_ManyToMany_0"), 'execute'));
		} else {
			$this->bList = new HList();
			$this->bListIDs = new HList();
		}
	}
	public function compileBList() {
		$bTableName = $this->bManager->table_name;
		if($this->bListIDs !== null) {
			$this->bList = $this->bManager->unsafeObjects("SELECT * FROM " . _hx_string_or_null($bTableName) . " WHERE " . _hx_string_or_null(sys_db_Manager::quoteList("id", $this->bListIDs)), false);
		} else {
			$this->bList = new HList();
		}
		if(null == $this->unsavedBObjects) throw new HException('null iterable');
		$__hx__it = $this->unsavedBObjects->iterator();
		while($__hx__it->hasNext()) {
			$newObj = $__hx__it->next();
			$this->bList->add($newObj);
		}
	}
	public function commitJoins() {
		$this->setList(Lambda::hlist($this->bList));
		$this->unsavedBObjects->clear();
	}
	public function add($bObject) {
		$_g = $this;
		if($bObject !== null && Lambda::has($this->bList, $bObject) === false) {
			$this->bList->add($bObject);
			$server = true;
			if($server && $this->aObject->id !== null && $bObject->id !== null) {
				$r = null;
				if(ufront_db_ManyToMany::isABeforeB($this->a, $this->b)) {
					$r = new ufront_db_Relationship($this->aObject->id, $bObject->id);
				} else {
					$r = new ufront_db_Relationship($bObject->id, $this->aObject->id);
				}
				ufront_db_ManyToMany::getManager($this->tableName)->doInsert($r);
				$this->unsavedBObjects->remove($bObject);
			} else {
				$reAdd = array(new _hx_lambda(array(&$_g, &$bObject, &$server), "ufront_db_ManyToMany_1"), 'execute');
				{
					$this1 = $this->aObject->get_saved();
					call_user_func_array($this1, array(ufront_db_ManyToMany_2($this, $_g, $bObject, $reAdd, $server, $this1)));
				}
				{
					$this2 = $bObject->get_saved();
					call_user_func_array($this2, array(ufront_db_ManyToMany_3($this, $_g, $bObject, $reAdd, $server, $this2)));
				}
				if(Lambda::has($this->unsavedBObjects, $bObject) === false) {
					$this->unsavedBObjects->add($bObject);
				}
			}
		}
	}
	public function remove($bObject) {
		if($bObject !== null) {
			$this->bList->remove($bObject);
			$aColumn = null;
			if(ufront_db_ManyToMany::isABeforeB($this->a, $this->b)) {
				$aColumn = "r1";
			} else {
				$aColumn = "r2";
			}
			$bColumn = null;
			if(ufront_db_ManyToMany::isABeforeB($this->a, $this->b)) {
				$bColumn = "r2";
			} else {
				$bColumn = "r1";
			}
			if($this->aObject->id !== null && $bObject->id !== null) {
				$this->manager->unsafeDelete("DELETE FROM `" . _hx_string_or_null($this->tableName) . "` WHERE " . _hx_string_or_null($aColumn) . " = " . _hx_string_or_null(sys_db_Manager::quoteAny($this->aObject->id)) . " AND " . _hx_string_or_null($bColumn) . " = " . _hx_string_or_null(sys_db_Manager::quoteAny($bObject->id)));
			} else {
			}
		}
	}
	public function clear() {
		$this->bList->clear();
		$this->unsavedBObjects->clear();
		if($this->aObject->id !== null) {
			$aColumn = null;
			if(ufront_db_ManyToMany::isABeforeB($this->a, $this->b)) {
				$aColumn = "r1";
			} else {
				$aColumn = "r2";
			}
			$this->manager->unsafeDelete("DELETE FROM `" . _hx_string_or_null($this->tableName) . "` WHERE " . _hx_string_or_null($aColumn) . " = " . _hx_string_or_null(sys_db_Manager::quoteAny($this->aObject->id)));
		} else {
		}
	}
	public function setList($newBList) {
		if(null == $this->bList) throw new HException('null iterable');
		$__hx__it = $this->bList->iterator();
		while($__hx__it->hasNext()) {
			$oldB = $__hx__it->next();
			if(Lambda::has($newBList, $oldB) === false) {
				$this->remove($oldB);
			}
		}
		if(null == $newBList) throw new HException('null iterable');
		$__hx__it = $newBList->iterator();
		while($__hx__it->hasNext()) {
			$b = $__hx__it->next();
			$this->add($b);
		}
	}
	public function get_length() {
		return $this->bList->length;
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
	static $managers;
	static function getManager($tableName) {
		$m = null;
		if(ufront_db_ManyToMany::$managers->exists($tableName)) {
			$m = ufront_db_ManyToMany::$managers->get($tableName);
		} else {
			ufront_db_Relationship::$manager;
			$m = new sys_db_Manager(_hx_qtype("ufront.db.Relationship"));
			$m->table_infos->name = $tableName;
			$m->table_name = $m->quoteField($tableName);
			ufront_db_ManyToMany::$managers->set($tableName, $m);
		}
		return $m;
	}
	static function isABeforeB($a, $b) {
		$aName = _hx_explode(".", Type::getClassName($a))->pop();
		$bName = _hx_explode(".", Type::getClassName($b))->pop();
		$arr = (new _hx_array(array($aName, $bName)));
		$arr->sort(array(new _hx_lambda(array(&$a, &$aName, &$arr, &$b, &$bName), "ufront_db_ManyToMany_4"), 'execute'));
		return $arr[0] === $aName;
	}
	static function generateTableName($a, $b) {
		$aName = _hx_explode(".", Type::getClassName($a))->pop();
		$bName = _hx_explode(".", Type::getClassName($b))->pop();
		$arr = (new _hx_array(array($aName, $bName)));
		$arr->sort(array(new _hx_lambda(array(&$a, &$aName, &$arr, &$b, &$bName), "ufront_db_ManyToMany_5"), 'execute'));
		$arr->unshift("_join");
		return $arr->join("_");
	}
	static function createJoinTable($aModel, $bModel) {
		$tableName = ufront_db_ManyToMany::generateTableName($aModel, $bModel);
		$manager = ufront_db_ManyToMany::getManager($tableName);
		if(sys_db_TableCreate::exists($manager) === false) {
			sys_db_TableCreate::create($manager, null);
		}
	}
	static function relatedIDsforObjects($aModel, $bModel, $aObjectIDs = null) {
		$aBeforeB = ufront_db_ManyToMany::isABeforeB($aModel, $bModel);
		$tableName = ufront_db_ManyToMany::generateTableName($aModel, $bModel);
		$manager = ufront_db_ManyToMany::getManager($tableName);
		$aColumn = null;
		if($aBeforeB) {
			$aColumn = "r1";
		} else {
			$aColumn = "r2";
		}
		$relationships = null;
		if($aObjectIDs === null) {
			$relationships = $manager->all(null);
		} else {
			$relationships = $manager->unsafeObjects("SELECT * FROM `" . _hx_string_or_null($tableName) . "` WHERE " . _hx_string_or_null(sys_db_Manager::quoteList($aColumn, $aObjectIDs)) . " ORDER BY modified ASC", false);
		}
		$intMap = new haxe_ds_IntMap();
		if(null == $relationships) throw new HException('null iterable');
		$__hx__it = $relationships->iterator();
		while($__hx__it->hasNext()) {
			$r = $__hx__it->next();
			$aID = null;
			if($aBeforeB) {
				$aID = $r->r1;
			} else {
				$aID = $r->r2;
			}
			$bID = null;
			if($aBeforeB) {
				$bID = $r->r2;
			} else {
				$bID = $r->r1;
			}
			$list = $intMap->get($aID);
			if($list === null) {
				$intMap->set($aID, $list = new HList());
			}
			$list->add($bID);
			unset($list,$bID,$aID);
		}
		return $intMap;
	}
	static $__properties__ = array("get_length" => "get_length");
	function __toString() { return $this->toString(); }
}
ufront_db_ManyToMany::$managers = new haxe_ds_StringMap();
function ufront_db_ManyToMany_0(&$aColumn, &$bColumn, &$bTableName, &$id, $b) {
	{
		return $b->id;
	}
}
function ufront_db_ManyToMany_1(&$_g, &$bObject, &$server) {
	{
		if(Lambda::has($_g->unsavedBObjects, $bObject)) {
			$_g->bList->remove($bObject);
			$_g->add($bObject);
		}
	}
}
function ufront_db_ManyToMany_2(&$__hx__this, &$_g, &$bObject, &$reAdd, &$server, &$this1) {
	{
		$f = $reAdd;
		return array(new _hx_lambda(array(&$_g, &$bObject, &$f, &$reAdd, &$server, &$this1), "ufront_db_ManyToMany_6"), 'execute');
	}
}
function ufront_db_ManyToMany_3(&$__hx__this, &$_g, &$bObject, &$reAdd, &$server, &$this2) {
	{
		$f1 = $reAdd;
		return array(new _hx_lambda(array(&$_g, &$bObject, &$f1, &$reAdd, &$server, &$this2), "ufront_db_ManyToMany_7"), 'execute');
	}
}
function ufront_db_ManyToMany_4(&$a, &$aName, &$arr, &$b, &$bName, $x, $y) {
	{
		return Reflect::compare($x, $y);
	}
}
function ufront_db_ManyToMany_5(&$a, &$aName, &$arr, &$b, &$bName, $x, $y) {
	{
		return Reflect::compare($x, $y);
	}
}
function ufront_db_ManyToMany_6(&$_g, &$bObject, &$f, &$reAdd, &$server, &$this1, $r1) {
	{
		call_user_func($f);
	}
}
function ufront_db_ManyToMany_7(&$_g, &$bObject, &$f1, &$reAdd, &$server, &$this2, $r2) {
	{
		call_user_func($f1);
	}
}
