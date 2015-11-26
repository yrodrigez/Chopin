<?php 
//file: view/posts/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$pincho = $view->getVariable("pincho");
//$errors = $view->getVariable("errors");
 
$view->setVariable("title", "View Post"); ?>




<div>
	<div class="view-title"><h1><?= $pincho->getNombrePincho(); ?></h1></div>
	<div class="view-img"><img src="<?= 'img/pinchos/'.$pincho->getFotoPincho(); ?>"></div>
	<div class="view-description">

		<table class="table table-striped table-bordered">
			<tr>
				<th>Descripci&oacute;n</th>
				<td><?= $pincho->getDescripcionPincho(); ?></td>
			</tr>
			<tr>
				<th>Precio</th>
				<td><?= $pincho->getPrecioPincho(); ?></td>
			</tr>
			<tr>
				<th>Fecha de inicio</th>
				<td><?= $concurso->getFecha(); ?></td>
			</tr>
		</table>
	</div>
	<?php if(isset($_SESSION["type"]) && $_SESSION["type"] == 0): ?>
		<div class="view-confirm">
			<a href="index.php?controller=pinchos&action=aprobar&id=<?= $pincho->getIdPincho(); ?>" class="btn btn-default <?= (($pincho->getAprobadaPincho() == 1)?"disabled":"") ?>" role="button"><?= (($pincho->getAprobadaPincho() == 1)?"Aceptada":"Aceptar") ?></a>
		</div>
	<?php endif; ?>
</div>