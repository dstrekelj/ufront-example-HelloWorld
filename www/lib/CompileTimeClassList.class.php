<?php

class CompileTimeClassList {
	public function __construct(){}
	static function __meta__() { $args = func_get_args(); return call_user_func_array(self::$__meta__, $args); }
	static $__meta__;
	static $lists = null;
	static function get($id) {
		if(CompileTimeClassList::$lists === null) {
			CompileTimeClassList::initialise();
		}
		return CompileTimeClassList::$lists->get($id);
	}
	static function getTyped($id, $type) {
		return CompileTimeClassList::get($id);
	}
	static function initialise() {
		CompileTimeClassList::$lists = new haxe_ds_StringMap();
		$m = haxe_rtti_Meta::getType(_hx_qtype("CompileTimeClassList"));
		if($m->classLists !== null) {
			$_g = 0;
			$_g1 = $m->classLists;
			while($_g < $_g1->length) {
				$item = $_g1[$_g];
				++$_g;
				$array = $item;
				$listID = $array[0];
				$list = new HList();
				{
					$_g2 = 0;
					$_g3 = _hx_explode(",", $array[1]);
					while($_g2 < $_g3->length) {
						$typeName = $_g3[$_g2];
						++$_g2;
						$type = Type::resolveClass($typeName);
						if($type !== null) {
							$list->push($type);
						}
						unset($typeName,$type);
					}
					unset($_g3,$_g2);
				}
				CompileTimeClassList::$lists->set($listID, $list);
				unset($listID,$list,$item,$array);
			}
		}
	}
	function __toString() { return 'CompileTimeClassList'; }
}
CompileTimeClassList::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("classLists" => (new _hx_array(array((new _hx_array(array("null,true,ufront.web.Controller", "app.Routes,ufront.ufadmin.UFAdminModule,ufront.ufadmin.modules.DBAdminModule,ufront.ufadmin.modules.EasyAuthAdminModule,ufront.web.DefaultUfrontController"))), (new _hx_array(array("null,true,ufront.api.UFApi", "ufront.auth.api.EasyAuthApi"))), (new _hx_array(array("null,true,ufront.ufadmin.UFAdminModule", "ufront.ufadmin.modules.DBAdminModule,ufront.ufadmin.modules.EasyAuthAdminModule"))), (new _hx_array(array("null,true,ufront.db.Object", "ufront.auth.model.Group,ufront.auth.model.Permission,ufront.auth.model.User,ufront.db.Relationship,ufront.db.joins.Join_Group_User"))))))))));
