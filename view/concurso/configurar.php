<div id="formConfigurarConcurso">
	<h3>Introduzca los datos del concurso</h3>
	<form class="form-horizontal" action="../../index.php?controller=concurso&action=add" method="POST">
		<div class="form-group">
			<label for="nombre">Nombre:</label>
			<input type="text" class="form-control" name="nombre" required="true">
		</div>
		<div class="form-group">
			<label for="descripcion">Descripcion:</label>
			<textarea id ="descripcionConcurso" name="descripcion" rows ="10" required="true"></textarea>
		</div>
		<div class="form-group">
			<label for="localizacion">Localizacion:</label>
			<input type="text" class="form-control" name="localizacion" required="true" placeholder="Indique la ciudad del concurso">
		</div>
		<div class="form-group">
			<label for="fecha">Fecha:</label>
			<input type="text" class="form-control" name="fecha" required="true" placeholder="Introduzca la fecha con formato AAAA-MM-DD">
		</div>
		<button type="submit" class="btn btn-default">Configurar</button>
	</form>
</div>