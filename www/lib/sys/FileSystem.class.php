<?php

class sys_FileSystem {
	public function __construct(){}
	static function stat($path) {
		$fp = fopen($path, "r"); $fstat = fstat($fp); fclose($fp);;
		return _hx_anonymous(array("gid" => $fstat['gid'], "uid" => $fstat['uid'], "atime" => Date::fromTime($fstat['atime'] * 1000), "mtime" => Date::fromTime($fstat['mtime'] * 1000), "ctime" => Date::fromTime($fstat['ctime'] * 1000), "dev" => $fstat['dev'], "ino" => $fstat['ino'], "nlink" => $fstat['nlink'], "rdev" => $fstat['rdev'], "size" => $fstat['size'], "mode" => $fstat['mode']));
	}
	static function readDirectory($path) {
		$l = array();
		$dh = opendir($path);
        while (($file = readdir($dh)) !== false) if("." != $file && ".." != $file) $l[] = $file;
        closedir($dh);;
		return new _hx_array($l);
	}
	function __toString() { return 'sys.FileSystem'; }
}
