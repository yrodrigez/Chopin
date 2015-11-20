<?php
//file: view/pinchos/votar.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$pinchos = $view->getVariable("pinchos");
$codigos = $view->getVariable("codigos");
?>


<div>
    <div class="headerForm">
        <span>Votar</span>
        <br/>
        <span>Selecciona tres de los que más te han gustado</span>
    </div>
    <div class="botonVotar" style="text-align: left;">
        <input type="button" name="elegir" value="Elegir" onclick="location.href=''" style="margin-bottom: 10px;">
    </div>
    <form action="" method="post">
    <?php for ($i = 0; $i < count($pinchos); $i++): ?>
        <div class="thumbnail">
            <div class="row row-height">
                <div class="col-xs-4 col-sm-3 col-height">
                    <img src='<?= $pinchos[$i]->getFotoPincho();?>' alt='Foto_Pincho' class='user-img img-circle'/>
                </div>
                <div class="col-xs-8 col-sm-6 col-height col-middle">
                    <div class="thumb-username">
                        <div class="row infoPincho">
                            <div class="col-md-10">
                                Nombre: <?= $pinchos[$i]->getNombrePincho();?>
                                <br/>
                                Codigo: <?= $codigos[$i] ?>
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" value="<?= $codigos[$i] ?>">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <?php endfor; ?>
    </form>
</div>