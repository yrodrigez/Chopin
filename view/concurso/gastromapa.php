<?php
require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$establecimientos = $view->getVariable("establecimientos");
$concurso = $view->getVariable("concurso");

$view->setVariable("title", "Gastromapa");
?>

<script>
    var geocoder;
    var map;
    function initialize() {
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(<?= preg_replace("/\\(([0-9.-]*), ([0-9.-]*)\\)/", "$1, $2", $concurso->getCoordenadas()) ?>);
        var mapOptions = {
            zoom: 12,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
        
        <?php foreach($establecimientos as $est): ?>
            var pos = <?= preg_replace("/\\(([0-9.-]*), ([0-9.-]*)\\)/", "{lat: $1, lng: $2}", $est->getCoordenadas()) ?>;
            var marker = new google.maps.Marker({map: map, position: pos});
        <?php endforeach; ?>
    }

</script>

<div id="map-canvas"></div>

<?php $view->moveToFragment("script"); ?>
    initialize();
<?php $view->moveToDefaultFragment(); ?>