<?php 
 //file: view/posts/introducir.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 require_once(__DIR__."/../../model/JuradoProfesional.php");
 $miembro = $view->getVariable("miembro");

 $concurso = $view->getVariable("concurso");
 $currentuser = $view->getVariable("currentusername");
 
 $view->setVariable("title", "Editar jurado profesional");
?>

<div class="view-title"><h2>Añadir jurado profesional</h2></div>
<form role="form" action="index.php?controller=juradoprofesional&amp;action=edit" method="POST" enctype="multipart/form-data" data-toggle="validator">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" readonly name="email" id="email" placeholder="Introduce un email" value="<?= $miembro->getEmail() ?>">
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Introduce una nueva contrase&ntilde;a" data-minlength="6" data-error="La contraseña debe tener al menos 6 caracteres">
      <div class="help-block with-errors"></div>
    </div>
	<div class="form-group">
      <label for="tel">Tel&eacute;fono:</label>
      <input type="text" class="form-control" name="tel" id="tel" placeholder="Introduce un tel&eacute;fono" value="<?= $miembro->getTelefono() ?>" pattern="^[0-9]{9}$" data-error="El teléfono introducido no es válido">
      <div class="help-block with-errors"></div>
    </div>
	<div class="form-group">
      <label for="avatar">Foto de perfil:</label>
        <input type="file" class="file file-loading" name="avatar" id="avatar" data-show-upload="false" data-allowed-file-extensions='["jpg", "png", "bmp", "gif"]'>
    </div>
	<div class="form-group">
      <label for="exp">Experiencia:</label>
      <textarea class="form-control" rows="5" name="exp" id="exp"><?= $miembro->getExperiencia() ?></textarea>
    </div>

    <button type="submit" class="btn btn-default">Editar</button>

</form>

<?php if(!$concurso->isStarted()): ?>
    <form role="form" action="index.php?controller=juradoprofesional&amp;action=delete" method="POST">
        <input type="hidden" name="email" value="<?= $miembro->getEmail() ?>">
        <button type="submit" class="btn btn-default">Borrar</button>
    </form>
<?php endif; ?>

<a href="index.php?controller=juradoprofesional&amp;action=index"><button class="btn btn-default">Cancelar</button></a>

<?php $view->moveToFragment("script"); ?>
    $("#avatar").fileinput({
        defaultPreviewContent: '<img src=img/usuarios/<?= ($miembro->getFotoUsuario())?$miembro->getFotoUsuario():"default.png" ?> alt="Avatar" style="width:160px">',
    });
<?php $view->moveToDefaultFragment(); ?>