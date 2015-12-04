<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Configurar concurso");
?>

<div id="formConfigurarConcurso">

	<form class="form-horizontal" action="index.php?controller=concurso&action=configurar" method="POST" data-toggle="validator" enctype="multipart/form-data">
		<div class="view-title">
			<h2>Datos del concurso</h2>
		</div>

		<div class="form-group">
			<label for="nombre">Nombre:</label>
			<input type="text" class="form-control" name="nombre" placeholder="Indique el nombre del concurso" required>
		</div>
		<div class="form-group">
			<label for="descripcion">Descripcion:</label>
			<textarea id ="descripcionConcurso" name="descripcion" rows ="10"></textarea>
		</div>
		<div class="form-group">
			<label for="localizacion">Localizacion:</label>
			<input type="text" class="form-control" name="localizacion" placeholder="Indique la ciudad del concurso" required>
		</div>
		<div class="form-group">
			<label for="fecha">Fecha:</label>
			<input type="text" class="form-control" name="fecha" required="true" placeholder="DD/MM/AAAA" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" data-error="La fecha introducida no es válida">
			<div class="help-block with-errors"></div>
		</div>
		<div class="form-group">
			<label for="imagenConcurso">Foto de perfil:</label>
			<input type="file" class="file file-loading" name="imagenConcurso" id="imagenConcurso" data-show-upload="false" data-allowed-file-extensions='["jpg", "png", "bmp", "gif"]'>
		</div>
		<div class="form-group">
			<div class="checkbox">
				<label><input type="checkbox" name="sampleData"> Insertar datos de prueba</label>
			</div>
		</div>

		<hr>

		<div class="headerForm">
			<h2>Datos del organizador</h2>
		</div>

		<div class="form-group">
			<label for="username">Email del administrador:</label>
			<input type="email" class="form-control" name="username" data-error="El email introducido no es válido" required>
			<div class="help-block with-errors"></div>
		</div>
		<div class="form-group">
			<label for="password">Contraseña del administrador:</label>
			<input type="password" class="form-control" name="password" data-minlength="6" data-error="La contraseña debe tener al menos 6 caracteres" required>
			<div class="help-block with-errors"></div>
		</div>
		<div class="form-group">
			<label for="imagenOrganizador">Foto de perfil:</label>
			<input type="file" class="file file-loading" name="imagenOrganizador" id="imagenOrganizador" data-show-upload="false" data-allowed-file-extensions='["jpg", "png", "bmp", "gif"]'>
		</div>

		<hr>

		<div class="headerForm">
			<h2>Datos de la base de datos</h2>
		</div>

		<div class="form-group">
			<label for="db_username">Usuario:</label>
			<input type="text" class="form-control" name="db_username" placeholder="root" value="root" required>
		</div>
		<div class="form-group">
			<label for="db_password">Contraseña:</label>
			<input type="password" class="form-control" name="db_password">
		</div>

		<div id="divBtn" class="form-group">
			<button type="submit" class="btn btn-default btnForm">Configurar</button>
		</div>
	</form>
</div>