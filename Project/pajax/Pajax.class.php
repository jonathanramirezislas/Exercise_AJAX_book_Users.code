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

define('CLASS_PATH_DELIMITER', ":");

/*
	Class: Pajax
	Main Class for Pajax system
	Create JavaScript stubs and takes care of class loading of php objects
*/
class Pajax {
	/*
		Constructor: Pajax
		
		Parameters:
			uriPath - URI path to the pajax system
			dispatcher - Name of the script used by the http callback
			classPath - Paths of remote class, seperated by ":"
	
	*/
	function Pajax(	$uriPath="/pajax/",
					$dispatcher="pajax_call_dispatcher.php", 
					$classPath="..:../test") {
		$this->uriPath = $uriPath;
		$this->dispatcher = $dispatcher;
		$this->classPath = $classPath;
	}

	/*
		Method: loadClass
		Dynamically load a class file
		
		Parameters:
			className - Class to be loaded. It will look for a file that is
			sufixed by ".class.php"
		
		Returns:
			true - Class loaded successfully
			false - Failed to load class
	*/
	function loadClass($className) {
		// Strip path chars from classname
		$className = str_replace(array(".", "/", "\\", ".."), "", $className);
		$paths = split(CLASS_PATH_DELIMITER, $this->classPath);
		foreach ($paths as $path) {
			$classPath = $path . "/" . $className . ".class.php";
			$root = $_SERVER['PATH_TRANSLATED'];
			if (file_exists ($classPath)) {
				require_once($classPath);
				return class_exists($className);
			}
		}
		return false;
	}

	/*
		Method: isRemotable
		Determines if a class can be invoked remotly
		
		Parameters:
			className - Class name to check. It expects the class to be loaded already
		
		Returns:
			true - Class is a subclass of PajaxRemote
			false - Otherwise
	*/
	function isRemotable($className) {
		if (class_exists($className)) {
			eval("\$obj = new $className();");
			return strtolower(get_parent_class($obj)) == strtolower("PajaxRemote");
		} else {
			return false;
		}
	}
	
	/*
		Method: getJavaScriptStub
		Return the JavaScript stub class equivalent for a php class
		
		Parameters:
			className - Class name to build stub for. It expects the class to be loaded already. 

		Returns:
			String contain JavaScript stub for the Class. If the class is not remotable, 
			it will return a string with an error surrounded by html comments tag. 
			
	*/
	function getJavaScriptStub($className) {
		if (! $this->isRemotable($className)) {
			return "<!-- Class '". $className . "' is not remotable -->";
		}
	
		$classMethods = get_class_methods($className);
		ob_start();			
?>
		
function <?php echo $className ?>(listener) {
	this.__pajax_object_id = "<?php echo md5(uniqid(rand(), true))?>" + __pajax_get_next_id();
	this.__pajax_listener = listener;
}

function <?php echo $className ?>Listener() { };
<?php echo $className."Listener.prototype = new PajaxListener();" ?>
				
<?php
		// Create a stub function for each method
		foreach ($classMethods as $methodName) {
		
			// Skip the constructors
			if (strtolower($methodName) != strtolower($className) && strtolower($methodName) != strtolower("PajaxRemote")) {
				/* 
				 In each method, copy the argument because arguments scope is 
				 lost if passed to another function. There seems to always
				 be an argument present even if invoked with none, take that into 
				 account.
				 
				 Create an empty stub for call back if the class is to be used
				 asynchronously. These methods are meant to be overriden in the 
				 client
				*/
?>

<?php echo $className."Listener.prototype.on".ucfirst($methodName)?>=function(result) {};

<?php echo $className.".prototype.".$methodName?> = function() {
	if (arguments.length > 0 && typeof arguments[0] != 'undefined' ) {
		params = new Array();
		for (var i = 0; i < arguments.length; i++) {
			params[i] = arguments[i];
		}
	} else {
		params = null;
	}
	
	return new PajaxConnection("<?php echo $this->uriPath . $this->dispatcher?>").remoteCall(this.__pajax_object_id, "<?php echo $className ?>", "<?php echo $methodName ?>", params, this.__pajax_listener);
}
	
<?php	
			}
		}

		$html = ob_get_contents();
		ob_end_clean();
		return $html;		
	}
}

?>
