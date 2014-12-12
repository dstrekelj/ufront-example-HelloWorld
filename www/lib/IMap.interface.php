<?php

interface IMap {
	function get($k);
	function set($k, $v);
	function exists($k);
	function keys();
	//;
}
