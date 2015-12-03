<?php
//file: /controller/CommentsController.php

//require_once(__DIR__."/../model/User.php");
session_start();
require_once(__DIR__."/../model/Establecimiento.php");
require_once(__DIR__."/../model/Usuario.php");
require_once(__DIR__."/../model/UsuarioMapper.php");
require_once(__DIR__."/../model/EstablecimientoMapper.php");
require_once(__DIR__."/../controller/BaseController.php");
/**
 * Class EstablecimientoController
 *
 * Controller for Establecimiento.
 *
 * @author Yago Rodríguez Lorenzo
 */

class EstablecimientoController extends BaseController{

    private $establecimientoMapper;
    private $usuarioMapper;

    public function __construct() {
        parent::__construct();
        $this->usuarioMapper = new UsuarioMapper();
        $this->establecimientoMapper = new EstablecimientoMapper();
    }

    public function index(){
        $this->view->setVariable("establecimientos", $this->establecimientoMapper->listarEstablecimientos());
        $this->view->render("establecimientos","index");
    }
    public function view(){
        $this->view->setVariable("establecimiento", $this->establecimientoMapper->fill($_GET["id"]));
        $this->view->render("establecimientos", "view");
    }

    public function modificar(){

        if(isset($_POST["email"])) {
            if($_FILES['avatar'] and $_FILES['avatar']['name']) {
                $name =  $_POST["email"] . "." . substr(strrchr($_FILES['avatar']['name'], '.'), 1);
                $path = "img/usuarios/" . $name;
                move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
                $foto= $name;
            }

            $establecimiento = (new EstablecimientoMapper())->fill($_POST["email"]);

            if(isset($_POST["password"]) and !empty($_POST["password"])) $establecimiento->setPassword($_POST["password"]);
            if(isset($_FILES['avatar']['name']) and !empty($_FILES['avatar']['name'])) $establecimiento->setFotoUsuario($foto);

            $establecimiento->setTelefono($_POST["telefono"]);
            $establecimiento->setCoordenadas($_POST["coordenadas"]);
            $establecimiento->setDireccion($_POST["direccion"]);


            if($this->establecimientoMapper->modificarEstablecimiento($_POST["email"],$establecimiento)){
                $msg = array();
                array_push($msg, array("success", "Establecimiento modificado correctamente"));
                $this->view->setFlash($msg);

                $this->view->setVariable("establecimiento", $this->establecimientoMapper->fill($_POST["email"]));
                $this->view->redirect("concurso", "view");
            }else{
                $msg = array();
                array_push($msg, array("error", "Ocurrió un error al guardar los datos"));
                $this->view->setFlash($msg);
                $this->view->redirect("concurso", "view");
            }
        }


        $this->view->setVariable("establecimiento", $this->establecimientoMapper->fill($_GET["id"]));
        $this->view->render("establecimientos", "modificar");
    }


}