<?php

require_once('xajax/xajax.inc.php');

$xajax = new xajax();
$xajax->setCharEncoding('iso-8859-1');
$xajax->registerExternalFunction("buscarEstados", "funciones.php");
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
	function agregarOpcion(idSelect, texto, valor)
	{
		var opcion = new Option(texto,valor);
		document.getElementById(idSelect).options.add(opcion);
	}
	// -->
	</script>

	<style>
	select 
	{
		width: 200px;
	}

	.label 
	{
		float: left;
		width: 140px;
	}
	</style>
</HEAD>

<BODY>

	<div>
		<div class="label">Seleccione Pais: </div>
		<select onchange="xajax_buscarEstados(this.value);">
		<option value="">-- Seleccione Pais --</option>
		<option value="BR">Brasil</option>
		<option value="US">United States</option>
		</select>
	</div>

	<div id="estados" style="display: none;">
		<div class="label">Seleccione Estado: </div>
		<select id="cboEstados"> </select>
	</div>


</BODY>
</HTML>
