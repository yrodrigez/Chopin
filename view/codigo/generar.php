<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Generar códigos");
$codigos = $view->getVariable("codigos");
?>

<h2>Generar c&oacute;digos</h2>

<form action="index.php?controller=codigos&amp;action=generar" method="POST" data-toggle="validator">
    <div class="form-group">
        <input type="text" class="form-control" name="numCodigos" id="numCodigos" placeholder="Introduce el número de códigos a generar" pattern="^[0-9]{1,3}$" required>
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
                <td><?= (($codigo->getEmail())?"Si":"No"); ?></td>
                <td><?= (($codigo->getEmail())?$codigo->getEmail():"-"); ?></td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
<?php endif; ?>