<?php 
//file: view/posts/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$concurso = $view->getVariable("concurso");
//$errors = $view->getVariable("errors");
 
$view->setVariable("title", "View Post"); ?>


<div>
	<h1><?= $concurso->getNombre(); ?></h1>

	<ul>
		<li>Descripci&oacute;n: <?= $concurso->getDescripcion(); ?><br></li>
		<li>Localizaci&oacute;n: <?= $concurso->getLocalizacion(); ?><br></li>
		<li>Fecha: <?= $concurso->getFecha(); ?><br></li>
	</ul>
</div>