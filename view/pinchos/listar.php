<?php 
//file: view/posts/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$pinchos = $view->getVariable("pinchos");
//$errors = $view->getVariable("errors");

$view->setVariable("title", "View Post"); 
?>


<div>
	<div class="headerForm">
		<span>Pinchos participantes</span>
	</div>
	<div class="row">
		<?php foreach($pinchos as $pincho){ ?>
		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 ">
			<img alt="Foto usuario" class="img-responsive img-circle sizePhotoAnswer" src=<?php $pincho->getFotoPincho();?>/>
		</div>
		<div class="col-lg-10 col-md-10 col-sm-9 col-xs-8 ">
			<span><a href="#">Nombre: <?= $pincho->getNombrePincho();?></a>,</span> 
			<span>Precio: <?= $pincho->getPrecioPincho();?></span>
		</div>
	</div>
</div>