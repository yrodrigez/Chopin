<?php 
 //file: view/posts/index.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 require_once(__DIR__."/../../model/JuradoProfesional.php");
 $miembro = $view->getVariable("miembro");
 
 $currentuser = $view->getVariable("currentusername");
 
 $view->setVariable("title", "Editar jurado profesional");
?>

<h1>Añadir jurado profesional</h1>
<form role="form" action="index.php?controller=juradoprofesional&amp;action=edit" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" readonly name="email" id="email" placeholder="Introduce un email" value="<?= $miembro->getEmail() ?>">
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Introduce una nueva contrase&ntilde;a">
    </div>
	<div class="form-group">
      <label for="tel">Tel&eacute;fono:</label>
      <input type="text" class="form-control" name="tel" id="tel" placeholder="Introduce un tel&eacute;fono" value="<?= $miembro->getTelefono() ?>">
    </div>
	<div class="form-group">
      <label for="avatar">Foto de perfil:</label>
      <input type="file" class="file" name="avatar" id="avatar" value="<?= $miembro->getFotoUsuario() ?>">
    </div>
	<div class="form-group">
      <label for="exp">Experiencia:</label>
      <textarea class="form-control" rows="5" name="exp" id="exp"><?= $miembro->getExperiencia() ?></textarea>
    </div>

    <button type="submit" class="btn btn-default">Editar</button>
	<a href="index.php?controller=juradoprofesional&amp;action=index"><button class="btn btn-default">Cancelar</button></a>
</form>