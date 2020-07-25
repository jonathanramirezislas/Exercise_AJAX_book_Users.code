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

function cargarDatos(){
	XMLHttp=crearInstancia()
	if (XMLHttp){
		url = "datos.xml"
		XMLHttp.onreadystatechange=cambiaEstado
		XMLHttp.open('GET', url, true)
		XMLHttp.send(null)
	}
}

function cambiaEstado(){ 
 if (XMLHttp.readyState == 4){
  var respuesta=XMLHttp.responseXML
  if (respuesta.documentElement.nodeName)
  {
   var nContinente = document.getElementById("nContinente").value
   var imagen, continentes
   document.getElementById("salida1").innerHTML = '&nbsp;'
   var salida = ''
   continentes = respuesta.getElementsByTagName("continente")	

   for (var c=0;c<continentes.length;c++) {
    continente = continentes[c].getElementsByTagName("nombre")[0].firstChild.nodeValue
    if (nContinente == continente) {

     imagen = continentes[c].getElementsByTagName("imagen")[0].firstChild.nodeValue
     superficie = continentes[c].getElementsByTagName("superficie")[0].firstChild.nodeValue
     descripcion = continentes[c].getElementsByTagName("descripcion")[0].firstChild.nodeValue

     salida = '<br />' + salida + 'Continente: ' + nContinente + '<br /><br />'

     paises = continentes[c].getElementsByTagName("paises")[0].getElementsByTagName("nombre")
     
     for (var i=0;i<paises.length;i++) {
      salida = salida + '> Pais # ' + (i+1) + ': ' + paises[i].firstChild.nodeValue + '<br />'
     }

     salida = salida + '<br />' + descripcion + '<br /><br />'

     salida = salida + 'Supeficie (km2): ' + superficie + '<br /><br />'

     salida = salida + '<br />'

     break;
     }
    }

    if (!salida) salida = 'No se encontro informacion.';

    document.getElementById("salida1").innerHTML = salida

    document.getElementById("salida2").innerHTML = '<img src="' + imagen + '">'
   }
  }
}
