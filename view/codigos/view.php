<?php 
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$usuario = $view->getVariable("usuario");
$codigo = $view->getVariable("codigo");
$pincho = $view->getVariable("pincho");
//$errors = $view->getVariable("errors");
 
$view->setVariable("title", "View Post"); ?>


<div>
	<h1><?= $usuario->getNombre(); ?></h1>
	<div>
		<li>Codigos<br></li>
		<div class="form-group">
 			<label for="codigos">Numero de codigos:</label>
 			<input type="num" class="form-control" name ="codigos" id="codigos" placeholder="Introduce la cantidad de codigos que desees">
 			
 			<?php if(isset($_SESSION["type"]) && $_SESSION["type"] == 1): ?>
			<a href="index.php?controller=codigos&action=generar&id=<?= $pincho->getIdPincho(); ?>&num" class="btn btn-default" role="button"><?= (($codigo->generar())"Generar") ?></a>
			<?php endif; ?>
		</div>
	</div>
	<div>
	<li>Lista de codigos</li>
		print_r($codigo->listar());
	</div>

</div>
