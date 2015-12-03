<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$jpops = $view->getVariable("jpops");
//$errors = $view->getVariable("errors");

$view->setVariable("title", "Jurados populares registrados");
/**
 * @var $establecimiento Establecimiento
 */
?>

<div>
    <div class="headerForm">
        <span>Jurados Popular</span>
    </div>
    <?php foreach ($jpops as $jpop): ?>
        <a href="index.php?controller=usuarios&amp;action=view&amp;id=<?= $jpop->getEmail()?>">
            <div class="thumbnail">
                <div class="row row-height">
                    <div class="col-xs-3 col-sm-3 col-sm-offset-2 col-height">
                        <img src=<?php if($jpop->getFotoUsuario()!=NULL){
                            echo "img/usuarios/".$jpop->getFotoUsuario();
                        } else {
                            echo "img/usuarios/default.png";
                        }?> alt="Foto Usuario" class="user-img img-circle">
                    </div>
                    <div class="col-xs-5 col-sm-5 col-height col-middle">
                        <div class=""><?=$jpop->getEmail()?></div>
                    </div>

                    <div class="col-xs-4 col-sm-2 col-height col-middle">
                        <div class=""><?=$jpop->getPreferencias()?></div>
                    </div>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</div>