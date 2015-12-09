USE chopin;
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
INSERT INTO establecimiento(direccion, coordenadas, email, nombre, horario) VALUES ("Ourense
", "(42.33578929999999, -7.863880999999992)", "establecimiento@gmail.com", "Establecimiento 1", "10:00-11:00");
INSERT INTO establecimiento(direccion, coordenadas, email, nombre, horario) VALUES ("Ourense
", "(42.33578929999999, -7.863880999999992)", "establecimiento2@gmail.com", "Establecimiento 2", "11:00-12:00");
INSERT INTO establecimiento(direccion, coordenadas, email, nombre, horario) VALUES ("Ourense
", "(42.33578929999999, -7.863880999999992)", "establecimiento3@gmail.com", "Establecimiento 3", "6:00-8:00");
INSERT INTO establecimiento(direccion, coordenadas, email, nombre, horario) VALUES ("Ourense
", "(42.33578929999999, -7.863880999999992)", "establecimiento4@gmail.com", "Establecimiento 4", "9:00-15:00");
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