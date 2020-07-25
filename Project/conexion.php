<?php

$host = 'localhost';
$usuario = 'root';
$password = '';
$base = 'carrito';

$conexion = mysql_connect("$host", "$usuario", "$password") or die("Error en la conexion");
$base = mysql_select_db("$base") or die("Error en la conexion");

?>
