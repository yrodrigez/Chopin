

<div id= "votar">
    <form class="form-horizontal" action="../../index.php?controller=pincho&action=introducirVotacion" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nombrePincho">Pincho elegido:</label>
            <input type="text" class="form-control" name="idCodigoElegido" required="true">
        </div>
        <div class="form-group">
            <label for="nombrePincho">Pincho pa quemar 1:</label>
            <input type="text" class="form-control" name="idCodigoUtilizado1" required="true">
        </div>
        <div class="form-group">
            <label for="nombrePincho">Pincho pa quemar 2:</label>
            <input type="text" class="form-control" name="idCodigoUtilizado2" required="true">
        </div>
        <button type="submit" class="btn btn-default">Presentar</button>
    </form>
</div>
