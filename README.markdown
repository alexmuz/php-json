# Functions json_encode() and json_decode() on PHP #

Implementation of functions json_encode() and json_decode() on PHP.

See http://php.net/json_encode and http://php.net/json_decode

## System Requirements ##

	* PHP
		* mbstring extension
	* Charset UTF-8

## Using php-json ##

If you have errors "Call to undefined function json_encode() or json_decode()" just add:

	require_once("phpJson.class.php");
	
or

	require_once("json_encode.php");
	require_once("json_decode.php");

Now functions json_encode() and json_decode() are available and you can use it:

	json_encode($value);
	json_decode($json, $assoc);
	
