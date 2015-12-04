<?php
//file: view/posts/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
/**
 * @var $establecimiento Establecimiento
 */
$establecimiento = $view->getVariable("establecimiento");

$view->setVariable("title", "Datos del usuario"); ?>

<div>
    <div class="view-title"><h2><?= $establecimiento->getEmail(); ?></h2></div>
    <div class="view-img"><img src="<?= 'img/usuarios/'.$establecimiento->getFotoUsuario(); ?>"></div>
    <div class="view-description">

        <table class="table table-striped table-bordered">
            <tr>
                <th>Email: </th>
                <td><?= $establecimiento->getEmail(); ?></td>
            </tr>
            <tr>
                <th>Telefono: </th>
                <td><?= $establecimiento->getTelefono(); ?></td>
            </tr>
            <tr>
                <th>Dirección: </th>
                <td><?= $establecimiento->getDireccion(); ?></td>
            </tr>
            <tr>
                <th>Coordenadas: </th>
                <td><?= $establecimiento->getCoordenadas(); ?></td>
            </tr>
        </table>
    </div>
    <?php if(isset($_SESSION["type"]) && $_SESSION["type"] == Usuario::ORGANIZADOR || $_SESSION["type"] == Usuario::ESTABLECIMIENTO): ?>
        <div class="view-confirm">
            <a href="index.php?controller=establecimiento&action=modificar&id=<?= $establecimiento->getEmail(); ?>"
               class="btn btn-default"
               role="button">Modificar mi cuenta</a>

        </div>
        <?php if($_SESSION["type"] == Usuario::ORGANIZADOR): ?>
            <div class="view-confirm">
                <a href="index.php?controller=establecimiento&action=eliminar&id=<?= $establecimiento->getEmail(); ?>"
                   onclick="return confirm('¿Esta seguro que desea eliminar Este establecimiento?')"
                   class="btn btn-default"
                   role="button">Eliminar</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>