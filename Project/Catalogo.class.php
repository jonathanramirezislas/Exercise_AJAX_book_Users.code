<?php

require_once("pajax/PajaxRemote.class.php");
require_once("pajax/JSON.class.php");
require_once("conexion.php");

class Catalogo extends PajaxRemote {
	function Catalogo() {
	}

	function listar_catalogos() {
		$res = mysql_query("select * from catalogos order by nombreCatalogo");
		if (mysql_num_rows($res)) {
			while ($row = mysql_fetch_array($res)) {
				$catalogo['idCatalogo'] = $row[idCatalogo];
				$catalogo['nombreCatalogo'] = $row[nombreCatalogo];

				$catalogos[] = $catalogo;
			}
			$json = new JSON();
			return $json->encode($catalogos);
		}
	}

	function obtener_productos($idCatalogo) {
		$res = mysql_query("select * from productos, catalogos where productos.idCatalogo = catalogos.idCatalogo and productos.idCatalogo = $idCatalogo order by nombreProducto");
		if (mysql_num_rows($res)) {
			while ($row = mysql_fetch_array($res)) {
				$producto['idProducto'] = $row[idProducto];
				$producto['nombreProducto'] = $row[nombreProducto];
				$producto['descripcionProducto'] = $row[descripcionProducto];
				$producto['imagenProducto'] = $row[imagenProducto];
				$producto['precioProducto'] = $row[precioProducto];
				$producto['nombreCatalogo'] = $row[nombreCatalogo];

				$productos[] = $producto;
			}
			$json = new JSON();
			return $json->encode($productos);
		}
	}
}

?>
