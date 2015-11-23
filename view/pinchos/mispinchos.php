<?php
//file: view/pinchos/mispinchos.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Mis pinchos");
$pinchos = $view->getVariable("pinchos");
?>


<div>
    <div class="headerForm">
        <span>Mis Pinchos</span>
    </div>
    <div class="row">
        <?php if(count($pinchos) > 3): ?>
            <div class="botonVotar col-md-12">
                <input
                    type="button"
                    onclick="location.href='index.php?controller=pinchos&amp;action=getAllUsuarioCodigosPincho'"
                    class="btn btn-default"
                    value="Votar"
                >
            </div>
        <?php elseif(count($pinchos) < 3): ?>
            <div class="col-md-12">
                <span>Debes tener al menos tres (3) pinchos distintos para poder votar</span>
            </div>
        <?php endif; ?>
    </div>
    <?php foreach ($pinchos as $pincho): ?>
        <div class="thumbnail">
            <div class="row row-height">
                <div class="col-xs-4 col-sm-3 col-height">
                    <img src='<?= 'img/pinchos/'.$pincho->getFotoPincho();?>' alt='Foto_Pincho' class='user-img img-circle'/>
                </div>
                <div class="col-xs-8 col-sm-6 col-height col-middle">
                    <div class="thumb-username">
                        Nombre: <?=$pincho->getNombrePincho();?>
                        <br/>
                        Ingredientes:
                        <br/>
                        <ul class='ingredientes'>
                            <?php foreach($pincho->getIngredientesPincho() as $ingrediente){ ?>
                                <li class="ingrediente"><?= $ingrediente; ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>