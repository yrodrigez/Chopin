<?php require_once(__DIR__."/PDOConnection.php"); ?>

<html>
	<head>
		<title>Comentarios</title>
	</head>
	<body>
		<form action="ComentarioController.php" method=post name="formulario">
			Email: <input type="text" name="email"></input><br>
			Contenido: <input type="text" name="contenido"></input><br>
			Fecha: <input type="text" name="fecha"></input><br>
			Id: <input type="text" name="id"></input><br>
			<input type="submit" name="botonEnviar" value="Guardar"></input>
			<input type="submit" name="botonEnviar" value="Modificar"></input>
			<input type="submit" name="botonEnviar" value="Borrar"></input>
		</form>

		<div>
			<?php
				$db = PDOConnection::getInstance();
				$stmt = $db->prepare("SELECT * FROM comentario");
				$stmt->execute();
				$comentarios= $stmt->fetchall();
				//print_r($comentarios);

				foreach($comentarios as $comentario) {
					echo $comentario['email']." -> ".$comentario['contenido']."<br>";
				}
			?>
		</div>
	</body>
	<footer>
	</footer>
</html>