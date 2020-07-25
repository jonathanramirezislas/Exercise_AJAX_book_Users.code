CREATE DATABASE noticias;
USE noticias;

DROP TABLE IF EXISTS noticias;
CREATE TABLE noticias (
 idNoticia int(11) NOT NULL default '0',
 tituloNoticia varchar(255) NOT NULL default '',
 textoNoticia text,
 fechaNoticia datetime default NULL,
 PRIMARY KEY  (idNoticia)
);

INSERT INTO `noticias` VALUES (1, 'Los demócratas quieren retirar las tropas de Irak', 'Bush y Blair se reúnen esta semana con el Grupo de Estudio para estudiar el futuro. La Casa Blanca dice que fijar una fecha para la salida \'sería un desastre para Irak\'.', '2006-11-12 21:00:00');

INSERT INTO `noticias` VALUES (2, 'Sondeos de las municipales polacas', 'El partido Ley y Justicia de los hermanos Kaczynski se perfila como el perdedor de los comicios municipales en la mayoría de las principales ciudades polacas, según los resultados de un sondeo a pie de urna del instituto demoscópico GFK Polonia, difundido por todos los medios audiovisuales del país.', '2006-11-12 22:14:00');

INSERT INTO `noticias` VALUES (3, 'Mohamed Shubari sera primer ministro palestino', 'El presidente palestino, Abu Mazén, tiene previsto designar a Mohamed Shubair, ex presidente de la Universidad Islámica de Gaza, como primer ministro del futuro Gobierno de unidad nacional tras haber alcanzado un acuerdo con Hamas, según informaron fuentes de ese movimiento islámico.\r\n\r\nNizar Rayan, un destacado representante de Hamas en Gaza declaró a medios de prensa que el presidente Mazen y el Movimiento de la Resistencia Islámica (Hamas) han acordado nombrar a la persona que encabezará el nuevo Gobierno de unidad nacional, que será constituido próximamente.', '2006-10-22 14:21:00');

INSERT INTO `noticias` VALUES (4, 'Gates sentencia a muerte a los ratones', 'Según Gates, la próxima revolución en el campo de la informática no afectará al contenido de la red, sino que consistirá en la forma de actuar físicamente con los ordenadores.\r\n\r\nEl ratón y el teclado dejarán paso a las órdenes transmitidas verbalmente, mediante el tacto o con gestos de la mano, ha asegurado en unas declaraciones que publica el dominical \'The Observer\'. "El ritmo de innovación en los diez próximos años será mucho más rápido que el habido hasta ahora", señala.', '2006-09-01 12:30:00');

INSERT INTO `noticias` VALUES (5, 'La NASA pierde contacto con la \'Global Surveyor\'', 'Los ingenieros de la NASA han perdido el contacto con la sonda \'Mars Global Surveyor\', enviada en misión de exploración a Marte hace 10 años, confirmó el Laboratorio de Propulsión a Chorro (JPL).\r\n\r\nLa pérdida de las comunicaciones se produjo el pasado domingo y los ingenieros de la Agencia Espacial están "trabajando para restablecerlas", según señaló señaló un portavoz del JPL.\r\n\r\nEl problema tuvo lugar dos días antes de cumplirse el décimo aniversario del lanzamiento de la nave, el 7 de noviembre de 1996.', '2005-01-13 15:32:00');
    
DROP TABLE IF EXISTS comentarios;
CREATE TABLE comentarios (
 idComentario int(11) NOT NULL auto_increment,
 idNoticia int(11) NOT NULL default '0',
 autorComentario varchar(255) NOT NULL default '',
 emailautorComentario varchar(255) NOT NULL default '',
 textoComentario text NOT NULL,
 fechaComentario datetime default NULL,
 PRIMARY KEY  (idComentario)
);
