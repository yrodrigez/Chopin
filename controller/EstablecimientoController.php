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
        $this->view->setVariable("establecimiento", $this->establecimientoMapper->fill($_GET["id"]));
        $this->view->render("establecimientos", "modificar");
    }

    public function guardarModificacion(){
        $email= $_POST["email"];
        $password= $_POST["password"];
        $preferencias="";
        $tipo= Usuario::ESTABLECIMIENTO;
        $foto="img/usuarios/default.png";
        if($_FILES['avatar'] and $_FILES['avatar']['name']) {
            $path = "img/usuarios/" . basename( $_FILES['avatar']['name']);
            move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
            $foto= basename($_FILES['avatar']['name']);
        }
        $coordenadas= $_POST["coordenadas"];
        $direccion= $_POST["direccion"];
        $telefono= $_POST["telefono"];
        $establecimiento= new Establecimiento(
            $email,
            $password,
            "",
            $tipo,
            $telefono,
            $foto,
            $coordenadas,
            $direccion
        );
        if(
            $this->establecimientoMapper->modificarEstablecimiento($email,$establecimiento)
        ){
            $this->view->setVariable("establecimiento", $this->establecimientoMapper->fill($email));
            $this->view->render("establecimientos", "modificar");
        }else{

        }

    }
}