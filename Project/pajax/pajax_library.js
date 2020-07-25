/*                                                                              
   Pajax - Remote (a)synchronous PHP objects in JavaScript.                                    
                                                                              
   Copyright 2005 by Georges Auberger                                            
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
	Package: pajax_library.js
	Main JavaScript library for object remoting
*/

/*
	This is used to define unique id's for local objects
*/
var __pajax_id_count = 0;
function __pajax_get_next_id() {
	__pajax_id_count++;
	return __pajax_id_count;
}

/*
	This is needed because IE has a memory leak problem when creating multiple http objects
*/
var __pajax_http_obj = null;

/*
	Method: toJSON
	JSON Serializer/deserializer methods
*/
Object.prototype.toJSON = function() {
	var stack=[];
	var oBag;
	var sBag;
	for (property in this) {
		if (typeof this[property] != "function") {
			stack.push('"' + property + '": ' + (this[property] == null ? "null" : this[property].toJSON()));
		}
	}
	// Only cares if this is a subclass of Object
	if (this.getClassName() != "Object") {
		sBag = "";
		oBag = this.onDeflate();
		if (oBag) {
			sBag = oBag.toJSON();
		}
		stack.push('"__pajax_class_hint" : { "className" : "' + this.getClassName() + '" , "bag" : "' + sBag + '" }');
	}
	return "{" + stack.join(", ") + "}";
}

Object.prototype.onDeflate = function() { return null; }
Object.prototype.onInflate = function(o) { }

Object.prototype.fixClass = function() {
	var o;
	if (this.__pajax_class_hint) {
		cn = this.__pajax_class_hint.className;
		bag  = this.__pajax_class_hint.bag;
		eval("__pajax_o = new " + cn + "();");
		o = __pajax_o;
		for (property in this) {
			if (typeof this[property] != "function" && property != "__pajax_class_hint") {
				if (this[property]) {
					o[property] = this[property].fixClass();
				} else {
					o[property] = null;
				}
			}
		}
		if (o && bag) {
			o.onInflate(bag.fromJSON());
		}
		return o;
	} else {
		// No class hint, no need to fix anything
		return this;
	}
}

Object.prototype.getClassName = function() {
	if (this.constructor.toString) {
		var a = this.constructor.toString().match(/function\s*(\w+)/);
		return a && a.length == 2 ? a[1] : undefined;
	} else {
		return undefined;
	}
}

String.prototype.toJSON = function() {
	var s = '"' + this.replace(/(["\\])/g, '\\$1') + '"';
	return s.replace(/(\n)/g,"\\n");
}
    
String.prototype.fromJSON = function() {
	var t;
//	eval("__pajax_temp = \"" + escape(this.valueOf()) + "\""); 	
eval("__pajax_temp = " + this.valueOf() ); 	

	t = __pajax_temp;
	if (t != null) {
		return t.fixClass();
	}
	return t;
}

String.prototype.fixClass = function() { 
	return this.valueOf();
}

Number.prototype.toJSON = function() {
    return this.toString();
}

Number.prototype.fixClass = function() { 
	return this.valueOf();
}
    
Boolean.prototype.toJSON = function() {
    return this.toString();
}

Boolean.prototype.fixClass = function() { 
	return this.valueOf();
}

Array.prototype.toJSON = function() {
	var stack = [];
	for (var i=0; i < this.length; i++) {
		stack.push(this[i] == null ? "null" : this[i].toJSON()) ;
	}
	return "[" + stack.join(", ") + "]";
}

Array.prototype.fixClass = function() {
	for (i in this) {
		if (this[i]) {
			this[i] = this[i].fixClass();
		}
	}
	return this;
}

Date.prototype.onDeflate = function() {
	return this.getTime();
}

Date.prototype.onInflate = function(s) {
	this.setTime(s);
}
   
/*
	Class: PajaxConnection
	Takes care of the HTTP Connection and marshalling of calls
*/

/* 
	Constructor: PajaxConnection
	
	Parameters:
		url - Url to dispatch the call to
*/
function PajaxConnection(url) { 
		this.url = url;
}

/*
	Method: getXmlhttp
	Returns a handle of the xmlhttp object for various browsers
	
	Returns:
		xmlhttp object or null if not able to instanciate it
*/
PajaxConnection.prototype.getXmlhttp = function () {
	if (__pajax_http_obj == null) {
		if (window.XMLHttpRequest) {
			__pajax_http_obj = new XMLHttpRequest();
		} else if (window.ActiveXObject) {
			try {
				__pajax_http_obj = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					__pajax_http_obj = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {
					__pajax_http_obj = null;
				}
			} 
		}
	}
	return __pajax_http_obj;
}

/*
	Method: sendSynch
	Invoke the dispatcher synchronously

	Parameters:
		request - Request object. It will be serialized before the call is made
		
	Returns:
		Deserialized object received from the call
		Null if call fails
*/
PajaxConnection.prototype.sendSynch = function (request) {
	var xmlhttp = this.getXmlhttp();
	if (xmlhttp) {
		xmlhttp.onreadystatechange = function() { };
		try {
			xmlhttp.open("POST", this.url, false);
		} catch(e) {
			throw "Can't open this url: " + this.url;
		}
		xmlhttp.setRequestHeader('Content-Type','text/json');		
		xmlhttp.send(request.toJSON());
		
		return xmlhttp.responseText.fromJSON();
	}
	return null;
}

/*
	Method: sendAsynch
	Invoke the dispatcher asynchronously

	Parameters:
		request - Request object. It will be serialized before the call is made
		listener - Listener object. The corresponding "on"+methodName method will be 
		invoked on the listener object with the result of the call
		
	Returns:
		true - Call succeded
		fals - Call failed
*/
PajaxConnection.prototype.sendAsynch = function (request, listener) {			
	var xmlhttp = this.getXmlhttp();
	if (xmlhttp) {
		xmlhttp.onreadystatechange = function() {  
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) { 
				var result = xmlhttp.responseText.fromJSON(); 
				if (request.method != null && request.method.length > 0) {
					cbmethod = "on" + request.method.substring(0, 1).toUpperCase() + request.method.substring(1, request.method.length);
				}
				eval("listener." + cbmethod + "(result);"); 
			};			
		}
		xmlhttp.open("POST", this.url, true);
		xmlhttp.setRequestHeader('Content-Type','text/json');		
		listener.onBeforeCall();
		xmlhttp.send(request.toJSON());
		listener.onAfterCall();
		return true;
	}
	return false;
}

/*
	Method: remoteCall
	Performs a remote call asynchronously or synchronously. Takes care of marshalling
	the paremeters.

	Parameters:
		id - Internal id of the object to be invoked
		className - Class name of the object to invoke
		method - Method to invoke
		params - Arrays of parameters for this method
		listener - Listener object for this class. If not present, the call is synchronous. 
		If present, the call is asynchronous and the method on<method> is invoked on the listener
		object with the result of the call passed as a parameter.
	
	Returns:
		true/false if asynchronous
		Object returned for synchrous calls
*/
PajaxConnection.prototype.remoteCall = function (id, className, method, params, listener) {
	// Marshals the parameters for the remote invocation
	var request = new Object();
	request.id = id;
	request.className = className;
	request.method = method;
	request.params = params;
	
	if (listener) {
		return this.sendAsynch(request, listener);
	} else {
		return this.sendSynch(request);
	}
}

/*
	Class: PajaxListener
	Base class for asynchronous callback listener
*/
/*
	Constructor: PajaxListener
*/
function PajaxListener() { };
/*
	Method: onBeforeCall
	Invoked before an asynchronous call takes place
*/
PajaxListener.prototype.onBeforeCall = function() {};
/*
	Method: onAfterCall
	Invoked after an asynchronous call takes place
*/
PajaxListener.prototype.onAfterCall = function() {};
/*
	Method: onError
	Invoked in case of error
*/
PajaxListener.prototype.onError = function() {};

