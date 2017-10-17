<?php

namespace Google;

/**
* 
*/
class reCaptcha
{
	var $secret_key = "";

	function __construct(string $captcha){
		return reCaptcha::Verify($captcha, $this->secret_key);
	}

	static function Verify($captcha, $secret_key, $ver = "v2"){
		$response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret_key}&response={$captcha}&remoteip=".$_SERVER['REMOTE_ADDR']), true);
        if($response['success'] == false) {
        	return false;
        } else {
        	return true;
        }
	}
}