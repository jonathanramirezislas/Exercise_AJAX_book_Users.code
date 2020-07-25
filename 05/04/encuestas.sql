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

INSERT INTO `noticias` VALUES (1, 'Los dem�cratas quieren retirar las tropas de Irak', 'Bush y Blair se re�nen esta semana con el Grupo de Estudio para estudiar el futuro. La Casa Blanca dice que fijar una fecha para la salida \'ser�a un desastre para Irak\'.', '2006-11-12 21:00:00');

INSERT INTO `noticias` VALUES (2, 'Sondeos de las municipales polacas', 'El partido Ley y Justicia de los hermanos Kaczynski se perfila como el perdedor de los comicios municipales en la mayor�a de las principales ciudades polacas, seg�n los resultados de un sondeo a pie de urna del instituto demosc�pico GFK Polonia, difundido por todos los medios audiovisuales del pa�s.', '2006-11-12 22:14:00');

INSERT INTO `noticias` VALUES (3, 'Mohamed Shubari sera primer ministro palestino', 'El presidente palestino, Abu Maz�n, tiene previsto designar a Mohamed Shubair, ex presidente de la Universidad Isl�mica de Gaza, como primer ministro del futuro Gobierno de unidad nacional tras haber alcanzado un acuerdo con Hamas, seg�n informaron fuentes de ese movimiento isl�mico.\r\n\r\nNizar Rayan, un destacado representante de Hamas en Gaza declar� a medios de prensa que el presidente Mazen y el Movimiento de la Resistencia Isl�mica (Hamas) han acordado nombrar a la persona que encabezar� el nuevo Gobierno de unidad nacional, que ser� constituido pr�ximamente.', '2006-10-22 14:21:00');

INSERT INTO `noticias` VALUES (4, 'Gates sentencia a muerte a los ratones', 'Seg�n Gates, la pr�xima revoluci�n en el campo de la inform�tica no afectar� al contenido de la red, sino que consistir� en la forma de actuar f�sicamente con los ordenadores.\r\n\r\nEl rat�n y el teclado dejar�n paso a las �rdenes transmitidas verbalmente, mediante el tacto o con gestos de la mano, ha asegurado en unas declaraciones que publica el dominical \'The Observer\'. "El ritmo de innovaci�n en los diez pr�ximos a�os ser� mucho m�s r�pido que el habido hasta ahora", se�ala.', '2006-09-01 12:30:00');

INSERT INTO `noticias` VALUES (5, 'La NASA pierde contacto con la \'Global Surveyor\'', 'Los ingenieros de la NASA han perdido el contacto con la sonda \'Mars Global Surveyor\', enviada en misi�n de exploraci�n a Marte hace 10 a�os, confirm� el Laboratorio de Propulsi�n a Chorro (JPL).\r\n\r\nLa p�rdida de las comunicaciones se produjo el pasado domingo y los ingenieros de la Agencia Espacial est�n "trabajando para restablecerlas", seg�n se�al� se�al� un portavoz del JPL.\r\n\r\nEl problema tuvo lugar dos d�as antes de cumplirse el d�cimo aniversario del lanzamiento de la nave, el 7 de noviembre de 1996.', '2005-01-13 15:32:00');
    
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
