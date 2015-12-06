<?php
//file: view/juradoprofesional/mispinchos.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Mis pinchos");
$pinchos = $view->getVariable("pinchos");
/**
 * @var $pincho Pincho
 */
?>


<div>
    <div class="view-title">
        <h2>Mis Pinchos</h2>
    </div>

    <?php foreach ($pinchos as $pincho): ?>
        <div class="thumbnail">
            <div class="row row-height">
                <div class="col-xs-3 col-sm-3 col-height">
                    <img src='<?= 'img/pinchos/'.$pincho->getFotoPincho();?>' alt='Foto_Pincho' class='user-img img-circle'/>
                </div>
                <div class="col-xs-7 col-sm-6 col-height col-middle">
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
                <div class="col-xs-2 col-sm-3">
                    <input
                        type="button"
                        onclick="location.href='index.php?controller=pinchos&amp;action=iniciarValoracion&amp;id=<?= $pincho->getIdPincho() ?>'"
                        class="btn btn-default"
                        value="Valorar"
                    >
                </div>
            </div>
        </div>
    <?php endforeach; ?>

</div>