window.onload = registrar;

function registrar() {
	var o = document.getElementById("enviar");
	o.onclick = validar;
}

function validar() {
	ajax = crearInstancia(); 
	if (ajax) {
		var nombre = document.getElementById("nombre").value;  
		var apellido = document.getElementById("apellido").value;   
		var correo = document.getElementById("correo").value;  
		var titulo = document.getElementById("titulo").value;  
		var nivel = document.getElementById("nivel").value;  
		var pretensiones = document.getElementById("pretensiones").value;  

		var parametros = "nombre=" + nombre;
		parametros = parametros + "&apellido=" + apellido;
		parametros = parametros + "&correo=" + correo;
		parametros = parametros + "&titulo=" + titulo;
		parametros = parametros + "&nivel=" + nivel;
		parametros = parametros + "&pretensiones=" + pretensiones;

		url = "procesarFormulario.php";
		ajax.onreadystatechange=tratarRespuesta;
		ajax.open('POST', url, true);
		ajax.send(parametros);
	}
}

function tratarRespuesta() {
    if (ajax.readyState == 1) {
		ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	}

	if (ajax.readyState == 4){
		alert(ajax.responseText);
	}
}

function crearInstancia() {
	XMLHttp = false;

	if (window.XMLHttpRequest) {
		return new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		var versiones = ["Msxml2.XMLHTTP.7.0", "Msxml2.XMLHTTP.6.0", "Msxml2.XMLHTTP.5.0", "Msxml2.XMLHTTP.4.0", "Msxml2.XMLHTTP.3.0", "Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];
		for (var i=0;i<versiones.length;i++) {
			try	{
				XMLHttp = new ActiveXObject(versiones[i]);
				if (XMLHttp) {
					return XMLHttp;
					break;
				}
			} catch (e) {};
		}
	}
}
