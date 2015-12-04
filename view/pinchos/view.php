<?php 
//file: view/posts/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$pincho = $view->getVariable("pincho");
//$errors = $view->getVariable("errors");
$concurso = $view->getVariable("concurso");

$view->setVariable("title", "Datos del pincho"); ?>




<div>
	<div class="view-title"><h2><?= $pincho->getNombrePincho(); ?></h2></div>
	<div class="view-img"><img src="<?= 'img/pinchos/'.$pincho->getFotoPincho(); ?>"></div>
	<div class="view-description">

		<table class="table table-striped table-bordered">
			<tr>
				<th>Descripci&oacute;n</th>
				<td><?= $pincho->getDescripcionPincho(); ?></td>
			</tr>
			<tr>
				<th>Precio</th>
				<td><?= $pincho->getPrecioPincho(); ?> €</td>
			</tr>
			<tr>
				<th>Contacto</th>
				<td><?= $pincho->getEmailPincho(); ?></td>
			</tr>
			<tr>
				<th>Estado</th>
				<?php if($pincho->getAprobadaPincho() == Pincho::APROBADO): ?>
					<td><div class="pinchoAprobado">Aprobado</div></td>
				<?php else: ?>
					<td><div class="pinchoPendiente">Pendiente</div></td>
				<?php endif ?>
			</tr>
		</table>
	</div>
	<?php if(isset($_SESSION["type"]) && $_SESSION["type"] == 0 and $pincho->getAprobadaPincho() == 0 and !$concurso->isStarted()): ?>
		<div class="view-confirm">
			<a href="index.php?controller=pinchos&action=aprobar&id=<?= $pincho->getIdPincho(); ?>" class="btn btn-default" role="button">Aceptar</a>
		</div>
	<?php endif; ?>
	<?php if(isset($_SESSION["type"]) && $_SESSION["type"] == 0 and $pincho->getAprobadaPincho() == 1 and !$concurso->isStarted()): ?>
		<div class="view-confirm">
			<a href="index.php?controller=pinchos&action=borrar&id=<?= $pincho->getIdPincho(); ?>" class="btn btn-default" role="button">Borrar</a>
		</div>
	<?php endif; ?>
</div>