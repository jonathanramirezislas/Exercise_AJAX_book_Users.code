<?php

foreach($_POST as $clave => $valor) {
	$_POST[$clave] = trim($valor);
}

if (!$_POST[nombre])	
	$mensaje .= "- Complete nombre\n";

if (!$_POST[apellido])	
	$mensaje .= "- Complete apellido\n";

if (!$_POST[correo])	
	$mensaje .= "- Complete correo eletronico\n";

if (!$_POST[titulo])	
	$mensaje .= "- Complete titulo\n";

if (!$_POST[nivel])		
	$mensaje .= "- Seleccione nivel academico\n";

if (!$_POST[pretensiones])	
	$mensaje .= "- Complete pretensiones\n";

if ($mensaje)
	echo $mensaje;
else
	echo 'Gracias por registrarse !';

?>
