<?php


require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$view->setVariable("title", "Presentar propuesta");
?>


<div id="formPresentarPincho">
	<div class="headerForm">
		<span>Introduzca los datos del pincho que desea presentar</span>
	</div>
	<form class="form-horizontal" action="index.php?controller=pinchos&action=presentar" method="POST" enctype="multipart/form-data" data-toggle="validator">
		<div class="form-group">
			<label for="nombrePincho">Nombre:</label>
			<input type="text" class="form-control" name="nombrePincho" required>
		</div>
		<div class="form-group">
			<label for="descripcionPincho">Descripcion:</label>
			<textarea id ="descripcionPincho" name="descripcionPincho" rows ="10" required></textarea>
		</div>
		<div class="form-group">
			<label for="ingredientes">Ingredientes:</label>
			<input type="text" class="form-control" name="ingredientesPincho" id="ingredientesInput" required="true">
		</div>
		<div class="form-group">
			<label for="precioPincho">Precio:</label>
			<input type="number" min="0" step="0.01" class="form-control" name="precioPincho" required="true">
		</div>
		<div class="form-group">
			<label for="fotoPincho">Foto:</label>
			<input type="file" class="file file-loading" name="fotoPincho" id="avatar" data-show-upload="false" data-allowed-file-extensions='["jpg", "png", "bmp", "gif"]'>
		</div>
		<div id="divBtn" class="form-group">
			<button type="submit" class="btn btn-default btnForm">Presentar</button>
		</div>
	</form>
</div>


<?php $view->moveToFragment("script"); ?>
$('#ingredientesInput').tagsInput({width:'auto'});
<?php $view->moveToDefaultFragment(); ?>