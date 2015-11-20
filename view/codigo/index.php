<?php
    require_once(__DIR__."/../../controller/PinchosController.php");
?>

<h2>Introduce tu código</h2>

<form action="index.php?controller=pinchos&amp;action=introducirpincho" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="codigo">Código:</label>
        <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Introduce el código">
    </div>
    <button type="submit" class="btn btn-default">Introducir</button>
</form>
