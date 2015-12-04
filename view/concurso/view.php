<?php
//file: view/posts/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$concurso = $view->getVariable("concurso");

$pincho = $view->getVariable("pincho");
//$errors = $view->getVariable("errors");

$view->setVariable("title", "Datos del concurso"); ?>


<div>
	<div class="view-title"><h2><?= $concurso->getNombre(); ?></h2></div>
	<div class="view-img-lg"><img src="<?= 'img/'.$concurso->getImagen(); ?>"></div>
	<div class="view-description">

		<table class="table table-striped table-bordered">
			<tr>
				<th>Descripci&oacute;n</th>
				<td><?= $concurso->getDescripcion(); ?></td>
			</tr>
			<tr>
				<th>Localización</th>
				<td><?= $concurso->getLocalizacion(); ?></td>
			</tr>
			<tr>
				<th>Fecha de inicio</th>
				<td><?= (new DateTime($concurso->getFecha()))->format('d/m/Y'); ?></td>
			</tr>
		</table>
	</div>
</div>