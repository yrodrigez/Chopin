<?php 
//file: view/posts/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$pinchos = $view->getVariable("pinchos");
//$errors = $view->getVariable("errors");
?>


<div>
	<div class="headerForm">
		<span>Pinchos participantes</span>
	</div>
	<?php foreach ($pinchos as $pincho): ?>
		<div class="thumbnail">
			<div class="row row-height">
				<div class="col-xs-4 col-sm-3 col-height">
					<img src=<?= $pincho->getFotoPincho();?> alt="Foto Pincho" class="user-img img-circle">
				</div>
				<div class="col-xs-8 col-sm-6 col-height col-middle">
					<div class="thumb-username">Nombre: <?=$pincho->getNombrePincho()?>, Precio: <?=$pincho->getPrecioPincho()?></div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>