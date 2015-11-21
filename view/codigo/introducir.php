<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Introducir código");
?>

<h2>Introduce tu código</h2>

<form action="index.php?controller=codigos&amp;action=introducir" method="POST">
    <div class="form-group">
        <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Introduce el código">
    </div>
    <button type="submit" class="btn btn-default">Introducir</button>
</form>
