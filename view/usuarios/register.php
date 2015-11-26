<?php 
 //file: view/users/register.php

 require_once(__DIR__."/../../core/ViewManager.php");
 require_once(__DIR__."/../../model/Concurso.php");
 require_once(__DIR__."/../../model/ConcursoMapper.php");
 $concurso = (new ConcursoMapper())->getInfo();
 $view = ViewManager::getInstance();
 $errors = $view->getVariable("errors");
 $user = $view->getVariable("user");
 $view->setVariable("title", "Register");
?>
<h2>Registro</h2>
<form role="form" action="index.php?controller=usuarios&amp;action=register" method="POST" enctype="multipart/form-data" data-toggle="validator">
    <div class="form-group">
        <label for="username">Email:</label>
        <input type="email" class="form-control" name="username" id="username" placeholder="Introduce un email" data-error="El email introducido no es válido" required>
        <div class="help-block with-errors"></div>
    </div>
    <div class="form-group">
        <label for="passwd">Password:</label>
        <input type="password" class="form-control" name="passwd" id="passwd" placeholder="Introduce una contrase&ntilde;a" data-minlength="6" data-error="La contraseña debe tener al menos 6 caracteres" required>
        <div class="help-block with-errors"></div>
    </div>
    <div class="form-group">
        <label for="tel">Tel&eacute;fono:</label>
        <input type="text" class="form-control" name="tel" id="tel" placeholder="Introduce un tel&eacute;fono" pattern="^[0-9]{9}$" data-error="El teléfono introducido no es válido">
        <div class="help-block with-errors"></div>
    </div>
    <div class="form-group">
        <label for="avatar">Foto de perfil:</label>
        <input type="file" class="file file-loading" name="avatar" id="avatar" data-show-upload="false" data-allowed-file-extensions='["jpg", "png", "gif"]'>
    </div>

    <div class="form-group">
        <label for="preferences">Preferencias</label>
        <input type="text" class="form-control" name="prefs" id="prefs" placeholder="Introduzca sus preferencias culinarias">
    </div>

    <?php if(!$concurso->isStarted()): ?>
        <div class="form-group">
            <label for="dir">Direcci&oacute;n</label>
            <input type="text" class="form-control" name="dir" id="dir" placeholder="Introduce una direcci&oacute;n" required>
        </div>
        <div class="form-group">
            <label for="cord">Coordenadas:</label>
            <input type="text" class="form-control" name="cord" id="cord" placeholder="Introduce unas coordenadas">
        </div>
    <?php endif; ?>

    <button type="submit" class="btn btn-default">Registrar</button>
</form>

