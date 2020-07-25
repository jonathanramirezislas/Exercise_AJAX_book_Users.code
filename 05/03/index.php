<?php

function saludo() {
	$respuesta = new xajaxResponse();
	$respuesta->addAssign("respuesta","style.display","");
	$respuesta->addAssign("respuesta","style.color","#FF0000");
	$respuesta->addPrepend("respuesta","innerHTML","Hola ");
	$respuesta->addAppend("respuesta","innerHTML",", que tenga un buen dia.");
	return $respuesta;
}

require_once("xajax/xajax.inc.php");

$xajax = new xajax();

$xajax->registerFunction("saludo");

$xajax->processRequests();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
    <TITLE> Xajax </TITLE>
    <?php $xajax->printJavascript('xajax/'); ?>
</HEAD>

<BODY>

<a style="cursor: pointer;" onclick="xajax_saludo()"> Saludar ! </a>

<br />
<br />

<div id="respuesta" style="display: none;">Juan</div>

</BODY>
</HTML>
