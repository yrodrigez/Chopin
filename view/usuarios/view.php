<?php 
//file: view/posts/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$usuario = $view->getVariable("usuario");
//$errors = $view->getVariable("errors");
 
$view->setVariable("title", "Datos del usuario"); ?>




<div>
	<div class="view-title"><h1><?= $usuario->getEmail(); ?></h1></div>
	<div class="view-img"><img src="<?= 'img/usuarios/'.$usuario->getFotoUsuario(); ?>"></div>
	<div class="view-description">

		<table class="table table-striped table-bordered">
			<tr>
				<th>Email: </th>
				<td><?= $usuario->getEmail(); ?></td>
			</tr>
			<tr>
				<th>Telefono: </th>
				<td><?= $usuario->getTelefono(); ?></td>
			</tr>
			<tr>
				<th>Preferencias: </th>
				<td><?= $usuario->getPreferencias(); ?></td>
			</tr>
		</table>
	</div>
	<?php if(isset($_SESSION["user"]) && $_SESSION["user"] == $usuario->getEmail()): ?>
		<div class="view-confirm">
			<a href="index.php?controller=usuarios&action=modificar&id=<?= $usuario->getEmail(); ?>" class="btn btn-default" role="button">Modificar mi cuenta</a>
		</div>
		<div class="view-confirm">
			<a href="index.php?controller=usuarios&action=eliminar&id=<?= $usuario->getEmail(); ?>" onclick="return confirm('¿Esta seguro que desea eliminar su cuenta?')" class="btn btn-default" role="button">Eliminar mi cuenta</a>
		</div>
	<?php endif; ?>
</div>