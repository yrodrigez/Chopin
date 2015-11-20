<?php
//file: view/pinchos/votar.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$pinchos = $view->getVariable("pinchos");
?>


<div>
    <div class="headerForm">
        <span>Votar</span>
        <span>Selecciona tres de los que más te han gustado</span>
    </div>
    <div class="botonVotar" style="text-align: left;">
        <input type="button" name="votar" value="Votar" onclick="location.href=''" style="margin-bottom: 10px;">
    </div>
    <form action="" method="post">
    <?php foreach ($pinchos as $pincho): ?>
        <div class="thumbnail">
            <div class="row row-height">
                <div class="col-xs-4 col-sm-3 col-height">
                    <img src='<?= $pincho->getFotoPincho();?>' alt='Foto_Pincho' class='user-img img-circle'/>
                </div>
                <div class="col-xs-8 col-sm-6 col-height col-middle">
                    <div class="thumb-username">
                        <div class="col-md-10"></div>
                        Nombre: <?=$pincho->getNombrePincho();?>
                        <br/>
                        Codigo:
                        <br/>
                        <?= $pincho->getCodigoPincho(); ?>
                    </div>
                    <div class="col-md-2">
                        <input type="checkbox" value="<?= $pincho->getCodigoPincho() ?>">
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </form>
</div>