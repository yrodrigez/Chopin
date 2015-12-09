<?php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$view->setVariable("title", "Modificar usuario");

/**
 *
 * @var $establecimiento Establecimiento
 */

$establecimiento = $view->getVariable("establecimiento");
?>

<script>
    var geocoder;
    var map;
    var lastMarker = null;

    function initialize() {
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(<?= preg_replace("/\\(([0-9.-]*), ([0-9.-]*)\\)/", "$1, $2", $establecimiento->getCoordenadas()) ?>);
        var mapOptions = {
            zoom: 12,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

        var pos = <?= preg_replace("/\\(([0-9.-]*), ([0-9.-]*)\\)/", "{lat: $1, lng: $2}", $establecimiento->getCoordenadas()) ?>;
        var marker = new google.maps.Marker({map: map, position: pos});
    }

    function codeAddress() {
        var address = document.getElementById("direccion").value;
        geocoder.geocode({'address': address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {

                if(lastMarker != null) {
                    lastMarker.setMap(null);
                }

                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });

                lastMarker = marker;
                document.getElementById("coordenadas").value = results[0].geometry.location;
            } else {
                document.getElementById("coordenadas").value = "";
            }
        });
    }

</script>

<div id="formPresentarPincho">
    <div class="view-title">
        <h2>Introduzca los datos que desea modificar</h2>
    </div>
    <form class="form-horizontal"
          action="index.php?controller=establecimiento&action=modificar"
          method="POST"
          enctype="multipart/form-data"
          data-toggle="validator">
        <div class="form-group">
            <label for="email">Email: </label>
            <input type="text"
                   disabled="true"
                   class="form-control"
                   name="mostrar"
                   id="mostrar"
                   value="<?= $establecimiento->getEmail();?>">
            <input type="hidden" name="email" value="<?= $establecimiento->getEmail();?>">
        </div>
        <div class="form-group">
            <label for="passwd">Password:</label>
            <input type="password"
                   class="form-control"
                   name="password"
                   id="password"
                   placeholder="Escribe aqui tu nueva contraseña..."
                   data-minlength="6"
                   data-error="La contraseña debe tener al menos 6 caracteres">
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text"
                   class="form-control"
                   name="nombre" id="nombre"
                   value="<?= $establecimiento->getNombre();?>"
                   required>
        </div>
        <div class="form-group">
            <label for="horario">Horario:</label>
            <input type="text"
                   class="form-control"
                   name="horario" id="horario"
                   value="<?= $establecimiento->getHorario();?>"
                   required>
        </div>
        <div class="form-group">
            <label for="tel">Tel&eacute;fono:</label>
            <input type="text"
                   class="form-control"
                   name="telefono" id="telefono"
                   value="<?= $establecimiento->getTelefono();?>"
                   pattern="^[0-9]{9}$"
                   data-error="El teléfono introducido no es válido">
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="avatar">Foto de perfil:</label>
            <input type="file" class="file file-loading" name="avatar" id="avatar" data-show-upload="false" data-allowed-file-extensions='["jpg", "png", "bmp", "gif"]'>
        </div>
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text"
                   class="form-control"
                   name="direccion"
                   id="direccion"
                   onkeypress="codeAddress()"
                   value="<?= $establecimiento->getDireccion();?>">
        </div>
        <div class="form-group">
            <label for="coordenadas">Coordenadas</label>
            <input type="text"
                   class="form-control"
                   name="coordenadas"
                   id="coordenadas"
                   readonly
                   required
                   value="<?= $establecimiento->getCoordenadas();?>">
        </div>
        <div id="map-canvas"></div>
        <div id="divBtn" class="form-group">
            <button type="submit" class="btn btn-default btnForm">Modificar</button>
        </div>
    </form>
</div>


<?php $view->moveToFragment("script"); ?>
    $("#avatar").fileinput({
    defaultPreviewContent: '<img src=img/usuarios/<?= ($establecimiento->getFotoUsuario())?$establecimiento->getFotoUsuario():"default.png" ?> alt="Avatar">',
    });

    initialize();
<?php $view->moveToDefaultFragment(); ?>