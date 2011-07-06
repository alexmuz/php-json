# Functions json_encode() and json_decode() on PHP #

Implementation of functions json_encode() and json_decode() on PHP.

See http://php.net/json_encode and http://php.net/json_decode

## System Requirements ##

	* PHP
		* mbstring extension
	* Charset UTF-8

## Using php-json ##

If you need function json_encode() or json_decode() and it is missing (in PHP < 5.2.0, error " Call to undefined function json_encode or json_decode") just add:

	require_once("json_encode.php");
	require_once("json_decode.php");
	
Now functions json_encode() and json_decode() are available and you can use it:

	json_encode($data);
	json_decode($data);