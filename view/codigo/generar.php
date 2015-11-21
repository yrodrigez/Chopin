<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Generar códigos");
$codigos = $view->getVariable("codigos");
?>

<h2>Generar c&oacute;digos</h2>

<form action="introducir.php?controller=codigos&amp;action=generar" method="POST">
    <div class="form-group">
        <input type="number" class="form-control" name="numCodigos" id="numCodigos" placeholder="Introduce el número de códigos a generar">
    </div>
    <button type="submit" class="btn btn-default">Generar</button>
</form>

<br><br>

<?php if(sizeof($codigos)==0): ?>
    A&uacute;n no se han generado c&oacutedigos.
<?php else: ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>C&oacute;digo</th>
            <th>Utilizado</th>
            <th>Usuario</th>
        </tr>
        </thead>

        <tbody>

        <?php foreach($codigos as $codigo): ?>
            <tr>
                <td><?= $codigo->getIdCodigo(); ?></td>
                <td><?= (($codigo->getUtilizado()==1)?"Si":"No"); ?></td>
                <td><?= (($codigo->getUtilizado()==1)?$codigo->getEmail():"-"); ?></td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
<?php endif; ?>