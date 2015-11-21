<?php

//file: /controller/CodigosController.php

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

            $msg = array();
            array_push($msg, array("success", "Códigos generados correctamente"));
            $this->view->setFlash($msg);
        }

        $this->view->setVariable("codigos", $this->codigoMapper->getCodigosEstablecimiento($_SESSION["user"]));
        $this->view->render("codigo", "generar");
    }

    public function introducir(){
        if(isset($_POST["codigo"])){
            $codigo = $_POST["codigo"];

            if($this->codigoMapper->existe($codigo)) {
                if(!$this->codigoMapper->usado($codigo)) {
                    $this->codigoMapper->asociarUsuario($codigo, $_SESSION["user"]);

                    $msg = array();
                    array_push($msg, array("success", "El pincho fue añadido correctamente"));
                    $this->view->setFlash($msg);
                } else {
                    $msg = array();
                    array_push($msg, array("error", "El código introducido ya ha sido utilizado"));
                    $this->view->setFlash($msg);
                }

            } else {
                $msg = array();
                array_push($msg, array("error", "El código introducido no existe"));
                $this->view->setFlash($msg);
            }

        }

        $this->view->render("codigo", "introducir");
    }
}

