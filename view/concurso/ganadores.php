<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$ganadoresPop = $view->getVariable("ganadoresPo");
$ganadoresPr = $view->getVariable("ganadoresPr");

?>

<div>
	<div class="view-title">
		<h2>Pinchos ganadores populares</h2>
	</div>
	<?php foreach ($ganadoresPop as $pincho): 
	if(!is_numeric($pincho)){
		?>
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
						<div class="">Votos: <?=$ganadoresPop["pincho_".$pincho->getIdPincho()."_votos"]?></div>
					</div>
				</div>
			</div>
		</a>
		<?php 
	}
	endforeach; 
	?>
</div>

<div>
	<div class="view-title">
		<h2>Pinchos ganadores profesionales</h2>
	</div>
	<?php foreach ($ganadoresPr as $pincho): 
	if(!is_numeric($pincho)){
		?>
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
						<div class="">Valoración: <?=$ganadoresPr["pincho_".$pincho->getIdPincho()."_resultado"]?></div>
					</div>
				</div>
			</div>
		</a>
		<?php 
	}
	endforeach; 
	?>
</div>