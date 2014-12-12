<?php

class sys_db_Transaction {
	public function __construct(){}
	static function isDeadlock($e) {
		return Std::is($e, _hx_qtype("String")) && _hx_deref(new EReg("try restarting transaction", ""))->match($e);
	}
	static function runMainLoop($mainFun, $logError, $count) {
		try {
			call_user_func($mainFun);
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			$e = $_ex_;
			{
				if($count > 0 && sys_db_Transaction::isDeadlock($e)) {
					sys_db_Manager::cleanup();
					sys_db_Manager::$cnx->rollback();
					sys_db_Manager::$cnx->startTransaction();
					sys_db_Transaction::runMainLoop($mainFun, $logError, $count - 1);
					return;
				}
				if($logError === null) {
					sys_db_Manager::$cnx->rollback();
					throw new HException($e);
				}
				call_user_func_array($logError, array($e));
			}
		}
	}
	static function main($cnx, $mainFun, $logError = null) {
		sys_db_Manager::initialize();
		sys_db_Manager::set_cnx($cnx);
		sys_db_Manager::$cnx->startTransaction();
		sys_db_Transaction::runMainLoop($mainFun, $logError, 3);
		try {
			sys_db_Manager::$cnx->commit();
		}catch(Exception $__hx__e) {
			$_ex_ = ($__hx__e instanceof HException) ? $__hx__e->e : $__hx__e;
			if(is_string($e = $_ex_)){
				if(_hx_deref(new EReg("Database is busy", ""))->match($e)) {
					call_user_func_array($logError, array($e));
				}
			} else throw $__hx__e;;
		}
		sys_db_Manager::$cnx->close();
		sys_db_Manager::set_cnx(null);
		sys_db_Manager::cleanup();
	}
	function __toString() { return 'sys.db.Transaction'; }
}
