<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title> carrito de compras </title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<script type="text/javascript" src="prototype.js"></script>
	<script type="text/javascript" src="scriptaculous/scriptaculous.js"></script>
	<script type="text/javascript" src="json.js"></script>
	<script type="text/javascript" src="pajax/pajax_library.js"></script>
	<script type="text/javascript" src="pajax/pajax_import.php?Catalogo"></script>
	<script type="text/javascript" src="pajax/pajax_import.php?Carrito"></script>
	<script type="text/javascript" src="reglas.js"></script>

    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
  </head>
  <body>
    <div id="wrap">
      <div id="top">
        <div class="lefts">
          <h1> Carrito de compras </h1>
          <h2> utilizando pajax / prototype / scriptaculous / json </h2>
        </div>
      </div>

	  <div id="itemsActuales" style="display: none;"> 
		<div id="cestoDeBasura"> </div> 
		<div id="items"> </div> 
	  </div>

      <div id="main">
        <div id="rightside">
          <h2>Categories:</h2>
          <div class="box" id="catalogos"> </div>
          <h2>Carrito:</h2>
          <div class="box">
	          <div id="modoCarrito">Mostrar Carrito</div>		  
	          <div id="vaciarCarrito">Vaciar Carrito</div>		  
	          <div id="terminarPedido">Terminar Pedido</div>		  
		  </div>

        </div>
        <div id="contenido"> Seleccione categoria</div>
      </div>
      <div id="footer"> carrito de compras Ajax / copyright 2006 - 2007 </div>
    </div>
  </body>
</html>
