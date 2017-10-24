<?php
// Specify the extensions that may be loaded
spl_autoload_extensions('.php');
/**
 * The Autoloader function
 *
 * @param string $class The Class Name
 *
 * @access public
 */
spl_autoload_register(function ($class) {	
	if (substr($class, 0, 10) !== 'iCaptious\\') {
      /* If the class does not lie under the "ReCaptcha" namespace,
       * then we can exit immediately.
       */
      return;
    }

    // Replace the backslashes with fontslashes
    $class = str_replace('\\', '/', $class);

	// split the namespace to an array
	$namespaces = explode("/", $class);

	// Replace namespace separator with directory separator
	$path = implode(DIRECTORY_SEPARATOR, $namespaces);

	// Get full path of file containing the required class
	$file = dirname(__FILE__).DIRECTORY_SEPARATOR."framework".DIRECTORY_SEPARATOR.$path.".php";	
	
	// Load file if it exists
	if (is_readable($file)){
		require_once $file;		
	}
});