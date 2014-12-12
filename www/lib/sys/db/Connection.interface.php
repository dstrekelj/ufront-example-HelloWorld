<?php

interface sys_db_Connection {
	function request($s);
	function quote($s);
	function addValue($s, $v);
	function lastInsertId();
	function dbName();
	function rollback();
	//;
}
