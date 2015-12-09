<?php
require_once(__DIR__."/../../core/ViewManager.php");
require_once(__DIR__."/../../model/Concurso.php");
$view = ViewManager::getInstance();

$jurado = $view->getVariable("jurado");
$concurso = $view->getVariable("concurso");

//$errors = $view->getVariable("errors");

$view->setVariable("title", "Jurados profesional");
/**
 * @var $establecimiento Establecimiento
 */
?>

<div>
    <div class="view-title">
        <h2>Jurados Profesional</h2>
    </div>
    <?php foreach ($jurado as $jp): ?>
        <a href="index.php?controller=juradoprofesional&amp;action=view&amp;id=<?= $jp->getEmail()?>">
            <div class="thumbnail">
                <div class="row row-height">
                    <div class="col-xs-3 col-sm-3 col-sm-offset-2 col-height">
                        <img src=<?php if($jp->getFotoUsuario()!=NULL){
                            echo "img/usuarios/".$jp->getFotoUsuario();
                        } else {
                            echo "img/usuarios/default.png";
                        }?> alt="Foto Usuario" class="user-img img-circle">
                    </div>
                    <div class="col-xs-5 col-sm-5 col-height col-middle">
                        <div class=""><?=$jp->getEmail()?></div>
                    </div>

                    <div class="col-xs-4 col-sm-2 col-height col-middle">
                        <div class=""><?=$jp->getPreferencias()?></div>
                    </div>
                </div>
            </div>
        </a>
    <?php endforeach; ?>

    <?php if(isset($_SESSION["type"]) && $_SESSION["type"] == Usuario::ORGANIZADOR && !$concurso->isStarted()): ?>
        <a class="btn btn-default" href="index.php?controller=juradoprofesional&amp;action=add">A&ntilde;adir</a>
    <?php endif; ?>
    <?php if(isset($_SESSION["type"]) && $_SESSION["type"] == Usuario::ORGANIZADOR && $concurso->isStarted() && sizeof($jurado)>0): ?>
        <a class="btn btn-default" href="index.php?controller=pinchos&amp;action=asignar">Asignar pinchos</a>
    <?php endif; ?>
</div>