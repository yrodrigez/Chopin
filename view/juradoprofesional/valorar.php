<?php
//file: view/juradoprofesional/mispinchos.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
/**
 * @var $pincho Pincho
 */
$pincho = $view->getVariable("pincho");
$view->setVariable("title", "Valoración: ".$pincho->getNombrePincho());

?>

<div class="view-title">
    <h2><?= $view->getVariable("title") ?></h2>
</div>
<!-- FOTO DEL PINCHO -->
<div class="view-img"><img src="<?= 'img/pinchos/'.$pincho->getFotoPincho(); ?>"></div>
<!-- VALORACIÓN A BASE DE ESTRELLAS -->
<form class="form-valoracion">
    <input id="input-21b" value="0" type="number" class="rating" min=0 max=5 step=0.1 data-size="lg">
    <button type="submit" class="btn btn-default">Valorar</button>
</form>
<!-- INFORMACIÓN ADICIONAL DEL PINCHO -->
<div class="view-description">
    <table class="table table-striped table-bordered">
        <tr>
            <th>Descripci&oacute;n</th>
            <td><?= $pincho->getDescripcionPincho(); ?></td>
        </tr>
        <tr>
            <th>Precio</th>
            <td><?= $pincho->getPrecioPincho(); ?> €</td>
        </tr>
        <tr>
            <th>Contacto</th>
            <td><?= $pincho->getEmailPincho(); ?></td>
        </tr>
    </table>
</div>

<script>
    jQuery(document).ready(function () {
        $("#input-21f").rating({
            starCaptions: function(val) {
                if (val < 3) {
                    return val;
                } else {
                    return 'high';
                }
            },
            starCaptionClasses: function(val) {
                if (val < 3) {
                    return 'label label-danger';
                } else {
                    return 'label label-success';
                }
            },
            hoverOnClear: false
        });

        $('#rating-input').rating({
            min: 0,
            max: 5,
            step: 1,
            size: 'lg',
            showClear: false
        });

        $('#btn-rating-input').on('click', function() {
            $('#rating-input').rating('refresh', {
                showClear:true,
                disabled:true
            });
        });


        $('.btn-danger').on('click', function() {
            $("#kartik").rating('destroy');
        });

        $('.btn-success').on('click', function() {
            $("#kartik").rating('create');
        });

        $('#rating-input').on('rating.change', function() {
            alert($('#rating-input').val());
        });


        $('.rb-rating').rating({'showCaption':true, 'stars':'3', 'min':'0', 'max':'3', 'step':'1', 'size':'xs', 'starCaptions': {0:'status:nix', 1:'status:wackelt', 2:'status:geht', 3:'status:laeuft'}});
    });
</script>