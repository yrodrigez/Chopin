<?php 
//file: view/posts/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$usuario = $view->getVariable("usuario");
//$errors = $view->getVariable("errors");
 
$view->setVariable("title", "Datos del usuario"); ?>


<div>
	<div class="view-title"><h2><?= $usuario->getEmail(); ?></h2></div>
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
			<tr>
				<th>Experiencia: </th>
				<td><?= $usuario->getExperiencia(); ?></td>
			</tr>
		</table>
	</div>
	<?php if(isset($_SESSION["user"]) && $_SESSION["user"] == $usuario->getEmail() || $_SESSION["type"] == Usuario::ORGANIZADOR): ?>
		<div class="view-confirm">
			<a href="index.php?controller=juradoprofesional&action=edit&id=<?= $usuario->getEmail(); ?>" class="btn btn-default" role="button">Modificar cuenta</a>
		</div>
		<?php if($_SESSION["type"] == Usuario::ORGANIZADOR): ?>
		<div class="view-confirm">
			<a id="show" class="btn btn-default" role="button">Eliminar</a>
		</div>
		<?php endif; ?>
	<?php endif; ?>
</div>


<?php $view->moveToFragment("script"); ?>
	$(function() {
		$('#show').avgrund({
			height: 150,
			holderClass: 'custom',
			showClose: true,
			showCloseText: 'close',
			onBlurContainer: '.container',
			template: '<br><p class="confirm-title">¿Seguro que quieres eliminar el miembro de jurado profesional seleccionado?</p>' +
			'<div>' +
			'<a href="index.php?controller=juradoprofesional&action=delete&email=<?= $usuario->getEmail(); ?>" class="btn btn-default confirm-btn ">Si</a>' +
				'<a href="index.php?controller=juradoprofesional&action=view&id=<?= $usuario->getEmail(); ?>#" class="btn btn-default confirm-btn avgrund-close-ws">No</a>' +
				'</div>'
		});
	});
<?php $view->moveToDefaultFragment(); ?>
