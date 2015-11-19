<?php 
 //file: view/posts/index.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $currentuser = $view->getVariable("currentusername");
 
 $view->setVariable("title", "Añadir jurado profesional");
?>

<h1>Añadir jurado profesional</h1>
<form role="form" action="index.php?controller=juradoprofesional&amp;action=add" method="POST">
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
      <input type="file" class="file" name="avatar" id="avatar">
    </div>
	<div class="form-group">
      <label for="exp">Experiencia:</label>
      <textarea class="form-control" rows="5" name="exp" id="exp"></textarea>
    </div>

    <button type="submit" class="btn btn-default">A&ntilde;adir</button>
</form>