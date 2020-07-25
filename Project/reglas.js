Event.observe(window, 'load', inicializar, true);

function inicializar() {
	catalogo = new Catalogo();
	carrito = new Carrito();

	Event.observe($('modoCarrito'), 'click', mostrarCarrito, true);
	Event.observe($('vaciarCarrito'), 'click', vaciarCarrito, true);
	Event.observe($('terminarPedido'), 'click', terminarPedido, true);

	listarCatalogos();
	actualizarCarrito();
}

function listarCatalogos() {

	var catalogos = catalogo.listar_catalogos();

	if (catalogos != null) {
		var catalogos = catalogos.parseJSON();

		var lateral = '';

		catalogos.each(function(c) {
			lateral += '<div onClick="cargarCatalogo(' + c.idCatalogo + ')">' + c.nombreCatalogo + '</div>';
		});

		Element.update($('catalogos'), lateral);
	}
}

function cargarCatalogo(idCatalogo) {
	var productos = catalogo.obtener_productos(idCatalogo);

	if (productos != null) {
		var productos = productos.parseJSON();

		var contenido = '<h2>' + productos[0].nombreCatalogo + '</h2>';

		productos.each(function(c) {
			contenido += '<div style="height: 200px;">';
			contenido += '  <div class="imagen"> <img id="imagen' + c.idProducto + '" onClick="agregarAlCarro(' + c.idProducto + ', \'imagen' + c.idProducto + '\')" src="imagenes/productos/' + c.imagenProducto + '" /> </div>';
			contenido += '  <b>Nombre:</b> ' + c.nombreProducto;
			contenido += '  <br />';
			contenido += '  <b>Descripcion:</b> ' + c.descripcionProducto;
			contenido += '  <br />';
			contenido += '  <b>Precio:</b> $' + c.precioProducto;
			contenido += '  <p class="date"> <a onClick="agregarAlCarro(' + c.idProducto + ', \'imagen' + c.idProducto + '\')" src="' + c.imagenProducto + '">Comprar este producto !</a> </p>';
			contenido += '</div>';
		});

		Element.update($('contenido'), contenido);
	} else {
		Element.update($('contenido'), 'No hay productos para este catalogo');
		new Effect.Highlight($('contenido'));
	}
}

function agregarAlCarro(idProducto, idImagen) {
	carrito.agregar_producto(idProducto);
	new Effect.Pulsate($(idImagen));
	actualizarCarrito();
}

function actualizarCarrito() {
	var items = carrito.recuperar_productos();	

	if (items != null) {
		var items = items.parseJSON();

		var contenidoCarrito = '';

		items.each(function(c) {
			contenidoCarrito += '<div id="item_' + c.idProducto + '" class="items">' + c.cantidad + ' item(s) de "' + c.nombreProducto + '" ($' + c.subtotal + ') </div><br />';
		});

		Element.show($('cestoDeBasura'));
		Element.update($('items'), contenidoCarrito);

		items.each(function(c) {
			new Draggable($('item_' + c.idProducto), {revert: true});
		});

		Droppables.add($('cestoDeBasura'), {
		accept: 'items',
		onDrop: function(element) { actualizarCantidad(element.id); }
		});
	} else {
		Element.hide($('cestoDeBasura'));
		Element.update($('items'), 'No hay items en su carrito');
	}
}

function mostrarCarrito() {
	if (Element.getStyle($('itemsActuales'), 'display') == 'none')	{
		Element.show($('itemsActuales'));	
		Element.update($('modoCarrito'), 'Ocultar Carrito');
	} else {
		Element.hide($('itemsActuales'));	
		Element.update($('modoCarrito'), 'Mostrar Carrito');
	}
}

function vaciarCarrito() {
	carrito.vaciar();
	actualizarCarrito();
}

function terminarPedido() {
	var items = carrito.recuperar_productos();	

	if (items != null) {
		var formulario = 'Complete campos y presione enviar <br /><br />';

		formulario += '<form>';

		formulario += '<div class="container">';
		formulario += '	<div class="label">Nombre: </div>';
		formulario += '	<input type="text" id="nombre">';
		formulario += '</div>';

		formulario += '<div class="container">';
		formulario += '	<div class="label">Apellido: </div>';
		formulario += '	<input type="text" id="apellido">';
		formulario += '</div>';

		formulario += '<div class="container">';
		formulario += '	<div class="label">Direccion: </div>';
		formulario += '	<input type="text" id="direccion">';
		formulario += '</div>';

		formulario += '<div class="container">';
		formulario += '	<div class="label">Telefono: </div>';
		formulario += '	<input type="text" id="telefono">';
		formulario += '</div>';

		formulario += '<div class="container">';
		formulario += '	<div class="label">E-Mail: </div>';
		formulario += '	<input type="text" id="email">';
		formulario += '</div>';

		formulario += '<div class="container">';
		formulario += '	<div class="label">Comentarios: </div>';
		formulario += '	<textarea id="comentarios"> </textarea>';
		formulario += '</div>';

		formulario += '<div class="container">';
		formulario += '	<div class="label"> </div>';
		formulario += '	<span class="submit" id="enviar">>>> enviar</span>';
		formulario += '</div>';

		formulario += '</form>';

		Element.update($('contenido'), formulario);
		Event.observe($('enviar'), 'click', validarFormulario, true);
	} else {
		Element.update($('contenido'), 'No hay items en el carrito !');
		new Effect.Highlight($('contenido'));	
	}
}

function validarFormulario() {
	var flag;
	var campos = $('nombre', 'apellido', 'direccion', 'telefono', 'email');
	campos.each(function(c) {
		if ($F(c) == '') {
			new Effect.Highlight($(c));	
			flag = true;
		}
	});

	if (!flag) { 
		var pedido = new Object();
		pedido.nombre = $F('nombre');
		pedido.apellido = $F('apellido');
		pedido.direccion = $F('direccion');
		pedido.telefono = $F('telefono');
		pedido.email = $F('email');
		pedido.comentarios = $F('comentarios');

		carrito.guardar_pedido(pedido.toJSONString());
		actualizarCarrito();
		Element.update($('contenido'), 'Su pedido ha sido almacenado !');
		new Effect.Highlight($('contenido'));	
	}
}

function actualizarCantidad(idItem) {
	var idProducto = idItem.split("_");
	carrito.actualizar_cantidad(idProducto[1]);
	setTimeout("actualizarCarrito();",2000);
}
