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
		<a href="index.php?controller=pinchos&amp;action=view&amp;id=<?= $pincho->getIdPincho()?>">
			<div class="thumbnail">
				<div class="row row-height">
					<div class="col-xs-3 col-sm-3 col-sm-offset-2 col-height">
						<img src=<?php if($pincho->getFotoPincho()!=NULL){
							echo "img/pinchos/".$pincho->getFotoPincho();
						} else {
							echo "img/pinchos/default.png";
						}?> alt="Foto Pincho" class="user-img img-circle">
					</div>
					<div class="col-xs-5 col-sm-5 col-height col-middle">
						<div class=""><?=$pincho->getNombrePincho()?></div>
					</div>

					<div class="col-xs-4 col-sm-2 col-height col-middle">
						<div class=""><?=$pincho->getPrecioPincho()?>€</div>
					</div>
				</div>
			</div>
		</a>
	<?php endforeach; ?>
</div>