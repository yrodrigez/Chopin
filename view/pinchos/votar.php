<?php
//file: view/pinchos/votar.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Votar pincho");
$pinchos = $view->getVariable("pinchos");
$codigos = $view->getVariable("codigos");
$isVotar = $view->getVariable("votar");
?>
<div>
    <div class="headerForm">
        <span>Votar</span>
        <br/>
        <?php if($isVotar == 0): ?>
            <span>Selecciona los tres pinchos que vas a usar para votar</span>
        <?php endif ?>
        <?php if($isVotar == 1): ?>
            <span>Vota por el que mas te gusta</span>
        <?php endif ?>

    </div>

    <form
        <?php if($isVotar == 0): ?>
            action="index.php?controller=pinchos&amp;action=seleccion"
        <?php endif ?>
        <?php if($isVotar == 1): ?>
            action="index.php?controller=pinchos&amp;action=votar"
        <?php endif ?>
        method="post"
    >
    <div class="row">
        <div class="col-md-12 botonVotar">
            <input
                type="submit"
                class="btn btn-default"
                <?php if($isVotar == 0 && count($pinchos) >= 3): ?>
                    value="Seleccionar"
                    name="Seleccionar"
                <?php endif ?>
                <?php if($isVotar == 1 && count($pinchos) >= 3): ?>
                    value="Votar"
                    name="Seleccionar"
                <?php endif ?>
            >
        </div>
    </div>
    <?php for ($i = 0; $i < count($pinchos); $i++): ?>
        <div class="thumbnail">
            <div class="row row-height">
                <div class="col-xs-4 col-sm-3 col-height">
                    <img src=<?php if($pinchos[$i]->getFotoPincho()!=NULL){
                        echo "img/pinchos/".$pinchos[$i]->getFotoPincho();
                    } else {
                        echo "img/pinchos/default.png";
                    }?> alt="Foto Pincho" class="user-img img-circle">
                </div>
                <div class="col-xs-8 col-sm-6 col-height col-middle">
                    <div class="thumb-username">
                        <div class="row infoPincho">
                            <div class="col-md-10">
                                Nombre: <?= $pinchos[$i]->getNombrePincho();?>
                                <br/>
                                Código: <?= $codigos[$i] ?>
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" name="pinchos[]" value="<?= $pinchos[$i]->getIdPincho() ?>">
                                <input type="hidden" name="idpinchos[]" value="<?= $pinchos[$i]->getIdPincho() ?>">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <?php endfor; ?>
    </form>
</div>