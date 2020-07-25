<?php session_start();

include 'JSON/JSON.php';

$json = new Services_JSON();

if (is_array($_GET)) {
	foreach ($_GET as $clave => $valor) {
		$_GET[$clave] = stripslashes($valor);
	}
}

if (!isset($_SESSION[historialCompleto]) || $_GET[historialCompleto] == '0')
	$_SESSION[historialCompleto] = false;
elseif ($_GET[historialCompleto]==1)
	$_SESSION[historialCompleto] = true;


if ($_GET[estadoUsuario]) {
	if ($_SESSION[nickname])	echo 'logeado';
	else						echo 'no logeado';

} elseif ($_GET[terminarSesion])  {
	session_unregister('nickname');
	session_unregister('historialCompleto');

} elseif ($_GET[nuevoUsuario])  {
	$json = $json->decode($_GET[nuevoUsuario]);

	$nickname = $json->nickname;
	$password1 = $json->password1; 
	$password2 = $json->password2; 	

	if ($password2) {
		$fd = fopen ("usuarios.txt", "r");
		while (!feof($fd)) {
			$linea = fgets($fd, 4096);
			$usuario = substr($linea, 0, 15);
			if (trim(strtolower($usuario)) == trim(strtolower($nickname))) {
				$usuarioYaExiste = true;
				break;
			}
		}
		fclose ($fd); 

		if ($usuarioYaExiste)	{
			echo 'Por favor elija otro nickname';
		} else					{
			$fd = fopen ("usuarios.txt", "a+");
			$nickname = str_pad($nickname, 15);
			$nuevoUsuario = $nickname.$password1."\n";
			fwrite($fd, $nuevoUsuario);
			fclose ($fd); 

			$_SESSION[nickname] = $nickname;
			echo 'ok';
		}
	} else			{
		$fd = fopen ("usuarios.txt", "r");

		while (!feof($fd)) {
			$linea = fgets($fd, 4096);
			$usuario = substr($linea, 0, 15);
			$password = substr($linea, 15);
			if (trim(strtolower($usuario)) == trim(strtolower($nickname)) && trim(strtolower($password)) == trim(strtolower($password1))) {
				$usuarioExiste = true;
				break;
			}
		}

		if ($usuarioExiste)	{
			$_SESSION[nickname] = $nickname;
			echo 'ok';
		} else					{
			echo 'El nickname / password es incorrecto';
		}

		fclose ($fd); 
	}

} elseif ($_GET[mensaje]) {
	$json = $json->decode($_GET[mensaje]);

	$autor = str_pad($_SESSION[nickname], 15);
	$comentario = htmlentities($json->comentario); 
	$fecha = date("d-m-Y H:i");

	$mensaje = $fecha.$autor.$comentario."\n";

	$fd = fopen ("chat.txt", "a+");
	fwrite($fd, $mensaje);
	fclose ($fd); 

	echo 'ok';

} else				{
	if ($_SESSION[historialCompleto]) {
		$fd = fopen ("chat.txt", "r");

		while (!feof($fd)) {
			$linea = fgets($fd, 4096);
			$fecha = substr($linea, 0, 16);
			$autor = substr($linea, 16, 15);
			$texto = substr($linea, 31);
			$mensaje[] = Array('fecha' => $fecha, 'autor' => $autor, 'texto' => $texto);
		}

		fclose ($fd); 
	} else {
		$mensajes = file("chat.txt");

		if (is_array($mensajes)) {
			$cantidadAmostrar = 10;
			$cantidadMensajes = count($mensajes);

			if ($cantidadMensajes > $cantidadAmostrar) {
				$aMensajes = array_slice($mensajes, ($cantidadMensajes-$cantidadAmostrar), $cantidadAmostrar);
			} else {
				$aMensajes = $mensajes;
			}
		}

		foreach($aMensajes as $linea) {
			$fecha = substr($linea, 0, 16);
			$autor = substr($linea, 16, 15);
			$texto = substr($linea, 31);
			$mensaje[] = Array('fecha' => $fecha, 'autor' => $autor, 'texto' => $texto);
		}

	}

	echo $json->encode($mensaje);
}

?>