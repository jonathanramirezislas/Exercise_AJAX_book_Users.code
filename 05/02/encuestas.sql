CREATE DATABASE encuestasOnLine;
USE encuestasOnLine;

DROP TABLE IF EXISTS encuestas;
CREATE TABLE encuestas (
  idEncuesta int(4) NOT NULL default '0',
  nombreEncuesta varchar(255) NOT NULL default '',
  fechaEncuesta date default NULL,
  PRIMARY KEY  (idEncuesta)
);

INSERT INTO encuestas (idEncuesta, nombreEncuesta, fechaEncuesta) VALUES (1, 'encuesta 1', '2006-12-12');
INSERT INTO encuestas (idEncuesta, nombreEncuesta, fechaEncuesta) VALUES (2, 'encuesta 2', '2006-12-13');
INSERT INTO encuestas (idEncuesta, nombreEncuesta, fechaEncuesta) VALUES (3, 'encuesta 3', '2006-12-14');

DROP TABLE IF EXISTS opciones;
CREATE TABLE opciones (
  idOpcion int(2) NOT NULL default '0',
  idEncuesta int(4) NOT NULL default '0',
  nombreOpcion varchar(255) NOT NULL default '',
  votos int(11) default '0',
  PRIMARY KEY  (idOpcion)
);

INSERT INTO opciones (idOpcion, idEncuesta, nombreOpcion, votos) VALUES (1, 1, 'opcion 1', 20);
INSERT INTO opciones (idOpcion, idEncuesta, nombreOpcion, votos) VALUES (2, 1, 'opcion 2', 12);
INSERT INTO opciones (idOpcion, idEncuesta, nombreOpcion, votos) VALUES (3, 1, 'opcion 3', 15);
INSERT INTO opciones (idOpcion, idEncuesta, nombreOpcion, votos) VALUES (4, 1, 'opcion 4', 30);
