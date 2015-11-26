
DROP DATABASE IF EXISTS chopin; 
CREATE DATABASE chopin;
USE chopin;

DROP TABLE IF EXISTS codigo;
DROP TABLE IF EXISTS comentario;
DROP TABLE IF EXISTS concurso;
DROP TABLE IF EXISTS establecimiento;
DROP TABLE IF EXISTS ingredientes;
DROP TABLE IF EXISTS juradoprofesional;
DROP TABLE IF EXISTS pincho;
DROP TABLE IF EXISTS usuario;
DROP TABLE IF EXISTS valoracion;

CREATE TABLE codigo (idcodigo varchar(255) NOT NULL, idpincho int(10) NOT NULL, email varchar(40), utilizado int(1) NOT NULL, elegido int(1), fechaVotacion date, PRIMARY KEY (idcodigo));
CREATE TABLE comentario (idcomentario int(10) NOT NULL AUTO_INCREMENT, contenido varchar(255), fecha date, email varchar(40) NOT NULL, PRIMARY KEY (idcomentario));
CREATE TABLE concurso (nombre varchar(50) NOT NULL, localizacion varchar(50) NOT NULL, fecha date NOT NULL, descripcion varchar(255), foto varchar(255), PRIMARY KEY (nombre));
CREATE TABLE establecimiento (direccion varchar(100), coordenadas varchar(50), email varchar(40) NOT NULL);
CREATE TABLE ingredientes (idpincho int(10) NOT NULL, nombreCategoria varchar(30) NOT NULL, PRIMARY KEY (idpincho, nombreCategoria));
CREATE TABLE juradoprofesional (experiencia varchar(255), email varchar(40) NOT NULL);
CREATE TABLE pincho (precio decimal(3, 2) NOT NULL, idpincho int(10) NOT NULL AUTO_INCREMENT, nombre varchar(50) NOT NULL, descripcion varchar(255) NOT NULL, email varchar(40) NOT NULL, aprobada int(1), foto varchar(255), PRIMARY KEY (idpincho));
CREATE TABLE usuario (email varchar(40) NOT NULL, password varchar(30) NOT NULL, fotoperfil varchar(255), telefono varchar(14), tipo int(1) NOT NULL, preferencias varchar(255), PRIMARY KEY (email));
CREATE TABLE valoracion (idpincho int(10) NOT NULL, email varchar(40) NOT NULL, puntuacion decimal(1, 1), fecha date, PRIMARY KEY (idpincho, email));
ALTER TABLE juradoprofesional ADD INDEX FKjuradoprof655776 (email), ADD CONSTRAINT FKjuradoprof655776 FOREIGN KEY (email) REFERENCES usuario (email);
ALTER TABLE valoracion ADD INDEX FKvaloracion745033 (email), ADD CONSTRAINT FKvaloracion745033 FOREIGN KEY (email) REFERENCES juradoprofesional (email);
ALTER TABLE ingredientes ADD INDEX FKingredient248642 (idpincho), ADD CONSTRAINT FKingredient248642 FOREIGN KEY (idpincho) REFERENCES pincho (idpincho);
ALTER TABLE establecimiento ADD INDEX FKestablecim48566 (email), ADD CONSTRAINT FKestablecim48566 FOREIGN KEY (email) REFERENCES usuario (email);
ALTER TABLE pincho ADD INDEX FKpincho503763 (email), ADD CONSTRAINT FKpincho503763 FOREIGN KEY (email) REFERENCES establecimiento (email);
ALTER TABLE codigo ADD INDEX FKcodigo694415 (email), ADD CONSTRAINT FKcodigo694415 FOREIGN KEY (email) REFERENCES usuario (email);
ALTER TABLE comentario ADD INDEX FKcomentario863335 (email), ADD CONSTRAINT FKcomentario863335 FOREIGN KEY (email) REFERENCES usuario (email);
ALTER TABLE valoracion ADD INDEX FKvaloracion349986 (idpincho), ADD CONSTRAINT FKvaloracion349986 FOREIGN KEY (idpincho) REFERENCES pincho (idpincho);
ALTER TABLE codigo ADD INDEX FKcodigo533532 (idpincho), ADD CONSTRAINT FKcodigo533532 FOREIGN KEY (idpincho) REFERENCES pincho (idpincho);


GRANT USAGE ON *.* TO 'chopin_user'@'127.0.0.1';
DROP USER 'chopin_user'@'127.0.0.1';
CREATE USER 'chopin_user'@'127.0.0.1' IDENTIFIED BY 'chopin_pass.';
GRANT ALL ON chopin_p.* TO 'chopin_user'@'127.0.0.1';
GRANT USAGE ON *.* TO 'chopin_user'@'127.0.0.1';


INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES ("jpop@gmail.com", "123456", "default.png", "999999999", 1, "Prefiero el sushi!");
INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES ("jpop2@gmail.com", "123456", "default.png", "999999999", 1, "Yo prefiero los tacos!");
INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES ("jpop3@gmail.com", "123456", "default.png", "999999999", 1, "Prefiero orella");
INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES ("jprof@gmail.com", "123456", "default.png", "999999999", 2, "Comida picante");
INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES ("jprof2@gmail.com", "123456", "default.png", "999999999", 2, "Comida italiana");
INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES ("establecimiento@gmail.com", "123456", "default.png", "999999999", 3, "");
INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES ("establecimiento2@gmail.com", "123456", "default.png", "999999999", 3, "");
INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES ("establecimiento3@gmail.com", "123456", "default.png", "999999999", 3, "");
INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES ("establecimiento4@gmail.com", "123456", "default.png", "999999999", 3, "");
INSERT INTO juradoprofesional(experiencia, email) values ("5 estrellas michelin","jprof@gmail.com");
INSERT INTO juradoprofesional(experiencia, email) values ("3 estrellas michelin","jprof2@gmail.com");
INSERT INTO establecimiento(direccion, coordenadas, email) VALUES ("Direccion establecimiento 1", "Coordenadas establecimiento 1", "establecimiento@gmail.com");
INSERT INTO establecimiento(direccion, coordenadas, email) VALUES ("Direccion establecimiento 2", "Coordenadas establecimiento 2", "establecimiento2@gmail.com");
INSERT INTO establecimiento(direccion, coordenadas, email) VALUES ("Direccion establecimiento 3", "Coordenadas establecimiento 3", "establecimiento3@gmail.com");
INSERT INTO establecimiento(direccion, coordenadas, email) VALUES ("Direccion establecimiento 4", "Coordenadas establecimiento 4", "establecimiento4@gmail.com");
INSERT INTO pincho(precio, idpincho, nombre, descripcion, email, aprobada, foto) VALUES (2.55, 1, "Calamares en su tinta", "Calamares cocinados con su tinta", "establecimiento@gmail.com", 1, "default.png");
INSERT INTO pincho(precio, idpincho, nombre, descripcion, email, aprobada, foto) VALUES (3.00, 2, "Pincho de tortilla", "Utiliza huevos y patatas", "establecimiento2@gmail.com", 1, "default.png");
INSERT INTO pincho(precio, idpincho, nombre, descripcion, email, aprobada, foto) VALUES (5.00, 3, "Vegetariano", "Compuesto por vegetales", "establecimiento3@gmail.com", 1, "default.png");
INSERT INTO pincho(precio, idpincho, nombre, descripcion, email, aprobada, foto) VALUES (1.50, 4, "Brochetas de Queso", "Brochetas de quesos variados", "establecimiento4@gmail.com", 0, "default.png");
INSERT INTO ingredientes(idpincho, nombreCategoria) VALUES (1, "Calamares");
INSERT INTO ingredientes(idpincho, nombreCategoria) VALUES (2, "Huevos");
INSERT INTO ingredientes(idpincho, nombreCategoria) VALUES (2, "Patatas");
INSERT INTO ingredientes(idpincho, nombreCategoria) VALUES (3, "Tomates");
INSERT INTO ingredientes(idpincho, nombreCategoria) VALUES (4, "Queso brie");
INSERT INTO	codigo(idcodigo, idpincho, email , utilizado , elegido , fechaVotacion) VALUES (1,1,"jpop@gmail.com",0,0,NULL);
INSERT INTO	codigo(idcodigo, idpincho, email , utilizado , elegido , fechaVotacion) VALUES (2,2,"jpop@gmail.com",0,0,NULL);
INSERT INTO	codigo(idcodigo, idpincho, email , utilizado , elegido , fechaVotacion) VALUES (3,3,"jpop@gmail.com",0,0,NULL);