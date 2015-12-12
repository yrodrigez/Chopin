<?php
//file: view/posts/introducir.php

require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$res= $view->getVariable("res");
$cat= $view->getVariable("cat");

$view->setVariable("title", "Búsqueda");
?>

<div class="view-title"><h2>Búsqueda</h2></div>

<form role="form" form="form-horizontal" action="index.php?controller=pinchos&amp;action=buscar" method="POST"
      data-toggle="validator">
    <div class="form-group">
        <div class="col-sm-9">
            <input type="text" class="form-control" name="text" id="text"
                   placeholder="Busca por pincho, ingrediente o establecimiento" required>
        </div>
        <div class="col-sm-3">
            <select class="form-control" name="cat">
                <option>Pincho</option>
                <option>Establecimiento</option>
            </select>
        </div>
    </div>

    <button type="submit" class="btn btn-default" id="btnSearch">Buscar</button>
</form>

<?php if(isset($res)): ?>
    <?php if(sizeof($res)!=0): ?>
        <br>Resultados:
        <?php if($cat=="Pincho"): ?>
            <?php foreach ($res as $pincho): ?>
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
        <?php endif; ?>

        <?php if($cat=="Establecimiento"): ?>
            <?php foreach ($res as $establecimiento): ?>
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
                                <div class=""><?= $establecimiento->getNombre()?></div>
                            </div>

                            <div class="col-xs-4 col-sm-2 col-height col-middle">
                                <div class=""><?=$establecimiento->getDireccion()?></div>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php else: ?>
        <br>No se encontraron resultados.
    <?php endif; ?>
<?php endif; ?>
