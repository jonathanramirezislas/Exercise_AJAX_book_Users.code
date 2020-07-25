<?php

require_once("pajax/PajaxRemote.class.php");
require_once("pajax/JSON.class.php");
require_once("conexion.php");

class Carrito extends PajaxRemote {

	var $idPedido = false;

	function Carrito() {
	}

	function agregar_producto($idProducto) {
		$this->obtenerIdPedidoActual();

		$res = mysql_query("select * from detalle_pedido where idPedido = ".$this->idPedido." and idProducto = $idProducto");
		if (mysql_num_rows($res)) {
			$sql = "update detalle_pedido set cantidad = cantidad +1 where idProducto = $idProducto";
		} else {
			$resPrecio = mysql_query("select * from productos where idProducto = $idProducto");
			if (mysql_num_rows($resPrecio)) {
				$rowPrecio = mysql_fetch_array($resPrecio);
				$precio = $rowPrecio[precioProducto];
			}

			$sql = "insert into detalle_pedido values (".$this->idPedido.", $idProducto, 1, $precio)";
		}
		$res = mysql_query($sql);
	}

	function recuperar_productos() {
		if ($this->idPedido) {
			$res = mysql_query("select * from productos, detalle_pedido where productos.idProducto=detalle_pedido.idProducto and idPedido = ".$this->idPedido);
			if (mysql_num_rows($res)) {
				while ($row = mysql_fetch_array($res)) {
					$item['idProducto'] = $row[idProducto];
					$item['nombreProducto'] = $row[nombreProducto];
					$item['cantidad'] = $row[cantidad];
					$item['subtotal'] = $row[precioProducto] * $row[cantidad];

					$items[] = $item;					
				}

				$json = new JSON();
				return $json->encode($items);
			}
		}
	}

	function vaciar() {
		if ($this->idPedido) {
			$res = mysql_query("delete from detalle_pedido where idPedido = ".$this->idPedido);
		}
	}

	function actualizar_cantidad($idProducto) {
		$this->obtenerIdPedidoActual();
		$res = mysql_query("select * from detalle_pedido where idPedido = ".$this->idPedido." and idProducto = $idProducto");
		if (mysql_num_rows($res)) {
			$row = mysql_fetch_array($res);
			if ($row[cantidad] == 1) {
				$sql = "delete from detalle_pedido where idProducto = $idProducto";
			} else {
				$sql = "update detalle_pedido set cantidad = cantidad -1 where idProducto = $idProducto";
			}
			$res = mysql_query($sql);
		}
	}

	function guardar_pedido($pedido) {
		if ($this->idPedido) {
			$json = new JSON();
			$pedido = $json->decode($pedido);

			$fechaPedido = date("Y-m-d");
			$nombreUsuario = mysql_escape_string($pedido->nombre);
			$apellidoUsuario = mysql_escape_string($pedido->apellido);
			$direccionUsuario = mysql_escape_string($pedido->direccion);
			$telefonoUsuario = mysql_escape_string($pedido->telefono);
			$emailUsuario = mysql_escape_string($pedido->email);
			$comentarioUsuario = mysql_escape_string($pedido->comentarios);

			$sql  = " update pedido set";
			$sql .= " fechaPedido = '$fechaPedido',";
			$sql .= " nombreUsuario = '$nombreUsuario',";
			$sql .= " apellidoUsuario = '$apellidoUsuario',";
			$sql .= " direccionUsuario = '$direccionUsuario',";
			$sql .= " telefonoUsuario = '$telefonoUsuario',";
			$sql .= " emailUsuario = '$emailUsuario',";
			$sql .= " comentarioUsuario = '$comentarioUsuario',";
			$sql .= " terminado = 1";
			$sql .= " where idPedido = ".$this->idPedido;

			$res = mysql_query($sql);

			$this->idPedido = false;
		}
	}

	function obtenerIdPedidoActual() {
		if (!$this->idPedido) {
			$res = mysql_query("insert into pedido (terminado) values (0)");
			$this->idPedido = mysql_insert_id(); 	
		}
	}
}

?>
