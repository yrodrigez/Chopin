<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$view->setVariable("title", "Asignar pinchos");
$nMax=$view->getVariable("nMax");
?>


<div id="formPresentarPincho">
	<div class="view-title">
		<p>Introduzca el numero de veces que un pincho sera probado por jurados profesiones distintos.
			Tenga en cuenta que este numero debe estar entre 1 y <?=$nMax?>. El proceso de asignacion se realizara 
			automaticamente una vez introduzca los datos</p>
	</div>
	<form class="form-horizontal" action="index.php?controller=pinchos&action=asignar" method="POST" enctype="multipart/form-data" data-toggle="validator">
		<div class="form-group">
			<label for="nombrePincho">Indique el numero de jurados profesionales que probara cada pincho:</label>
			<input type="number" class="form-control" name="nAsignar" required>
		</div>
		<div id="divBtn" class="form-group">
			<button type="submit" class="btn btn-default btnForm">Asignar pinchos</button>
		</div>
	</form>
</div>