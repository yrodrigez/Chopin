<?php 
 //file: view/posts/introducir.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 
 $view->setVariable("title", "Añadir jurado profesional");
?>

<h2>Añadir jurado profesional</h2>
<form role="form" action="index.php?controller=juradoprofesional&amp;action=add" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" name="email" id="email" placeholder="Introduce un email">
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Introduce una contrase&ntilde;a">
    </div>
	<div class="form-group">
      <label for="tel">Tel&eacute;fono:</label>
      <input type="text" class="form-control" name="tel" id="tel" placeholder="Introduce un tel&eacute;fono">
    </div>
	<div class="form-group">
      <label for="avatar">Foto de perfil:</label>
        <input type="file" class="file file-loading" name="avatar" id="avatar" data-show-upload="false" data-allowed-file-extensions='["jpg", "png", "bmp", "gif"]'>
    </div>
	<div class="form-group">
      <label for="exp">Experiencia:</label>
      <textarea class="form-control" rows="5" name="exp" id="exp"></textarea>
    </div>

    <button type="submit" class="btn btn-default">A&ntilde;adir</button>
</form>

<a href="index.php?controller=juradoprofesional&amp;action=index"><button class="btn btn-default">Volver</button></a>