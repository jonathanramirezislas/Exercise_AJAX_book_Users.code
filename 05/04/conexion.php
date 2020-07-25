<?php

$hostname = "localhost";
$database = "noticias";
$username = "root";
$password = "";

$cxn = mysql_connect($hostname, $username, $password) or die('Imposible conectar al servidor MySql'); 
$cxn = mysql_select_db($database) or die('Imposible encontrar base de datos');

?>
