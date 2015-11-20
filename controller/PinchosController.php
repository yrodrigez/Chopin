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
    if(isset($_SESSION["user"]) && ($_SESSION["type"] == Usuario::ESTABLECIMIENTO)){
      if (!$this->pinchoMapper->existePincho($_SESSION["user"])) {
        if(isset($_POST['nombrePincho'])){
          $subirFoto = PinchosController::subirImagen();
          $fotoPath = $_FILES["fotoPincho"]["name"];
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
          $this->view->setVariable("pincho", $pincho);
          $this->view->render("pinchos", "view"); //redirigir a los datos introducidos una vista view de propuesta presentada
        } else {
          $this->view->render("pinchos","presentar");
        }

      } else {
        $this->view->redirect("pinchos","view");
        echo "Este establecimiento ya propuso un pincho";
      }
    } else {
        $this->view->redirect("pinchos","listar");
        echo "Debe estar logueado como establecimiento para poder presentar un pincho";
    }
  }


  /**
   * Checks if everything is okay in order to upload a picture
   * @return True if the picture was uploaded successfully
   */

  public function subirImagen(){
    if (file_exists("/img/pinchos/".$_FILES["fotoPincho"]["name"])) {
      unlink("/img/pinchos/".$_FILES["fotoPincho"]["name"]);
    }
    if ($_FILES["fotoPincho"]["size"] > 5242880) {
      return false;
    }
    if (move_uploaded_file($_FILES["fotoPincho"]["tmp_name"], "/img/pinchos/".$_FILES["fotoPincho"]["name"])) {
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

  public function votar() {
    if(isset($_SESSION["user"])
      && isset($_SESSION["type"])
      && $_SESSION['type'] == Usuario::JURADO_POPULAR
      && count($_POST["pinchos"]) == 1
      ) {
      $idQuemar = array();
      $idElegido = $_POST["pinchos"][0];
      foreach($_POST["idpinchos"] as $pincho){
        if($pincho != $idElegido){
          array_push($idQuemar, $pincho);
        }
      }
      if($this->pinchoMapper->agregarVoto(
          $this->pinchoMapper->getCodigoPincho($idElegido),
          $this->pinchoMapper->getCodigoPincho($idQuemar[0]),
          $this->pinchoMapper->getCodigoPincho($idQuemar[1]),
          date ("Y-m-d H:i:s",time())
      )){
        $msg = array();
        array_push($msg, array("success", "Votación recibida"));
        $this->view->setFlash($msg);
        $this->view->redirect("pinchos", "getAllUsuarioCodigosPincho");
      } else {
        $msg = array();
        array_push($msg, array("error", "Error en votación"));
        $this->view->setFlash($msg);
        //$this->view->redirect("pinchos", "getAllUsuarioCodigosPincho");
      }
    } else {
      if(count($_POST["pinchos"]) == 1) {
        $msg = array();
        array_push($msg, array("error", "Debes seleccionar solamente uno (1) para votar (o es chávez)"));
        $this->view->setFlash($msg);
        $this->view->redirect("pinchos", "getAllUsuarioCodigosPincho");
      } else {
        $msg = array();
        array_push($msg, array("error", "Debes ser jurado popular para votar"));
        $this->view->setFlash($msg);
        $this->view->redirect("pinchos", "getAllUsuarioCodigosPincho");
      }

    }

  }

  public function listar(

    ) {
    $pinchos = $this->pinchoMapper->getAllPinchos();
    $this->view->setVariable("pinchos", $pinchos);
    $this->view->render("pinchos","listar");
  }



  public function listarPinchosUsuario(){
    if(
        isset($_SESSION["user"])
        && isset($_SESSION["type"])
        && $_SESSION['type'] == Usuario::JURADO_POPULAR
    ) {
      $this->view->setVariable(
          "pinchos",
          $this->pinchoMapper->listarPinchosUsuario($_SESSION['user'])
      );
      $this->view->render("pinchos", "mispinchos");
    }
  }

 public function view(){
    if(isset($_GET['id'])){
      $pincho = $this->pinchoMapper->getPincho($_GET['id']);
      $this->view->setVariable('pincho',$pincho);
      $this->view->render('pinchos','view');
    } else {
        if(isset($_SESSION["user"]) && ($_SESSION["type"] == Usuario::ESTABLECIMIENTO)){
          if ($this->pinchoMapper->existePincho($_SESSION["user"])) {
           $pincho = $this->pinchoMapper->getPinchoEstablecimiento($_SESSION['user']);
            $this->view->setVariable('pincho',$pincho);
            $this->view->render('pinchos','view');
          } else {
            $this->view->redirect("pinchos","presentar");
          }
        } else {
        $this->view->redirect("pinchos","listar");
      }
    }
  }

  public function getAllUsuarioCodigosPincho()
  {
    if (isset($_SESSION['user'])) {
      $codigos = array();
      $pinchos = $this->pinchoMapper->listarPinchosUsuario($_SESSION['user']);
      foreach ($pinchos as $pincho) {
        array_push($codigos, $this->pinchoMapper->getCodigoPincho($pincho->getIdPincho()));
      }
      $this->view->setVariable("codigos", $codigos);
      $this->view->setVariable("pinchos", $pinchos);
      $this->view->setVariable("votar", 0);
      $this->view->render("pinchos", "votar");
    } else {
      $this->view->redirect("concurso",  "view");
    }
  }
  public function seleccion() {
    if(
        isset($_POST["pinchos"])
        &&isset($_SESSION["user"])
        &&count($_POST["pinchos"]) == 3
    ){
      $idPinchos = $_POST["pinchos"];
      $codigos = array();
      $pinchos = array();
      foreach($idPinchos as $pinchoId){
        array_push($codigos, $this->pinchoMapper->getCodigoPincho($pinchoId));
      }
      foreach($idPinchos as $idPincho){
        array_push($pinchos, $this->pinchoMapper->getPincho($idPincho));
      }
      $this->view->setVariable("codigos", $codigos);
      $this->view->setVariable("pinchos", $pinchos);
      $this->view->setVariable("votar", 1);
      $this->view->render("pinchos", "votar");
    } else {
      if(count($_POST["pinchos"]) != 3){
        $msg = array();
        array_push($msg, array("error", "Debes seleccionar exactamente tres (3) pinchos, pajúo."));
        $this->view->setFlash($msg);
        $this->view->redirect("pinchos", "getAllUsuarioCodigosPincho");
      } else {
        $this->view->redirect("concurso", "view");
      }
    }
  }
  public function introducircodigo(){
    if(isset($_POST["codigo"])){
      $valoresCodigo= explode("_", $_POST["codigo"]);

    } else {
      $this->view->render("codigo", "index");
    }
  }
}
