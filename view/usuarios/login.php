<?php 
 //file: view/users/login.php
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $view->setVariable("title", "Login");
 $errors = $view->getVariable("errors");
?>

<h2><?= "Iniciar sesi&oacute;n" ?></h2>
<?= isset($errors["general"])?$errors["general"]:"" ?>

<form role="form" action="index.php?controller=usuarios&amp;action=login" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="username">Email:</label>
        <input type="email" class="form-control" name="username" id="username" placeholder="Introduce un email">
    </div>
    <div class="form-group">
        <label for="passwd">Password:</label>
        <input type="password" class="form-control" name="passwd" id="passwd" placeholder="Introduce una nueva contrase&ntilde;a">
    </div>
    <button type="submit" class="btn btn-default">Acceder</button>
</form>

<br><p><?= "¿No est&aacute;s registrado? "?> <a href="index.php?controller=usuarios&amp;action=register"><?= "Reg&iacute;strate ahora" ?></a></p>
<?php $view->moveToFragment("css");?>
    <link rel="stylesheet" type="text/css" src="css/style2.css">
<?php $view->moveToDefaultFragment(); ?>