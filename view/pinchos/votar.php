

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
<!-- public function introducirVotacion()
    {
        if(
            isset($_SESSION["user"])
            && isset($_SESSION["type"])
            && $_SESSION['type'] == Usuario::JURADO_POPULAR
        ) {
            if (
                isset($_POST['idCodigoElegido'])
                && isset($_POST['$idCodigoUtilizado1'])
                && isset($_POST['$idCodigoUtilizado2'])
            ) {
                return $this->pinchoMapper->agregarVoto(
                    $_POST['idCodigoElegido'],
                    $_POST['$idCodigoUtilizado1'],
                    $_POST['$idCodigoUtilizado2'],
                    date("Y-m-d H:i:s", time())
                );
            }
            echo "<br><span style='red'>Error PinchoController::introducirVotacion(), parámetros no validos</span> "; //borrar después
            return false;
        }
        echo "<br><span style='red'>Error PinchoController::introducirVotacion(), sin sesión</span> "; //borrar después
        return false;
    }-->
