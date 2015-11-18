<div id="formPresentarPincho">
	<h3>Introduzca los datos del pincho que desea presentar</h3>
	<form class="form-horizontal" action="../../index.php?controller=pincho&action=presentar" method="POST" enctype="multipart/form-data">
		<div class="form-group">
			<label for="nombrePincho">Nombre:</label>
			<input type="text" class="form-control" name="nombrePincho" required="true">
		</div>
		<div class="form-group">
			<label for="descripcionPincho">Descripcion:</label>
			<input type="text" class="form-control" name="descripcionPincho" required="true">
		</div>
		<div class="form-group">
			<label for="ingredientes">Ingredientes:</label>
			<input type="text" class="form-control" name="ingredientesPincho" id="ingredientesInput" required="true" placeholder="Inserte sus ingredientes separados por comas">
		</div>
		<div class="form-group">
			<label for="precioPincho">Precio:</label>
			<input type="number" class="form-control" name="precioPincho" required="true">
		</div>
		<div class="form-group">
			<label for="fotoPincho">Foto:</label>
			<input type="file" name="fotoPincho">
		</div>
		<button type="submit" class="btn btn-default">Presentar</button>
	</form>
</div>