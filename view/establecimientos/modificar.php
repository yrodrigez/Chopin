<?php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$view->setVariable("title", "Modificar usuario");

/**
 *
 * @var $establecimiento Establecimiento
 */

$establecimiento = $view->getVariable("establecimiento");
?>


<div id="formPresentarPincho">
    <div class="headerForm">
        <span>Introduzca los datos que desea modificar</span>
    </div>
    <form class="form-horizontal"
          action="index.php?controller=establecimiento&action=modificar"
          method="POST"
          enctype="multipart/form-data"
          data-toggle="validator">
        <div class="form-group">
            <label for="email">Email: </label>
            <input type="text"
                   disabled="true"
                   class="form-control"
                   name="mostrar"
                   id="mostrar"
                   value="<?= $establecimiento->getEmail();?>">
            <input type="hidden" name="email" value="<?= $establecimiento->getEmail();?>">
        </div>
        <div class="form-group">
            <label for="passwd">Password:</label>
            <input type="password"
                   class="form-control"
                   name="password"
                   id="password"
                   placeholder="Escribe aqui tu nueva contraseña..."
                   data-minlength="6"
                   data-error="La contraseña debe tener al menos 6 caracteres">
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="tel">Tel&eacute;fono:</label>
            <input type="text"
                   class="form-control"
                   name="telefono" id="telefono"
                   value="<?= $establecimiento->getTelefono();?>"
                   pattern="^[0-9]{9}$"
                   data-error="El teléfono introducido no es válido">
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="avatar">Foto de perfil:</label>
            <input type="file" class="file file-loading" name="avatar" id="avatar" data-show-upload="false" data-allowed-file-extensions='["jpg", "png", "bmp", "gif"]'>
        </div>
        <div class="form-group">
            <label for="preferencias">Dirección</label>
            <input type="text"
                   class="form-control"
                   name="direccion"
                   id="direccion"
                   value="<?= $establecimiento->getDireccion();?>">
        </div>
        <div class="form-group">
            <label for="preferencias">Coordenadas</label>
            <input type="text"
                   class="form-control"
                   name="coordenadas"
                   id="coordenadas"
                   value="<?= $establecimiento->getCoordenadas();?>">
        </div>
        <div id="divBtn" class="form-group">
            <button type="submit" class="btn btn-default btnForm">Modificar</button>
        </div>
    </form>
</div>


<?php $view->moveToFragment("script"); ?>
    $("#avatar").fileinput({
    defaultPreviewContent: '<img src=img/usuarios/<?= ($establecimiento->getFotoUsuario())?$establecimiento->getFotoUsuario():"default.png" ?> alt="Avatar">',
    });
<?php $view->moveToDefaultFragment(); ?>