CREATE DATABASE IF NOT EXISTS carrito;
USE carrito;

DROP TABLE IF EXISTS 'catalogos';
CREATE TABLE IF NOT EXISTS 'catalogos' (
  'idCatalogo' int(3) NOT NULL default '0',
  'nombreCatalogo' varchar(255) default NULL,
  PRIMARY KEY  ('idCatalogo')
);

INSERT INTO 'catalogos' VALUES (1, 'Sistemas Operativos');
INSERT INTO 'catalogos' VALUES (2, 'Ajax');
INSERT INTO 'catalogos' VALUES (3, 'Bases de datos');
INSERT INTO 'catalogos' VALUES (4, 'Redes');
INSERT INTO 'catalogos' VALUES (5, 'Hardware');

DROP TABLE IF EXISTS 'productos';
CREATE TABLE IF NOT EXISTS 'productos' (
  'idProducto' int(5) NOT NULL default '0',
  'idCatalogo' int(3) NOT NULL default '0',
  'nombreProducto' varchar(255) NOT NULL default '',
  'descripcionProducto' text,
  'imagenProducto' varchar(255) NOT NULL default '',
  'precioProducto' double default NULL,
  PRIMARY KEY  ('idProducto')
);

INSERT INTO 'productos' VALUES (1, 2, 'Ajax Patterns', 'Esta es la sinopsis del libro. Esta es la sinopsis del libro. Esta es la sinopsis del libro. ', '01.gif', 900);
INSERT INTO 'productos' VALUES (2, 2, 'JSF and Ajax', 'Esta es la sinopsis del libro. Esta es la sinopsis del libro. Esta es la sinopsis del libro. ', '02.gif', 300);
INSERT INTO 'productos' VALUES (4, 1, 'Ajax y ASP.net', 'texto - texto - texto - texto - texto - texto - texto - texto - texto - texto - texto - texto', '04.gif', 121.12);
INSERT INTO 'productos' VALUES (5, 3, 'Oreilly', 'este es el texto. este es el texto. este es el texto. este es el texto. este es el texto. este es el texto. este es el texto. este es el texto. este es el texto. ', '05.gif', 99.99);

DROP TABLE IF EXISTS 'pedido';
CREATE TABLE IF NOT EXISTS 'pedido' (
  'idPedido' int(6) NOT NULL auto_increment,
  'fechaPedido' date default NULL,
  'nombreUsuario' varchar(255) default NULL,
  'apellidoUsuario' varchar(255) default NULL,
  'direccionUsuario' varchar(255) default NULL,
  'telefonoUsuario' varchar(255) default NULL,
  'emailUsuario' varchar(255) default NULL,
  'comentarioUsuario' text,
  'terminado' smallint(1) NOT NULL default '0',
  PRIMARY KEY  ('idPedido')
);

DROP TABLE IF EXISTS 'detalle_pedido';
CREATE TABLE IF NOT EXISTS 'detalle_pedido' (
  'idPedido' int(6) NOT NULL default '0',
  'idProducto' int(5) NOT NULL default '0',
  'cantidad' int(5) NOT NULL default '0',
  'precioProducto' double default NULL,
  PRIMARY KEY  ('idPedido','idProducto')
);
