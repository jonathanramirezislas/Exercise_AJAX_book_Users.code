<?php 

require("./sajax/php/Sajax.php"); 

function saludar($nombre) {
	return "Hola $nombre";
}

sajax_init();
sajax_export("saludar");
sajax_handle_client_request();
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> Sajax </TITLE>
<SCRIPT LANGUAGE="JavaScript">
<!--
	<?php sajax_show_javascript();	?>
	
	function contenedor(resultado) {
		alert(resultado);
	}
	
	function generarSaludo() {
		var nombre = document.getElementById("nombre").value;
		x_saludar(nombre, contenedor);
	}
//-->
</SCRIPT>
</HEAD>
<BODY>
	ingrese su nombre : <input type="text" name="nombre" id="nombre" value="" size="35">
	<br />y presione saludar : <input type="button" value="saludar" onclick="generarSaludo(); return false;">
</BODY>
</HTML>
