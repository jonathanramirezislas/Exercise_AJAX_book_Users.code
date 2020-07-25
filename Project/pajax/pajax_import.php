<?php
/*                                                                              
    Pajax - Remote (a)synchronous PHP objects in JavaScript.                                    
                                                                              
    (c) Copyright 2005 by Georges Auberger                                            
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
	Creates the necessary JavaScript stub for a remote php class
*/

require_once("Pajax.class.php");

header("Content-Type: text/javascript");

$pajax = new Pajax(substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], "/")+1));	
$class = $_SERVER['QUERY_STRING'];

if ($class != "") {
	// Generate class stubs for the remotable classes 
	if ($pajax->loadClass($class)) {
		echo $pajax->getJavaScriptStub($class);
	} else {
		error_log("PAJAX: Can't load '" . $class . "'");
		echo "// Can't load '" . $class . "'";
	}		
} else {
	error_log("PAJAX: Class '" . $class . "' not valid");
	echo "// Class '" . $class . "' not valid! ";
}
?>

