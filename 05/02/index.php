<?php 

include "conexion.php"; 
include "sajax/php/Sajax.php"; 

function recuperarEncuesta($idEncuesta) {
	global $conexion;
	$res = mysqli_query($conexion,"select * from opciones, encuestas where opciones.idEncuesta = encuestas.idEncuesta and opciones.idEncuesta = $idEncuesta order by nombreOpcion");//$idEncuesta
	if (mysqli_num_rows($res)) {
		while ($row = mysqli_fetch_array($res))	{
			$ret .= "<div id='opcion' name='opcion'>";
			$ret .= "<span>$row[idOpcion]</span>";
			$ret .= "<span>$row[nombreOpcion]</span>";
			$ret .= "<span>$row[votos]</span>";
			$ret .= "</div>";
			$totalVotos += $row[votos];
			$tituloEncuesta = $row[nombreEncuesta];
		}
		$ret .= "<div>$totalVotos</div>";
		$ret .= "<div>$tituloEncuesta</div>";
	}
	return $ret;	
}

function votarOpcion($idOpcion) {
	global $conexion;
	$res = mysqli_query($conexion,"update opciones set votos = votos +1 where idOpcion = $idOpcion");
}

sajax_init();
sajax_export("recuperarEncuesta");
sajax_export("votarOpcion");
sajax_handle_client_request();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title> Sajax - Encuestas OnLine </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" href="styles.css" rel="stylesheet" media="screen" />
<SCRIPT LANGUAGE="JavaScript">
<!--
	
	<?php sajax_show_javascript();	?>

	window.onload = function() { setInterval(function(){cargarEncuesta()},20000)};

	function cargarEncuesta() {
		var idEncuesta;
		idEncuesta = document.getElementById("cboEncuesta").value;
		if (idEncuesta != '') {
			x_recuperarEncuesta(idEncuesta, mostrarEncuesta);
		}
	}

	function votar(idOpcion) {
		x_votarOpcion(idOpcion, cargarEncuesta);
	}

	function mostrarEncuesta(resultado) {
		if (resultado != '') {
			var opcion, idOpcion, nombreOpcion, votos, salida = '', tituloEncuesta;			
			var contenedor=document.getElementById("contenedor");

			contenedor.innerHTML=resultado;
			cantidadOpciones = contenedor.getElementsByTagName("div").length -2;
			totalVotos = contenedor.getElementsByTagName("div")[cantidadOpciones].innerHTML;
			tituloEncuesta = contenedor.getElementsByTagName("div")[cantidadOpciones+1].innerHTML;

			for (var c=0; c<cantidadOpciones; c++) {
				opcion = contenedor.getElementsByTagName("div")[c];

				idOpcion = opcion.getElementsByTagName("span")[0].innerHTML;
				nombreOpcion = opcion.getElementsByTagName("span")[1].innerHTML;
				votos = opcion.getElementsByTagName("span")[2].innerHTML;

				porcentaje = parseFloat(votos * 100 / totalVotos);
				porcentaje = porcentaje.toFixed(2);

				if (votos == 1)	votos = votos + ' voto';
				else			votos = votos + ' votos';

				salida = salida + '<div class="nombreOpcion"><a onclick="votar(' + idOpcion + ')">[v]</a> ';
				salida = salida + nombreOpcion + ' [ ' + votos + ', ' + porcentaje + '% ]</div> ';
				salida = salida + '<div class="votos" style="width: ' + porcentaje + 'px;"></div>';
			}

			document.getElementById("tituloEncuesta").innerHTML = tituloEncuesta;
			document.getElementById("resultado").style.display = '';
			document.getElementById("resultado").innerHTML = salida;
		} else {
			document.getElementById("tituloEncuesta").innerHTML = '';
			document.getElementById("resultado").style.display = '';
			document.getElementById("resultado").innerHTML = 'No hay resultados';		
		}
	}

//-->
</SCRIPT>
</head>
<body>

	<div id="contenedor" name="contenedor" style="display: none;"></div>

	<div id="contenido">
		<p>&nbsp;</p>

		<h1><?php buscarEncuestas(); ?></h1>

		<div id="tituloEncuesta" name="tituloEncuesta" class="tituloEncuesta"></div><br /><br />

		<div id="resultado" name="resultado" class="resultado" style="display: none;"></div>
	</div>

</body>
</html>

<?php

function buscarEncuestas() {
global $conexion;
	$res = mysqli_query($conexion,"select * from encuestas order by fechaEncuesta");
	if (mysqli_num_rows($res)) {
		$ret  = "seleccione encuesta: ";
		$ret .= "<select name='cboEncuesta' id='cboEncuesta' onchange='cargarEncuesta()'>";
		$ret .= "<option value=''>-------------------------------------</option>";
		while ($row = mysqli_fetch_array($res))	{
			$ret .= "<option value='$row[idEncuesta]'>$row[nombreEncuesta]</option>";			
		} 
		$ret .= "</select>";
	} else {
		$ret = "No hay encuestas disponibles";
	}

	echo $ret;
}

?>
