<?php

require_once("C:\Users\Jose Miguel\Desktop\ABP\ABP\model\PinchoMapper.php");
require_once("C:\Users\Jose Miguel\Desktop\ABP\ABP\model\Pincho.php");


    $ingredientes = array(
        "Queso",
        "jamon",
        "tomate",
        "albahaca",
    );
    $pincho = new Pincho(0,"pincho1","desc1",$ingredientes,2,"unEmail",0,"unPath1");
    $pinchoMapper = new PinchoMapper();
    //$pinchoMapper->save($pincho);
    $pincho2 = $pinchoMapper->getPincho(31);
    //echo $pincho2->getEmailPincho().$pincho2->getIdPincho().$pincho2->getNombrePincho();
    foreach($pincho2->getIngredientesPincho() as $ingrediente){
       echo $ingrediente;
    }
$mysqltime = date ("Y-m-d H:i:s",time());
$pinchoMapper->agregarVoto(1,2,3,$mysqltime);
$pinchoMapper->agregarPinchoUsuario(5,"unEmail");


?>