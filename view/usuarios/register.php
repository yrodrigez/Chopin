<?php 
 //file: view/users/register.php
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $errors = $view->getVariable("errors");
 $user = $view->getVariable("user");
 $view->setVariable("title", "Register");
?>
<h1>Registrarse</h1>
<form action="index.php?controller=usuarios&amp;action=register" method="POST">
      Usuario: <input type="text" name="username" value="">
      <?= isset($errors["username"])?$errors["username"]:"" ?><br>
      
      <?= "Contrase&ntilde;a" ?>: <input type="password" name="passwd" value="">
      <?= isset($errors["passwd"])?$errors["passwd"]:"" ?><br>
      
      <input type="submit" value="<?= "Register"?>">
</form>
