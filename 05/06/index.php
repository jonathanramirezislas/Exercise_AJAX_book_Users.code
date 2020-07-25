<?php

require_once('xajax/xajax.inc.php');

function procesarFormulario($array) {

	$respuesta = new xajaxResponse();

	if (!trim($array['nombre'])) {
		$salida .= '<li>Complete Nombre';
	}

	if (!trim($array['apellido'])) {
		$salida .= '<li>Complete Apellido';
	}

	if (!trim($array['sexo'])) {
		$salida .= '<li>Seleccione Sexo';
	}

	if (!trim($array['perfil'])) {
		$salida .= '<li>Complete Perfil';
	}

	if ($salida) {
		$respuesta->addAssign("resultado","innerHTML",$salida);
	} else {
		$respuesta->addAssign("submit","disabled","true");

		if ($array[info]) $info = 'Si';
		else $info = 'No';

		$opciones  = "<li>Nombre: $array[nombre]";
		$opciones .= "<li>Apellido: $array[apellido]";
		$opciones .= "<li>Sexo: $array[sexo]";
		$opciones .= "<li>Perfil: $array[perfil]";
		$opciones .= "<li>Informacion adicional?: $info";
		$opciones .= "<br /><br />Gracias por registrarse !";

		$respuesta->addAssign("resultado","innerHTML",$opciones);	
	}

	return $respuesta;	
}

$xajax = new xajax();
$xajax->registerFunction("procesarFormulario");
$xajax->processRequests();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
	<TITLE> xajax </TITLE>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">

	<?php $xajax->printJavascript('xajax/'); ?>

	<script type="text/javascript">
	<!--
	function enviar()
	{
		xajax_procesarFormulario(xajax.getFormValues("formulario"));
	}
	// -->
	</script>

	<style>
	input, select, textarea {
		width: 200px;
		font: 8pt verdana, arial, sans-serif;
	}

	input.noClass {
		width: 12px;
	}

	.submit {
		width: 100px;
		border: 1px solid #000;
		font: 8pt verdana, arial, sans-serif;
	}

	textarea {
		height: 100px;
	}

	.label {
		float: left;
		width: 80px;
		color: #000;
		font: 8pt verdana, arial, sans-serif;
		font-weight: bold;
	}

	.container {
		background-color: #C0C0C0;
		font: 8pt verdana, arial, sans-serif;
		width: 350px;
		padding: 4px;
	}
	</style>
</HEAD>

<BODY>

	<FORM id="formulario" onsubmit="enviar()" action="javascript:function() { return false; }">

		<div class="container">
			<div class="label">Nombre: </div>
			<input type="text" name="nombre">
		</div>

		<div class="container">
			<div class="label">Apellido: </div>
			<input type="text" name="apellido">
		</div>

		<div class="container">
			<div class="label">Sexo: </div>
			<select name="sexo">
			<option value=""></option>
			<option value="M">Masculino</option>
			<option value="F">Femenino</option>
			</select>
		</div>

		<div class="container">
			<div class="label">Perfil: </div>
			<textarea name="perfil"> </textarea>
		</div>

		<div class="container">
			<div class="label"> </div>
			<input type="checkbox" name="info" value="1" class="noClass"> Deseo recibir informacion adicional
		</div>

		<div class="container">
			<div class="label"> </div>
			<input type="submit" name="submit" value="enviar" class="submit">
		</div>

	</FORM>

	<div id="resultado"></div>

</BODY>
</HTML>
