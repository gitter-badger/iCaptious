<?php 

namespace iCaptious\Route;
/**
* 
*/
class Path 
{
	public static $REL_URI;
	public static $call_utf8;
	public static $path_call;
	public static $call_parts;
	public static $GET_DATA;

	function __construct()
	{
		if (isset($_SERVER['REQUEST_URI'])) {
			self::Uri_Path();
			self::call_parts();
			self::get_properties();
		}
	}

	static function Uri_Path(){
		self::$REL_URI = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
	}

	static function call_utf8(){
		$request_path = explode('?', $_SERVER['REQUEST_URI']);
		return self::$call_utf8 = substr(urldecode($request_path[0]), strlen(self::$REL_URI) + 1);
	}

	static function path_call(){
		return self::$path_call = ((utf8_decode(self::call_utf8()) != basename($_SERVER['PHP_SELF'])) ? 
			utf8_decode(self::call_utf8()) : '');
	}

	static function call_parts(){
		return self::$call_parts = explode('/', self::path_call());
	}

	static function get_properties(){
		$request_path = explode('?', $_SERVER['REQUEST_URI']);

		if (!empty($request_path[1])) {
			$path['query_utf8'] = urldecode($request_path[1]);
			$path['query'] = utf8_decode(urldecode($request_path[1]));
			$vars = explode('&', $path['query']);
			foreach ($vars as $var) {
			  $t = explode('=', $var);
			  $path['query_vars'][$t[0]] = $t[1];
			}
		} else {
			$path['query_utf8'] = '';
			$path['query'] = '';
			$path['query_vars'] = array();
		}

		return self::$GET_DATA = $path;
	}
}