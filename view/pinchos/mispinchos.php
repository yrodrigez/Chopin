<?php
//file: view/posts/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$pinchos = $view->getVariable("pinchos");
?>


<div>
    <div class="headerForm">
        <span>Pinchos participantes</span>
    </div>
    <?php foreach ($pinchos as $pincho): ?>
        <div class="thumbnail">
            <div class="row row-height">
                <div class="col-xs-4 col-sm-3 col-height">
                    <img src='<?= $pincho->getFotoPincho();?>' alt='Foto_Pincho' class='user-img img-circle'/>
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