<?php

interface ufront_web_upload_FileUpload {
	//;
	//;
	//;
	function getBytes();
	function getString();
	function writeToFile($filePath);
	function process($onData, $partSize = null);
	//;
}
