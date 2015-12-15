<?php
//file: view/posts/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
/**
 * @var $establecimiento Establecimiento
 */
$establecimiento = $view->getVariable("establecimiento");

$view->setVariable("title", "Datos del usuario"); ?>


<script>
    var geocoder;
    var map;
    function initialize() {
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(<?= preg_replace("/\\(([0-9.-]*), ([0-9.-]*)\\)/", "$1, $2", $establecimiento->getCoordenadas()) ?>);
        var mapOptions = {
            zoom: 18,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

        var pos = <?= preg_replace("/\\(([0-9.-]*), ([0-9.-]*)\\)/", "{lat: $1, lng: $2}", $establecimiento->getCoordenadas()) ?>;
        var marker = new google.maps.Marker({map: map, position: pos});
    }

</script>

<div>
    <div class="view-title"><h2><?= $establecimiento->getNombre(); ?></h2></div>
    <div class="view-img"><img src="<?= 'img/usuarios/'.$establecimiento->getFotoUsuario(); ?>"></div>
    <div class="view-description">

        <table class="table table-striped table-bordered">
            <tr>
                <th>Dirección: </th>
                <td><?= $establecimiento->getDireccion(); ?></td>
            </tr>
            <tr>
                <th>Horario: </th>
                <td><?= $establecimiento->getHorario(); ?></td>
            </tr>
            <tr>
                <th>Telefono: </th>
                <td><?= $establecimiento->getTelefono(); ?></td>
            </tr>
            <tr>
                <th>Email: </th>
                <td><?= $establecimiento->getEmail(); ?></td>
            </tr>
            <!--<tr>
                <th>Coordenadas: </th>
                <td><?= $establecimiento->getCoordenadas(); ?></td>
            </tr>-->
        </table>
    </div>

    <?php if(isset($_SESSION["type"]) && $_SESSION["type"] == Usuario::ORGANIZADOR || ($_SESSION["type"] == Usuario::ESTABLECIMIENTO && $establecimiento->getEmail() == $_SESSION["user"])): ?>
        <div class="view-confirm">
            <a href="index.php?controller=establecimiento&action=modificar&id=<?= $establecimiento->getEmail(); ?>"
               class="btn btn-default"
               role="button">Modificar cuenta</a>

        </div>
        <?php if($_SESSION["type"] == Usuario::ORGANIZADOR): ?>
            <div class="view-confirm">
                <a id="show"
                   class="btn btn-default"
                   role="button">Eliminar</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div id="map-canvas"></div>
</div>


<?php $view->moveToFragment("script"); ?>
	$(function() {
		$('#show').avgrund({
			height: 150,
			holderClass: 'custom',
			showClose: true,
			showCloseText: 'close',
			onBlurContainer: '.container',
			template: '<br><p class="confirm-title">¿Seguro que quieres eliminar el establecimiento seleccionado?</p>' +
			'<div>' +
			'<a href="index.php?controller=establecimiento&action=eliminar&id=<?= $establecimiento->getEmail(); ?>" class="btn btn-default confirm-btn">Si</a>' +
				'<a href="index.php?controller=establecimiento&action=view&id=<?= $establecimiento->getEmail(); ?>#" class="btn btn-default confirm-btn avgrund-close-ws">No</a>' +
				'</div>'
		});
	});

    initialize();
<?php $view->moveToDefaultFragment(); ?>
