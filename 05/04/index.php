<?php 

include 'conexion.php';
include 'xajax/xajax.inc.php'; 

function listar($fecha) {

	$anio = substr($fecha, 0, 4);
	$mes = substr($fecha, 4);

	$res = mysql_query("select idNoticia, tituloNoticia, DATE_FORMAT(fechaNoticia, '%h:%i %p') as hora from noticias where YEAR(fechaNoticia) = $anio and MONTH(fechaNoticia) = $mes order by fechaNoticia desc");

	if (mysql_num_rows($res)) {

		while ($row = mysql_fetch_array($res)) {
			$texto .= '<a onclick="xajax_verDetalle('.$row[idNoticia].');" href="javascript: ;">'.$row[hora].': '.$row[tituloNoticia].'</a>';
		}
	}

	$repuesta = new xajaxResponse('iso-8859-1');

	$repuesta->addAssign("noticias","innerHTML",$texto);

	return $repuesta;
}

function verDetalle($idNoticia) {
	$res = mysql_query("select * from noticias where idNoticia = $idNoticia");
	if (mysql_num_rows($res)) {
		$row = mysql_fetch_array($res);

		//noticia
		$fragmento  = "<li class='titulo'>$row[tituloNoticia]</li>";
		$fragmento .= "<p>".nl2br($row[textoNoticia])."</p>";

		//comentarios
		$resCom = mysql_query("select DATE_FORMAT(fechaComentario, '%d/%m/%Y @ %l:%i%p' ) as fecha, autorComentario, emailautorComentario, textoComentario from comentarios where idNoticia = $idNoticia order by fechaComentario");
		if (mysql_num_rows($resCom)) {
			$fragmentoComentarios  = "<li class='titulo'>Comentarios (".mysql_num_rows($resCom).")</li>";
			while ($rowCom = mysql_fetch_array($resCom)) {
				$fragmentoComentarios .= "<p># el $rowCom[fecha] $rowCom[autorComentario] ($rowCom[emailautorComentario]) escribio: <br />".nl2br($rowCom[textoComentario])."<br /><br /></p>";
			}
		} else {
			$fragmentoComentarios  = "<li class='titulo'>Comentarios (0)</li>";
			$fragmentoComentarios .= "<p>No hay comentarios para esta noticia.</p>";		
		}

		//nuevo comentario
		$fragmentoNuevoComentario  = "<li class='titulo'>Ingresar nuevo comentario</li>";
		$fragmentoNuevoComentario .= "<div class='label'>Su nombre: </div> <div class='field'><input type='text' id='formNombre'></div>";		
		$fragmentoNuevoComentario .= "<div class='label'>Su email: </div> <div class='field'><input type='text' id='formEmail'></div>";		
		$fragmentoNuevoComentario .= "<div class='label'>Su comentario: </div> <div class='field'><textarea id='formComentario'></textarea></div>";		
		$fragmentoNuevoComentario .= "<div class='submit'> <input type='button' value='Enviar' onclick='agregarComentario()'> </div> ";

		$repuesta = new xajaxResponse('iso-8859-1');

		$repuesta->addAssign("detalleNoticia","innerHTML",$fragmento);
		$repuesta->addAssign("comentariosNoticia","innerHTML",$fragmentoComentarios);
		$repuesta->addAssign("nuevoComentarioNoticia","innerHTML",$fragmentoNuevoComentario);

		$repuesta->addAssign("idNoticia","value",$idNoticia);

		$repuesta->addScriptCall("mostrarMensaje", "0");
	}
	return $repuesta;
}

function agregarComentario($idNoticia, $nombre, $email, $comentario) {
	$res = mysql_query("insert into comentarios (idNoticia, autorComentario, emailautorComentario, textoComentario, fechaComentario) values ($idNoticia, '$nombre', '$email', '$comentario', '".date("Y-m-d H:i:s")."')");

	$resCom = mysql_query("select DATE_FORMAT(fechaComentario, '%d/%m/%Y @ %l:%i%p' ) as fecha, autorComentario, emailautorComentario, textoComentario from comentarios where idNoticia = $idNoticia order by fechaComentario");
	if (mysql_num_rows($resCom)) {
		
		$fragmentoComentarios  = "<li class='titulo'>Comentarios (".mysql_num_rows($resCom).")</li>";

		while ($rowCom = mysql_fetch_array($resCom)) {
			$fragmentoComentarios .= "<p># el $rowCom[fecha] $rowCom[autorComentario] ($rowCom[emailautorComentario]) escribio: <br />".nl2br($rowCom[textoComentario])."<br /><br /></p>";
		}

		$repuesta = new xajaxResponse('iso-8859-1');

		$repuesta->addAssign("comentariosNoticia","innerHTML",$fragmentoComentarios);

		$repuesta->addClear('formNombre', 'value');
		$repuesta->addClear('formEmail', 'value');
		$repuesta->addClear('formComentario', 'value');
		$repuesta->addAssign('mensajeNuevoComentarioNoticia', 'innerHTML', 'Mensaje agregado !');
		$repuesta->addScriptCall("setTimeout", "mostrarMensaje('0')", 2000);
	}

	return $repuesta;
}

$xajax = new xajax(); 

$xajax->registerFunction("listar"); 
$xajax->registerFunction("verDetalle"); 
$xajax->registerFunction("agregarComentario"); 

$xajax->processRequests(); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="robots" content="all" />

	<title> xajax </title>

	<?php $xajax->printJavascript('xajax/'); ?>
	
	<style type="text/css" media="all">
		@import url(style.css);
	</style>

	<SCRIPT LANGUAGE="JavaScript">

	window.onload = function() { xajax_listar(document.getElementById('fechaListado').value); };

	function agregarComentario() {
		var idNoticia = document.getElementById('idNoticia').value;
		var formNombre = document.getElementById('formNombre').value;
		var formEmail = document.getElementById('formEmail').value; 
		var formComentario = document.getElementById('formComentario').value; 

		if (trim(formNombre) != '' && trim(formEmail) != '' && trim(formComentario) != '')	{
			xajax_agregarComentario(idNoticia, formNombre, formEmail, formComentario);
		} else {
			mostrarMensaje('1');
		}
	}

	function trim(str) {
		return str.replace(/^\s*|\s*$/g,"");
	}

	function mostrarMensaje(modo) {
		if (modo == '1') {
			document.getElementById('mensajeNuevoComentarioNoticia').innerHTML = 'Complete campos obligatorios';
			document.getElementById('mensajeNuevoComentarioNoticia').style.display = '';
		} else {
			document.getElementById('mensajeNuevoComentarioNoticia').innerHTML = '';
			document.getElementById('mensajeNuevoComentarioNoticia').style.display = 'none';		
		}
	}
	</SCRIPT>

</head>

<body>

<div id="contain">

	<div id="header">

		<h1>Diario de noticias</h1>

	</div>

	<div id="leftcol">

		<h2>Buscar ...</h2>

		<p>

		Filtro de noticias por fecha.

		<br />
		<br />

		<select id="fechaListado" onchange="xajax_listar(this.value)">
			<?php

			$mes[1] = 'Enero';
			$mes[]  = 'Febrero';
			$mes[]  = 'Marzo';
			$mes[]  = 'Abril';
			$mes[]  = 'Mayo';
			$mes[]  = 'Junio';
			$mes[]  = 'Julio';
			$mes[]  = 'Agosto';
			$mes[]  = 'Septiembre';
			$mes[]  = 'Octubre';
			$mes[]  = 'Noviembre';
			$mes[]  = 'Diciembre';

			$res = mysql_query("select YEAR(fechaNoticia), MONTH(fechaNoticia) from noticias group by YEAR(fechaNoticia), MONTH(fechaNoticia) order by fechaNoticia desc");
			if (mysql_num_rows($res)) {
				while ($row = mysql_fetch_row($res)) {
					$a = $row[0];
					$m = $mes[$row[1]];

					echo "<option value='$a$row[1]'>$a / $m</option>";
				}
			}

			?>
		</select>

		</p>

	</div>

	<div id="content" class="contenido">

		<h2>Noticias ...</h2>

		<div id="noticias" class="noticias"> </div>

		<div id="detalleNoticia" class="detalleNoticia"> </div>

		<div id="comentariosNoticia" class="detalleNoticia"> </div>

		<div id="nuevoComentarioNoticia" class="detalleNoticia"> </div>

		<div id='mensajeNuevoComentarioNoticia' class='mensajeError' style='display: none'> </div>

		<br />

	</div>

	<div id="footer">
		<p> php, ejemplo Xajax, diario de noticias, 2006 </p>
	</div>

</div>

<input type='hidden' id='idNoticia'>

</body>
</html>
