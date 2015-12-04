<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$establecimientos = $view->getVariable("establecimientos");
//$errors = $view->getVariable("errors");

$view->setVariable("title", "Establecimientos registrados");
/**
 * @var $establecimiento Establecimiento
 */
?>

<div>
    <div class="view-title">
        <h2>Establecimientos Registrados</h2>
    </div>
    <?php foreach ($establecimientos as $establecimiento): ?>
        <a href="index.php?controller=establecimiento&amp;action=view&amp;id=<?= $establecimiento->getEmail()?>">
            <div class="thumbnail">
                <div class="row row-height">
                    <div class="col-xs-3 col-sm-3 col-sm-offset-2 col-height">
                        <img src=<?php if($establecimiento->getFotoUsuario()!=NULL){
                            echo "img/usuarios/".$establecimiento->getFotoUsuario();
                        } else {
                            echo "img/usuarios/default.png";
                        }?> alt="Foto Usuario" class="user-img img-circle">
                    </div>
                    <div class="col-xs-5 col-sm-5 col-height col-middle">
                        <div class=""><?=$establecimiento->getEmail()?></div>
                    </div>

                    <div class="col-xs-4 col-sm-2 col-height col-middle">
                        <div class=""><?=$establecimiento->getDireccion()?></div>
                    </div>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</div>