<?php

class php_db__PDO_BaseResultSet implements sys_db_ResultSet{
	public function __construct($pdo, $typeStrategy) {
		if(!php_Boot::$skip_constructor) {
		$this->pdo = $pdo;
		$this->typeStrategy = $typeStrategy;
		$this->_fields = $pdo->columnCount();
		$this->_columnNames = (new _hx_array(array()));
		$this->_columnTypes = (new _hx_array(array()));
		$this->feedColumns();
	}}
	public $pdo;
	public $typeStrategy;
	public $_fields;
	public $_columnNames;
	public $_columnTypes;
	public $length;
	public function feedColumns() {
		$_g1 = 0;
		$_g = $this->_fields;
		while($_g1 < $_g) {
			$i = $_g1++;
			$data = $this->pdo->getColumnMeta($i);
			$this->_columnNames->push($data["name"]);
			$this->_columnTypes->push($this->typeStrategy->map($data));
			unset($i,$data);
		}
	}
	public function getIntResult($index) {
		return intval($this->getResult($index));
	}
	public function getResult($index) {
		throw new HException("must override");
	}
	public function hasNext() {
		throw new HException("must override");
	}
	public function get_length() {
		throw new HException("must override");
	}
	public function nextRow() {
		throw new HException("must override");
	}
	public function next() {
		$row = $this->nextRow();
		$o = _hx_anonymous(array());
		{
			$_g1 = 0;
			$_g = $this->_fields;
			while($_g1 < $_g) {
				$i = $_g1++;
				$value = php_db__PDO_TypeStrategy::convert($row[$i], $this->_columnTypes[$i]);
				$o->{$this->_columnNames[$i]} = $value;
				unset($value,$i);
			}
		}
		return $o;
	}
	public function results() {
		$list = new HList();
		while($this->hasNext()) {
			$list->add($this->next());
		}
		return $list;
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
	static $__properties__ = array("get_length" => "get_length");
	function __toString() { return 'php.db._PDO.BaseResultSet'; }
}
