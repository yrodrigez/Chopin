<?php
//file: view/users/register.php

require_once(__DIR__ . "/../../core/ViewManager.php");
require_once(__DIR__ . "/../../model/Concurso.php");
require_once(__DIR__ . "/../../model/ConcursoMapper.php");
$concurso = (new ConcursoMapper())->getInfo();
$view = ViewManager::getInstance();
$errors = $view->getVariable("errors");
$user = $view->getVariable("user");
$view->setVariable("title", "Registro");
?>

    <script>
        var geocoder;
        var map;
        var lastMarker = null;

        function initialize() {
            geocoder = new google.maps.Geocoder();
            var latlng = new google.maps.LatLng(<?= preg_replace("/\\(([0-9.-]*), ([0-9.-]*)\\)/", "$1, $2", $concurso->getCoordenadas()) ?>);
            var mapOptions = {
                zoom: 8,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
        }

        function codeAddress() {
            var address = document.getElementById("dir").value;
            geocoder.geocode({'address': address}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {

                    if (lastMarker != null) {
                        lastMarker.setMap(null);
                    }

                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });

                    lastMarker = marker;
                    document.getElementById("cord").value = results[0].geometry.location;
                } else {
                    document.getElementById("cord").value = "";
                }
            });
        }
    </script>

    <div class="view-title"><h2>Registro</h2></div>
    <form role="form" action="index.php?controller=usuarios&amp;action=register" method="POST"
          enctype="multipart/form-data" data-toggle="validator">
        <div class="form-group">
            <label for="username">Email:</label>
            <input type="email" class="form-control" name="username" id="username" placeholder="Introduce un email"
                   data-error="El email introducido no es válido" required>

            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="passwd">Password:</label>
            <input type="password" class="form-control" name="passwd" id="passwd"
                   placeholder="Introduce una contrase&ntilde;a" data-minlength="6"
                   data-error="La contraseña debe tener al menos 6 caracteres" required>

            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="tel">Tel&eacute;fono:</label>
            <input type="text" class="form-control" name="tel" id="tel" placeholder="Introduce un tel&eacute;fono"
                   pattern="^[0-9]{9}$" data-error="El teléfono introducido no es válido">

            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="avatar">Foto de perfil:</label>
            <input type="file" class="file file-loading" name="avatar" id="avatar" data-show-upload="false"
                   data-allowed-file-extensions='["jpg", "png", "gif"]'>
        </div>

        <div class="form-group">
            <label for="preferences">Preferencias</label>
            <input type="text" class="form-control" name="prefs" id="prefs"
                   placeholder="Introduzca sus preferencias culinarias">
        </div>

        <?php if (!$concurso->isStarted()): ?>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text"
                       class="form-control"
                       name="nombre" id="nombre"
                       placeholder="Introduzca el nomnbre del establecimiento"
                       required>
            </div>
            <div class="form-group">
                <label for="horario">Horario:</label>
                <input type="text"
                       class="form-control"
                       name="horario" id="horario"
                       placeholder="Introduzca los horarios del establecimiento"
                       required>
            </div>
            <div class="form-group">
                <label for="dir">Direcci&oacute;n</label>
                <input type="text" class="form-control" name="dir" id="dir" placeholder="Introduce una direcci&oacute;n"
                       onkeypress="codeAddress()" required>
            </div>
            <div class="form-group">
                <label for="cord">Coordenadas:</label>
                <input type="text" class="form-control" name="cord" id="cord"
                       placeholder="Se calculará en base a la dirección" readonly required>
            </div>
            <div id="map-canvas"></div>
        <?php endif; ?>

        <button type="submit" class="btn btn-default">Registrar</button>
    </form>

<?php $view->moveToFragment("script"); ?>
    initialize();
<?php $view->moveToDefaultFragment(); ?>