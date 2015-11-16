<?php 
 //file: view/users/login.php
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $view->setVariable("title", "Login");
 $errors = $view->getVariable("errors");
?>

<h1><?= "Iniciar sesi&oacute;n" ?></h1>
<?= isset($errors["general"])?$errors["general"]:"" ?>

<form action="index.php?controller=usuarios&amp;action=login" method="POST">
Email: <input type="text" name="username">
Contrase&ntilde;a: <input type="password" name="passwd">
<input type="submit" value="<?= "Iniciar sesi&oacute;n" ?>">
</form>

<p><?= "¿No est&aacute;s registrado? "?> <a href="index.php?controller=usuarios&amp;action=register"><?= "Reg&iacute;strate ahora" ?></a></p>
<?php $view->moveToFragment("css");?>
    <link rel="stylesheet" type="text/css" src="css/style2.css">
<?php $view->moveToDefaultFragment(); ?>