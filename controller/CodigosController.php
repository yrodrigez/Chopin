<?php
//file: /controller/CommentsController.php

require_once(__DIR__."/../model/Codigo.php");

require_once(__DIR__."/../model/CodigoMapper.php");
require_once(__DIR__."/../model/PinchoMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

class CodigosController extends BaseController {

    private $codigoMapper;

    public function __construct() {
        parent::__construct();

        $this->codigoMapper = new CodigoMapper();
    }

    public function generar() {
        if(isset($_POST['numCodigos'])) {
            $prop = (new PinchoMapper())->getPinchoValidado($_SESSION["user"]);
            $codigo = new Codigo(NULL, $prop);
            $this->codigoMapper->generar($codigo, $_POST['numCodigos']);
        } else {
            $this->view->render("codigo", "generar");
        }

    }
}

?>