<?php
//file: view/posts/view.php
require_once(__DIR__."/../../core/ViewManager.php");
require_once(__DIR__."/../../model/Concurso.php");
require_once(__DIR__."/../../model/ConcursoMapper.php");
$view = ViewManager::getInstance();

$concurso = $view->getVariable("concurso");

$pincho = $view->getVariable("pincho");
//$errors = $view->getVariable("errors");

$view->setVariable("title", "Datos del concurso");
$url = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];

if($concurso->isFinished()) {
	$estado = "Finalizado";
} else if($concurso->isStarted2Iter()) {
	$estado = "En evaluación de finalistas";
} else if($concurso->isStarted()) {
	$estado = "Empezado";
} else {
	$estado = "No empezado";
}
?>


<div>
	<div class="view-title"><h2><?= $concurso->getNombre(); ?><div class="pull-right"><a href="https://www.facebook.com/sharer/sharer.php?u=<?= $url?>" target="_blank"><img src="img/sys/facebook.png" class="social-icon"></a><a href="http://twitter.com/home?status=<?= $url?>" target="_blank"><img src="img/sys/twitter.png" class="social-icon"></a><a href="https://plus.google.com/share?url=<?= $url?>" target="_blank"><img src="img/sys/plus.png" class="social-icon"></a></div></h2></div>
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
				<th>Estado</th>
				<td><?= $estado; ?></td>
			</tr>
			<tr>
				<th>Fecha de inicio</th>
				<td><?= (new DateTime($concurso->getFechaInicio()))->format('d/m/Y'); ?></td>
			</tr>
			<tr>
				<th>Fecha de finalistas</th>
				<td><?= (new DateTime($concurso->getFechaFinalistas()))->format('d/m/Y'); ?></td>
			</tr>
			<tr>
				<th>Fecha de fin</th>
				<td><?= (new DateTime($concurso->getFechaFin()))->format('d/m/Y'); ?></td>
			</tr>
		</table>
	</div>
</div>