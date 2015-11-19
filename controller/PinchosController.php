<?php
//file: /controller/CommentsController.php

//require_once(__DIR__."/../model/User.php");
session_start();
require_once(__DIR__."/../model/Pincho.php");

require_once(__DIR__."/../model/PinchoMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
 * Class PinchoController
 * 
 * Controller for pincho related use cases.
 * 
 * @author Jose Miguel Meilan Maldonado
 */

class PinchosController extends BaseController {


  private $pinchoMapper;

  public function __construct() {
    parent::__construct();

    $this->pinchoMapper = new PinchoMapper();
  }

  /**
   * An establishment presents a Pincho, the pincho needs to be approved afterwards by the organizer
   *
   * @return Void
   */
  public function presentar(){
    if(isset($_POST['nombrePincho'])){
      if ((isset($_SESSION["user"])) && ($_SESSION["type"] == 3)) {
        if(!$this->pinchoMapper->existePincho($_SESSION["user"])){
          $direccionDestino= __DIR__."/../img/pinchos/".$_SESSION["user"];
          $subirFoto = PinchoController::subirImagen($direccionDestino);
          $fotoPath = $direccionDestino."/".$_FILES["fotoPincho"]["name"];
          $ingredientes = explode(",", $_POST['ingredientesPincho']);
          $pincho = new Pincho (
              0,
              $_POST['nombrePincho'],
              $_POST['descripcionPincho'],
              $ingredientes,
              $_POST['precioPincho'],
              $_SESSION["user"],
              NO_APROBADO,
              $fotoPath
          );
          $this->pinchoMapper->save($pincho);
          if(!$subirFoto) {
            echo "Hubo un error subiendo la imagen";
          }
          $this->view->redirect("concurso", "view"); //redirigir a los datos introducidos una vista view de propuesta presentada
        } else {
          echo "Este establecimiento ya propuso un pincho";
        }

      } else {
        echo "Debe estar logueado como establecimiento para poder presentar un pincho";
      }
    }
    $this->view->render("pinchos","view");
  }


  /**
   * Checks if everything is okay in order to upload a picture
   * @param String $path The path to check
   * @return True if the picture was uploaded successfully
   */

  public function subirImagen($path){
    if(!file_exists($path)){
      mkdir($path, true);
    }
    if (file_exists($path.$_FILES["fotoPincho"]["name"])) {
      unlink($path.$_FILES["fotoPincho"]["name"]);
    }
    if ($_FILES["fotoPincho"]["size"] > 5242880) {
      return false;
    }
    if (move_uploaded_file($_FILES["fotoPincho"]["tmp_name"], $path."/".$_FILES["fotoPincho"]["name"])) {
      return true;
    }
    else return false;
  }

  public function aprobar(){
    if (isset($_SESSION["user"]) && $_SESSION["type"] == 0) {
      $this->pinchoMapper->aceptarPincho($_GET['id']);
      //$this->view->render('pinchos','index'); cuando exista tendrá que ir a pinchosIndex o como se llame
    }
  }

  public function votar(

  ) {
    if(
        isset($_SESSION["user"])
        && isset($_SESSION["type"])
        && $_SESSION['type'] == Usuario::JURADO_POPULAR
    ) {
      if (
          isset($_POST['idCodigoElegido'])
          && isset($_POST['$idCodigoUtilizado1'])
          && isset($_POST['$idCodigoUtilizado2'])
      ) {
        return $this->pinchoMapper->agregarVoto(
            $_POST['idCodigoElegido'],
            $_POST['$idCodigoUtilizado1'],
            $_POST['$idCodigoUtilizado2'],
            date("Y-m-d H:i:s", time())
        );
      }
      echo "<br><span style='red'>Error PinchoController::introducirVotacion(), parámetros no validos</span> "; //borrar después
      return false;
    }
    echo "<br><span style='red'>Error PinchoController::introducirVotacion(), sin sesión</span> "; //borrar después
    return false;
  }

  public function listarPinchos(

  ) {
    return $this->pinchoMapper->getAllPinchos();
  }


  public function listarPinchosUsuario(

  ){
    if(
        isset($_SESSION["user"])
        && isset($_SESSION["type"])
        && $_SESSION['type'] == Usuario::JURADO_POPULAR
    ) {
      return $this->pinchoMapper->listarPinchosUsuario($_SESSION['user']);
    }
    echo "<br><span style='color: red;'>Error PinchosController::listar(), usuario incorrecto</span>";
  }

}
