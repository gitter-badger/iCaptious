<?php

namespace iCaptious\Core;

/**
* 
*/
class Route extends \iCaptious\Core\Domain\Path
{
	
	function __construct(){

	}


	/**
	 * Duplicate of Route::load Function
	 * @param  string   $route    Route to be matched
	 * @param  function $callback Will be called if the route matches]
	 * @return unknown            It returns the output of the callback function
	 */
	static function get($route, $callback){
		return call_user_func_array(__NAMESPACE__ .'\Route::load', func_get_args());
	}

	/**
	 * Calls the calback given if route matches
	 * @param  string   $route    Route to be matched
	 * @param  function $callback Will be called if the route matches]
	 * @return unknown            It returns the output of the callback function
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
			return call_user_func_array($callback, $arguments);
		}
		return false;
	}

	/**
	 * Filtering and return the route as an array
	 * @param  string $route 
	 * @return array         
	 */
	static function Sanitize_Route($route) {
		# remove slash if it exist at the end of the route
		$route = trim($route, '/'); 
		# 	$route = (strpos($route, '/') ? explode('/', $route) : $route);
		$route = explode('/', $route);
		return $route;
	}

	/**
	 * Check if this is the domain
	 * @param  string   $domain
	 * @param  calback  $callback
	 * @return callback  
	 */
	static function isDomain(string $domain, $callback){
		if (is_string($domain)) {
			if ($_SERVER['SERVER_NAME'] == $domain || $_SERVER['SERVER_NAME'] == "www.".$domain) {
				return call_user_func($callback);
			}
		}
	}

	/**
	 * Duplicate of Route::isDomain
	 * @param string  $domain
	 * @param calback $callback
	 * @return callback
	 */
	static function Domain($domain, $callback){
		return call_user_func_array(__NAMESPACE__ .'\Route::isDomain', func_get_args());
	}

	/**
	 * Checks if the website is in Secure mode and tries to redirect to Secure mode
	 */
	static function Secure(){
		if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
		    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		    header('HTTP/1.1 301 Moved Permanently');
		    header('Location: ' . $redirect);
		    exit();
		}
	}

	/**
	 * Checks if the website is not in Secure mode and tries to redirect to Insecure mode
	 */
	static function inSecure(){
		if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off"){
		    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		    header('HTTP/1.1 301 Moved Permanently');
		    header('Location: ' . $redirect);
		    exit();
		}
	}

	/**
	 * Redirects the client to a website
	 * @param string  $url
	 * @param boolean $permanently
	 */
	static function Redirect($url,$permanently=false){
		if ($permanently === true) {
			header('HTTP/1.1 301 Moved Permanently'); // The Redirect will be cached by the browser
		}
	    header('Location: ' . $url);
	    exit();
	}
}
