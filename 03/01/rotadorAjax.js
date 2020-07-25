function crearInstancia() {
	XMLHttp = false;

	if (window.XMLHttpRequest) {
		return new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		var versiones = ["Msxml2.XMLHTTP.7.0",   "Msxml2.XMLHTTP.6.0", "Msxml2.XMLHTTP.5.0", "Msxml2.XMLHTTP.4.0", "Msxml2.XMLHTTP.3.0", "Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];
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

function mostrarBanner(){
	delay = 1000
	contenedorBanner="divBanner" 
	banners=[]
	indice=0
	XMLHttp=crearInstancia()
	document.write('<div id="'+contenedorBanner+'"><div>... cargando banners ...</div></div>')
	if (XMLHttp){
		url = "banners.txt"
		XMLHttp.onreadystatechange=cambiaEstado
		XMLHttp.open('GET', url, true)
		XMLHttp.send(null)
	}
}

function cambiaEstado(){ 
	if (XMLHttp.readyState == 4){
		contenidoDiv=document.getElementById(contenedorBanner).firstChild
		var respuesta=XMLHttp.responseText
		contenidoDiv.innerHTML=respuesta
		if (contenidoDiv.getElementsByTagName("div").length==0){
			contenidoDiv.innerHTML="Banners no disponibles"
			return
		}

		for (var i=0; i<contenidoDiv.getElementsByTagName("div").length; i++){
			banners[banners.length]=contenidoDiv.getElementsByTagName("div")[i].innerHTML
		}
		
		rotarBanner()
	}
}

function rotarBanner(){
	contenidoDiv.innerHTML=banners[indice]
	indice=(indice<banners.length-1)? indice+1 : 0
	setTimeout(function(){rotarBanner()}, delay)
}
