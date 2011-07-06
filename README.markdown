# Function json_encode() on PHP #

Implementation of function json_encode() on PHP.

See http://php.net/json_encode and http://php.net/json_decode

# Using #

If you need function json_encode() and it is missing (in PHP < 5.2.0) just add:

	require_once("json_encode.php");
	
Now json_encode() available and you can use it:

	json_encode($data);