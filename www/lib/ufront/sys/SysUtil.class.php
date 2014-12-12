<?php

class ufront_sys_SysUtil {
	public function __construct(){}
	static function mkdir($dir) {
		$dir = haxe_io_Path::removeTrailingSlashes($dir);
		if(!file_exists($dir)) {
			$parentDir = haxe_io_Path::directory($dir);
			ufront_sys_SysUtil::mkdir($parentDir);
			{
				$path = haxe_io_Path::addTrailingSlash($dir);
				$parts = null;
				{
					$_g = (new _hx_array(array()));
					while(($path = haxe_io_Path::directory($path)) !== "") {
						$_g->push($path);
					}
					$parts = $_g;
				}
				$parts->reverse();
				{
					$_g1 = 0;
					while($_g1 < $parts->length) {
						$part = $parts[$_g1];
						++$_g1;
						if(_hx_char_code_at($part, strlen($part) - 1) !== 58 && !file_exists($part)) {
							@mkdir($part, 493);
						}
						unset($part);
					}
				}
			}
		}
	}
	static function recursiveCopy($inFile, $outFile) {
		$inFile = haxe_io_Path::removeTrailingSlashes($inFile);
		$outFile = haxe_io_Path::removeTrailingSlashes($outFile);
		if(!file_exists($inFile)) {
			throw new HException("File " . _hx_string_or_null($inFile) . " is part of your deploy script, but does not exist");
		}
		$outDir = haxe_io_Path::directory($outFile);
		if(!file_exists($outDir)) {
			ufront_sys_SysUtil::mkdir($outDir);
		}
		if(is_dir($inFile)) {
			ufront_sys_SysUtil::mkdir($outFile);
			{
				$_g = 0;
				$_g1 = sys_FileSystem::readDirectory($inFile);
				while($_g < $_g1->length) {
					$child = $_g1[$_g];
					++$_g;
					ufront_sys_SysUtil::recursiveCopy("" . _hx_string_or_null($inFile) . "/" . _hx_string_or_null($child), "" . _hx_string_or_null($outFile) . "/" . _hx_string_or_null($child));
					unset($child);
				}
			}
		} else {
			$copy = true;
			if(file_exists($outFile)) {
				if(ufront_sys_SysUtil::areFilesDifferent($inFile, $outFile) === false) {
					$copy = false;
				}
			}
			if($copy) {
				Sys::println("Copying asset " . _hx_string_or_null($inFile));
				sys_io_File::saveBytes($outFile, sys_io_File::getBytes($inFile));
			}
		}
	}
	static function getCommandOutput($cmd, $args) {
		$p = new sys_io_Process($cmd, $args);
		$code = $p->exitCode();
		$stdout = $p->stdout->readAll(null)->toString();
		$stderr = $p->stderr->readAll(null)->toString();
		switch($code) {
		case 0:{
			return $stdout;
		}break;
		default:{
			throw new HException("Command `" . _hx_string_or_null($cmd) . " " . _hx_string_or_null($args->join(" ")) . "` failed. \x0AExit code: " . _hx_string_rec($code, "") . "\x0AStdout: " . _hx_string_or_null($stdout) . "\x0AStderr: " . _hx_string_or_null($stderr));
		}break;
		}
	}
	static function areFilesDifferent($file1, $file2) {
		$file1Stat = sys_FileSystem::stat($file1);
		$file2Stat = sys_FileSystem::stat($file2);
		if($file1Stat->size !== $file2Stat->size) {
			return true;
		} else {
			$input1 = sys_io_File::read($file1, null);
			$input2 = sys_io_File::read($file2, null);
			$fileSize = $file1Stat->size;
			$chunkSize = 1024;
			$amountRead = 0;
			$differenceFound = false;
			while($amountRead < $file1Stat->size) {
				$amount = $file1Stat->size - $amountRead;
				if($amount > $chunkSize) {
					$amount = $chunkSize;
				}
				$amountRead += $amount;
				$bytes1 = $input1->read($amount);
				$bytes2 = $input2->read($amount);
				if($bytes1->compare($bytes2) !== 0) {
					$differenceFound = true;
				}
				unset($bytes2,$bytes1,$amount);
			}
			$input1->close();
			$input2->close();
			return $differenceFound;
		}
	}
	function __toString() { return 'ufront.sys.SysUtil'; }
}
