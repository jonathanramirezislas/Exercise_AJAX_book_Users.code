<?php
/*                                                                              
    Pajax - Remote (a)synchronous PHP objects in JavaScript.                                    
                                                                              
    (c) Copyright 2005, 2006 by Georges Auberger                                            
	http://www.auberger.com/pajax
                                                                                                                                                           
 	This library is free software; you can redistribute it and/or
	modify it under the terms of the GNU Lesser General Public
	License as published by the Free Software Foundation; either
	version 2.1 of the License, or (at your option) any later version.

	This library is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
	Lesser General Public License for more details.

	You should have received a copy of the GNU Lesser General Public
	License along with this library; if not, you can find it here:
	http://www.gnu.org/copyleft/lesser.txt                                     
*/

/*
	This script will dispatch the request to the proper PHP object and return
	the result of the call. It takes care of marshaling parameters back and
	forth.
*/
require_once('JSON.class.php');
require_once('Pajax.class.php');

$pajax = new Pajax();
$json = new JSON();

$input = $HTTP_RAW_POST_DATA;

error_log("PAJAX: Input JSON: " . $input);

$invoke = $json->decode($input);

// Marshaled parameters
$class = $invoke->className;
$method = $invoke->method;
$id = $invoke->id;
$output = "null";
$obj = null;

error_log("PAJAX: Dispatching");
// Attempts to load class definition
if ($pajax->loadClass($class)) {	
	/* 
		The session stuff needs to be here, once the class definition has been
		loaded, otherwise the object gets deserialized from the session as 
		__PHP_Incomplete_Class type.
	*/
	session_start();
	if (!session_is_registered('objects')) {
		$_SESSION['objects'] = array();
	} 

	// Get our objects out of the session
	$objects = $_SESSION['objects'];

	// Look if the object exists in the session
	if (isset($objects[$id])) {
		error_log("PAJAX: Restoring object from session");
		$obj = $objects[$id];
	} else {
		if ($pajax->isRemotable($class)) {
			error_log("PAJAX: Creating new object from class '" . $class . "'");	
			eval("\$obj = new $class();");
		} else {
			error_log("PAJAX: Class " . $class . " not remotable");
			$obj = null;
		}
	}
} else {
	error_log("PAJAX: Can't load '" . $class . "'");
}		

if (! is_null($obj) && is_object($obj)) {
	$args="";
	if ($invoke->params != null) {
		for ($i=0; $i<count($invoke->params); $i++) {
			if ($i > 0) {
				$args = $args . ", ";
			}
			$args = $args . $invoke->params[$i];
		}
	}
	
	error_log("PAJAX: Calling " . $class . "->" . $method . "(". $args . ")");

	// Invoking the method with parameters
	$ret = call_user_func_array(array(&$obj, $method), $invoke->params);
	
	error_log("PAJAX: Returned: " . $ret );
	
	$output = $json->encode($ret);

	error_log("PAJAX: Output JSON: " . $output );
	
	$objects[$id] = $obj;
	$_SESSION['objects'] = $objects;
} else {
	error_log("PAJAX: Could not dispatch to valid object");
}

header("Content-Type", "text/json");
print($output);

?>
