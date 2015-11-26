<?php 
//file: view/posts/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$votados = $view->getVariable("votados");
//$errors = $view->getVariable("errors");
?>


<div>
	<div class="headerForm">
		<span>Mis pinchos votados</span>
	</div>
	<?php if (sizeof ($votados) > 0) { ?>
		<?php for($row = 0; $row < sizeof($votados); $row++){ ?>
			<a href="index.php?controller=pinchos&amp;action=view&amp;id=<?= $votados[$row][0]->getIdPincho()?>">
				<div class="thumbnail">
					<div class="row row-height">
						<div class="col-xs-3 col-sm-3 col-sm-offset-2 col-height">
							<img src=<?= "img/pinchos/".$votados[$row][0]->getFotoPincho(); ?> alt="Foto Pincho" class="user-img img-circle">
						</div>
						<div class="col-xs-5 col-sm-5 col-height col-middle">
							<div class=""><?=$votados[$row][0]->getNombrePincho()?></div>
						</div>

						<div class="col-xs-4 col-sm-2 col-height col-middle">
						<div class="">Veces votado: <?=$votados[$row][1]?></div>
						</div>
					</div>
				</div>
			</a>
		<?php } ?>
	<?php } else { ?>
		<div class="col-md-12">
                <span>No ha votado por ningun pincho todavia</span>
        </div>
    <?php } ?>
</div>