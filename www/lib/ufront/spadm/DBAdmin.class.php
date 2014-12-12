<?php

class ufront_spadm_DBAdmin extends spadm_Admin {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
		$this->manyToManyTableNames = (new _hx_array(array()));
	}}
	public $manyToManyTableNames;
	public function getTables() {
		$tables = new _hx_array(array());
		$classes = CompileTimeClassList::get("null,true,ufront.db.Object");
		if(null == $classes) throw new HException('null iterable');
		$__hx__it = $classes->iterator();
		while($__hx__it->hasNext()) {
			$cl = $__hx__it->next();
			$this->addTable($tables, $cl);
		}
		$tables->sort(array(new _hx_lambda(array(&$classes, &$tables), "ufront_spadm_DBAdmin_0"), 'execute'));
		return $tables;
	}
	public function addTable($tables, $model) {
		if(haxe_rtti_Meta::getType($model)->rtti === null) {
			return;
		}
		$m = haxe_rtti_Meta::getType($model);
		if(_hx_has_field($m, "noTable")) {
			return;
		}
		$rels = Reflect::field($model, "hxRelationships");
		$tables->push(new spadm_TableInfos(Type::getClassName($model)));
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
	static function handler($baseUrl = null) {
		sys_db_Manager::initialize();
		try {
			_hx_deref(new ufront_spadm_DBAdmin())->process(null, $baseUrl);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				Sys::hprint("<pre>");
				Sys::println(Std::string($e));
				Sys::println(haxe_CallStack::toString(haxe_CallStack::exceptionStack()));
				Sys::println(haxe_CallStack::toString(haxe_CallStack::exceptionStack()));
				Sys::hprint("</pre>");
				sys_db_Manager::$cnx->rollback();
			}
		}
	}
	function __toString() { return 'ufront.spadm.DBAdmin'; }
}
function ufront_spadm_DBAdmin_0(&$classes, &$tables, $t1, $t2) {
	{
		if(strtoupper($t1->name) > strtoupper($t2->name)) {
			return 1;
		} else {
			if(strtoupper($t1->name) < strtoupper($t2->name)) {
				return -1;
			} else {
				return 0;
			}
		}
	}
}
