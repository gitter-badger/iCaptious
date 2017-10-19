<?php

namespace iCaptious;

/**
* 
*/
class Route extends \iCaptious\Path
{
	
	function __construct()
	{
		# code...
	}

	/**
	 * [load description]
	 * @param  [string]   $route    [It gives the route]
	 * @param  [function] $callback [Will be called if the route was matched]
	 * @return [unknown]            [It returns the output of the callback function]
	 */
	static function load($route, $callback){
		$route = self::Sanitize_Route($route);
		$real_route = self::Sanitize_Route(parent::path_call());
		$arguments = array();

		foreach ($route as $key => $name) {
			if (preg_match_all('/{(.*?)}/', $name)) {
				$route[$key] = $argument = $real_route[$key];
				$arguments[] = htmlentities($argument); 
			}
		}

		if ($route === $real_route) {
			call_user_func_array($callback, $arguments);
		}
		return false;
	}

	/**
	 * [Sanitize_Route description]
	 * @param  [string] $route [It gives the route]
	 * @return [array]         [It returns the route as array]
	 */
	static function Sanitize_Route($route) {
		# remove slash if it exist at the end of the route
		$route = trim($route, '/'); 
		# 	$route = (strpos($route, '/') ? explode('/', $route) : $route);
		$route = explode('/', $route);
		return $route;
	}

	static function isDomain($domain, $callback){
		if (is_string($domain)) {
			if ($_SERVER['SERVER_NAME'] == $domain || $_SERVER['SERVER_NAME'] == "www.".$domain) {
				return call_user_func($callback);
			}
		}
	}

	static function Domain($domain, $callback){
		return call_user_func_array(__NAMESPACE__ .'\Route::isDomain', func_get_args());
	}

	static function Secure(){
		if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
		    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		    header('HTTP/1.1 301 Moved Permanently');
		    header('Location: ' . $redirect);
		    exit();
		}
	}

	static function inSecure(){
		if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off"){
		    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		    header('HTTP/1.1 301 Moved Permanently');
		    header('Location: ' . $redirect);
		    exit();
		}
	}

	static function Redirect($url,$permanently=false){
		if ($permanently === true) {
			header('HTTP/1.1 301 Moved Permanently'); // The Redirect will be cached by the browser
		}
	    header('Location: ' . $url);
	    exit();
	}
}