<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$ganadores = $view->getVariable("ganadores");

print_r($ganadores);
?>