function crearInstancia() {
	XMLHttp = false;

	if (window.XMLHttpRequest) {
		return new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		var versiones = ["Msxml2.XMLHTTP.7.0", "Msxml2.XMLHTTP.6.0", "Msxml2.XMLHTTP.5.0", "Msxml2.XMLHTTP.4.0", "MSXML2.XMLHTTP.3.0", "MSXML2.XMLHTTP", "Microsoft.XMLHTTP"];
		for (var i=0;i<versiones.length;i++) {
			try	{
				XMLHttp = new ActiveXObject(versiones[i]);
				if (XMLHttp) {
					return XMLHttp;
					break;
				}
			} catch (e) {} ;
		}
	}
}

function ingresoChat() {
	var nickname = document.getElementById("nickname").value;	
	var password1 = document.getElementById("password1").value;
	var password2 = document.getElementById("password2").value;

	if (nickname == '' || password1 == '') {
		alert("Complete nickname y password");
	} else if (nickname.length > 15 || nickname.length < 6)	{
		alert("El nickname debe contener entre 6 y 15 caracteres");
	} else {
		if (password2 != '')				{
			if (password1 != password2) {
				alert("Los passwords no coinciden");
			} else						{
				enviarUsuario (nickname, password1, password2);
			}
		} else {
			enviarUsuario (nickname, password1, password2);
		}
	}
}

function enviarUsuario (nickname, password1, password2) {
	var nuevoUsuario = new Object();
	nuevoUsuario.nickname = nickname;
	nuevoUsuario.password1 = password1;
	nuevoUsuario.password2 = password2;	

	XMLHttpIC = crearInstancia();

	if (XMLHttpIC) {
		url="chat.php?nuevoUsuario=" + nuevoUsuario.toJSONString();

		XMLHttpIC.open("POST",url,true)
		XMLHttpIC.onreadystatechange=cambiaEstadoNU 
		XMLHttpIC.send(null)
	} else {
		alert('No se pudo crear la instancia');
	}
}

function cambiaEstadoNU() { 
	if (XMLHttpIC.readyState==4) { 
		if (XMLHttpIC.responseText == 'ok') {
			document.getElementById("login").style.display = 'none';
			document.getElementById("chat").style.display = '';
			document.getElementById("password2").value = '';
			setInterval('cargarHistorial()', 1000);
		} else {
			alert(XMLHttpIC.responseText);
		}
	}	
} 

function cargarHistorial() {
	XMLHttpHistorial = crearInstancia();

	if (XMLHttpHistorial) {
		url="chat.php";
		XMLHttpHistorial.open("POST",url,true)
		XMLHttpHistorial.onreadystatechange=cambiaEstado 
		XMLHttpHistorial.send(null)
	} else {
		alert('No se pudo crear la instancia');
	}
}

function cambiaEstado() { 
	var respuesta;
	if (XMLHttpHistorial.readyState==4) { 
		var mensajes = XMLHttpHistorial.responseText;

		var salida = '';

		if (mensajes != 'null') {
			mensajes = mensajes.parseJSON();

			for (var c=0; c<mensajes.length;c++) {
				if (mensajes[c].autor != '' && mensajes[c].texto != '' && mensajes[c].fecha != '')	{

					var fecha = mensajes[c].fecha;	
					var fecha = fecha.split(" ");	
					var dia = fecha[0].split("-");	 
					var hora = fecha[1].split(":");	 
					var fecha = new Date (dia[2], dia[1], dia[0], hora[0], hora[1], 0);
					var fecha = '[' + dia[0] + '/' + dia[1] + ' @ ' + hora[0] + ':' + hora[1] + ']';

					var fecha = '<span class="fecha">' + fecha + '</span> ';
					var autor = '<span class="autor">' + mensajes[c].autor + '</span>';
					var texto = '<span class="texto">' + mensajes[c].texto + '</span>';

					var salida = salida + fecha + autor + ' dice: ' + texto + '<br />';
				}
			}
		}

		document.getElementById("historial").innerHTML=salida;
		document.getElementById("historial").scrollTop = document.getElementById("historial").scrollHeight;

	}	
} 

function agregarComentario() {
	var comentario = document.getElementById("comentario").value;

	if (comentario == '')	{
		alert("Ingrese mensaje");
	} else							{
		var mensajeAenviar = new Object();
		mensajeAenviar.comentario = comentario;
		var mensaje = mensajeAenviar.toJSONString();

		XMLHttpAC = crearInstancia();

		if (XMLHttpAC) {
			url="chat.php?mensaje=" + mensaje;
			XMLHttpAC.open("POST",url,true)
			XMLHttpAC.onreadystatechange=cambiaEstadoAC 
			XMLHttpAC.send(null)
		} else {
			alert('No se pudo crear la instancia');
		}
	}
}

function cambiaEstadoAC() { 
	if (XMLHttpAC.readyState==4) { 
		if (XMLHttpAC.responseText == 'ok') {
			document.getElementById("comentario").value = '';			
		}
	}	
} 

function mostrarHistorial() {
	var modo = '';
	if (document.getElementById("modoHistorial").innerHTML == 'Completo') {
		document.getElementById("modoHistorial").innerHTML = 'Resumido';
		modo = "?historialCompleto=1";
	} else {
		document.getElementById("modoHistorial").innerHTML = 'Completo';		
		modo = "?historialCompleto=0";
	}

	XMLHttpMH = crearInstancia();

	if (XMLHttpMH) {
		url="chat.php" + modo;
		XMLHttpMH.open("POST",url,true)
		XMLHttpMH.onreadystatechange=cambiaEstadoMH 
		XMLHttpMH.send(null)
	} else {
		alert('No se pudo crear la instancia');
	}
}

function cambiaEstadoMH() { 
	if (XMLHttpMH.readyState==4) { 
		cargarHistorial()
	}	
}

function terminarSesion() {
	XMLHttpTS = crearInstancia();

	if (XMLHttpTS) {
		url="chat.php?terminarSesion=1";
		XMLHttpTS.open("POST",url,true)
		XMLHttpTS.onreadystatechange=cambiaEstadoTS 
		XMLHttpTS.send(null)
	} else {
		alert('No se pudo crear la instancia');
	}
}

function cambiaEstadoTS() { 
	if (XMLHttpTS.readyState==4) { 
		estadoUsuario();
	}	
} 

function estadoUsuario() {
	XMLHttpEU = crearInstancia();

	if (XMLHttpEU) {
		url="chat.php?estadoUsuario=1";
		XMLHttpEU.open("POST",url,true)
		XMLHttpEU.onreadystatechange=cambiaEstadoEU 
		XMLHttpEU.send(null)
	} else {
		alert('No se pudo crear la instancia');
	}		
}

function cambiaEstadoEU() { 
 if (XMLHttpEU.readyState==4) { 
	if (XMLHttpEU.responseText == 'logeado') {
		document.getElementById("login").style.display = 'none';
		document.getElementById("chat").style.display = '';
		setInterval('cargarHistorial()', 1000);
	} else {
		document.getElementById("login").style.display = '';
		document.getElementById("chat").style.display = 'none';
	}
 }	
} 

window.onload = function() { estadoUsuario(); };
