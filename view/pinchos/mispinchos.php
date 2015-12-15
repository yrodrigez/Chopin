<?php
//file: view/pinchos/mispinchos.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Mis pinchos");
$pinchos = $view->getVariable("pinchos");
$totalPinchos = $view->getVariable("totalPinchos");
$mispinchosSinRepetir= $view->getVariable("totalSinRepetir");
$porcentaje = $totalPinchos > 0 ? round($mispinchosSinRepetir*100/$totalPinchos) : 0;
$concurso = $view->getVariable("concurso");
?>


<div>
    <div class="view-title">
        <h2>Mis Pinchos</h2>
    </div>
    <span>Porcentaje de pinchos probados:</span>
    <div class="row"><br />
        <div class="col-md-12">
            <div class="prg">
                <div class="prg success-color" style="width: <?= $porcentaje ?>%;">
                    <div class="success-label"><?= $porcentaje ?> %
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <?php if(count($pinchos) >= 3 and $concurso->isStarted() and !$concurso->isStarted2Iter()): ?>
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