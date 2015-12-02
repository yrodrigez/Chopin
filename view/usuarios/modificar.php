<?php


require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$view->setVariable("title", "Modificar usuario");
$usuario = $view->getVariable("jpop");
?>


<div id="formPresentarPincho">
	<div class="headerForm">
		<span>Introduzca los datos que desea modificar</span>
	</div>
	<form class="form-horizontal" action="index.php?controller=usuarios&action=modificar" method="POST" enctype="multipart/form-data" data-toggle="validator">
		<input type="hidden" name="email" value="<?= $usuario->getEmail();?>">
		<div class="form-group">
			<label for="passwd">Password:</label>
        	<input type="password" class="form-control" name="password" id="password" value="<?= $usuario->getPassword();?>" data-minlength="6" data-error="La contraseña debe tener al menos 6 caracteres" required>
		</div>
		<div class="form-group">
			<label for="tel">Tel&eacute;fono:</label>
        	<input type="text" class="form-control" name="telefono" id="telefono" value="<?= $usuario->getTelefono();?>" pattern="^[0-9]{9}$" data-error="El teléfono introducido no es válido">
		</div>
		<div class="form-group">
			<label for="avatar">Foto de perfil:</label>
        	<input type="file" class="file file-loading" name="avatar" id="avatar" data-show-upload="false" data-allowed-file-extensions='["jpg", "png", "gif"]'>
		</div>
		<div class="form-group">
			<label for="preferencias">Preferencias</label>
        	<input type="text" class="form-control" name="preferencias" id="preferencias" value="<?= $usuario->getPreferencias();?>">
		</div>
		<div id="divBtn" class="form-group">
			<button type="submit" class="btn btn-default btnForm">Modificar</button>
		</div>
	</form>
</div>
