USE chopin;
INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES ("jpop@gmail.com", "123456", "jpop@gmail.com.png", "999999999", 1, "Prefiero el sushi!");
INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES ("jpop2@gmail.com", "123456", "jpop2@gmail.com.png", "999999999", 1, "Yo prefiero los tacos!");
INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES ("jpop3@gmail.com", "123456", "jpop3@gmail.com.png", "999999999", 1, "Prefiero orella");
INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES ("jprof@gmail.com", "123456", "jprof@gmail.com.png", "999999999", 2, "Comida picante");
INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES ("jprof2@gmail.com", "123456", "jprof2@gmail.com.png", "999999999", 2, "Comida italiana");
INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES ("establecimiento@gmail.com", "123456", "establecimiento@gmail.com.jpg", "999999999", 3, "");
INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES ("establecimiento2@gmail.com", "123456", "establecimiento2@gmail.com.jpg", "999999999", 3, "");
INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES ("establecimiento3@gmail.com", "123456", "establecimiento3@gmail.com.jpg", "999999999", 3, "");
INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES ("establecimiento4@gmail.com", "123456", "establecimiento4@gmail.com.jpg", "999999999", 3, "");
INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES ("establecimiento5@gmail.com", "123456", "establecimiento5@gmail.com.jpg", "999999999", 3, "");
INSERT INTO juradoprofesional(experiencia, email) values ("5 años de experiencia", "jprof@gmail.com");
INSERT INTO juradoprofesional(experiencia, email) values ("3 años de experiencia", "jprof2@gmail.com");
INSERT INTO establecimiento(direccion, coordenadas, email, nombre, horario) VALUES ("Praza do Ferro, 7
", "(42.33767719999999, -7.863247000000001)", "establecimiento@gmail.com", "Taberna do Meigallo", "13:00-16:00, 20:00-00:00");
INSERT INTO establecimiento(direccion, coordenadas, email, nombre, horario) VALUES ("Plaza Eironciños dos Cabaleiros, 1
", "(42.3373926, -7.8640834999999925)", "establecimiento2@gmail.com", "Mesón Casa de María Andrea", "12:30-15:30, 19:00-23:00");
INSERT INTO establecimiento(direccion, coordenadas, email, nombre, horario) VALUES ("Rúa Paz, 10
", "(42.33709, -7.863489999999956)", "establecimiento3@gmail.com", "San Xes", "7:00-14:00, 19:00-00:00");
INSERT INTO establecimiento(direccion, coordenadas, email, nombre, horario) VALUES ("Rúa Valle Inclán, 18
", "(42.34261, -7.859349999999949)", "establecimiento4@gmail.com", "O Lagar", "11:00-14:30, 20:00-23:30");
INSERT INTO establecimiento(direccion, coordenadas, email, nombre, horario) VALUES ("Calle de San Miguel, 10
", "(42.3376004, -7.86335280000003)", "establecimiento5@gmail.com", "Casa Toñita", "9:00-14:00, 16:00-22:00");
INSERT INTO pincho(precio, idpincho, nombre, descripcion, email, aprobada, foto) VALUES (2.55, 1, "Calamares en su tinta", "Calamares cocinados con su tinta", "establecimiento@gmail.com", 1, "calamares.jpg");
INSERT INTO pincho(precio, idpincho, nombre, descripcion, email, aprobada, foto) VALUES (3.00, 2, "SocialGüiso", "Utiliza huevos y patatas", "establecimiento2@gmail.com", 1, "pincho.jpg");
INSERT INTO pincho(precio, idpincho, nombre, descripcion, email, aprobada, foto) VALUES (5.00, 3, "Vegetariano", "Compuesto por vegetales", "establecimiento3@gmail.com", 1, "vegetariano.jpg");
INSERT INTO pincho(precio, idpincho, nombre, descripcion, email, aprobada, foto) VALUES (1.50, 4, "Brochetas de Queso", "Brochetas de quesos variados", "establecimiento4@gmail.com", 0, "queso.jpg");
INSERT INTO ingredientes(idpincho, nombreCategoria) VALUES (1, "Calamares");
INSERT INTO ingredientes(idpincho, nombreCategoria) VALUES (2, "Huevos");
INSERT INTO ingredientes(idpincho, nombreCategoria) VALUES (2, "Patatas");
INSERT INTO ingredientes(idpincho, nombreCategoria) VALUES (3, "Tomates");
INSERT INTO ingredientes(idpincho, nombreCategoria) VALUES (4, "Queso brie");
INSERT INTO	codigo(idcodigo, idpincho, email , utilizado , elegido , fechaVotacion) VALUES (1,1,"jpop@gmail.com",0,0,NULL);
INSERT INTO	codigo(idcodigo, idpincho, email , utilizado , elegido , fechaVotacion) VALUES (2,2,"jpop@gmail.com",0,0,NULL);
INSERT INTO	codigo(idcodigo, idpincho, email , utilizado , elegido , fechaVotacion) VALUES (3,3,"jpop@gmail.com",0,0,NULL);