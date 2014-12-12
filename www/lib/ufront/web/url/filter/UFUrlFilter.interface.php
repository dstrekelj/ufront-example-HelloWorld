<?php

interface ufront_web_url_filter_UFUrlFilter {
	function filterIn($url, $request);
	function filterOut($url, $request);
	//;
}
