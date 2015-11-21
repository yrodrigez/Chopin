<?php 
//file: view/posts/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$pincho = $view->getVariable("pincho");
//$errors = $view->getVariable("errors");
 
$view->setVariable("title", "View Post"); ?>


<div>
	<h1><?= $pincho->getNombrePincho(); ?></h1>
	<ul>
		<li>Precio: <?= $pincho->getPrecioPincho(); ?><br></li>
		<li>Id: <?= $pincho->getIdPincho(); ?><br></li>
		<li>Nombre: <?= $pincho->getNombrePincho(); ?><br></li>
		<li>Descripci&oacute;n: <?= $pincho->getDescripcionPincho(); ?><br></li>
		<li>Email: <?= $pincho->getEmailPincho(); ?><br></li>
		<li>Aprobado: <?= $pincho->getAprobadaPincho(); ?><br></li>
		<li>Fotografia:<br></li>
		<img src=<?php if($pincho->getFotoPincho()!=NULL){
							echo "img/pinchos/".$pincho->getFotoPincho();
						} else {
							echo "img/pinchos/default.png";
						}?> alt="Foto de pincho" class="user-img img-circle">
	</ul>

	<?php if(isset($_SESSION["type"]) && $_SESSION["type"] == 0): ?>
		<a href="index.php?controller=pincho&action=aprobar&id=<?= $pincho->getIdPincho(); ?>" class="btn btn-default <?= (($pincho->getAprobadaPincho() == 1)?"disabled":"") ?>" role="button"><?= (($pincho->getAprobadaPincho() == 1)?"Aceptada":"Aceptar") ?></a>
	<?php endif; ?>

</div>