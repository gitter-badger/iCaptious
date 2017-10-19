<?php
// Specify the extensions that may be loaded
spl_autoload_extensions('.php');
/**
 * The Autoloader function
 *
 * @param string $class_name The Class Name
 *
 * @access public
 */
spl_autoload_register(function ($class_name) {
	// Only try to load classes with the WAID namepsace prefix

	if (strpos($class_name, "iCaptious\\") !== false) {

		// split the namespace to an array
		$namespaces = explode("\\", $class_name);

		// unset "iCaptious" since this is as main directory
		unset($namespaces[0]);

		// Replace namespace separator with directory separator
		$directory_file = implode(DIRECTORY_SEPARATOR, $namespaces)."/".end($namespaces);

		// Get full path of file containing the required class
		$file = dirname(__FILE__).DIRECTORY_SEPARATOR.$directory_file.".php";	
		
		// Load file if it exists
		if (is_readable($file)){
			require_once $file;		
		}
	}
});