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
}