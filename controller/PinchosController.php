<?php
//file: /controller/CommentsController.php

//require_once(__DIR__."/../model/User.php");
session_start();
require_once(__DIR__."/../model/Pincho.php");
require_once(__DIR__."/../model/PinchoMapper.php");

require_once(__DIR__."/../model/Concurso.php");
require_once(__DIR__."/../model/ConcursoMapper.php");


require_once(__DIR__."/../model/ComentarioMapper.php");

require_once(__DIR__."/../model/JuradoProfesionalMapper.php");
require_once(__DIR__."/../model/EstablecimientoMapper.php");

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
    $this->jprofMapper = new JuradoProfesionalMapper();
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
          $subirFoto = $this->subirImagen();
          $fotoPath = (($subirFoto)?$_SESSION["user"].".".substr(strrchr($_FILES['fotoPincho']['name'], '.'), 1):"default.png");
          $ingredientes = explode(",", $_POST['ingredientesPincho']);
          $pincho = new Pincho (
            0,
            $_POST['nombrePincho'],
            $_POST['descripcionPincho'],
            $ingredientes,
            $_POST['precioPincho'],
            $_SESSION["user"],
            Pincho::NO_APROBADO,
            $fotoPath
            );

          $this->pinchoMapper->save($pincho);
          if(!$subirFoto) {
          	$msg = array();
        	array_push($msg, array("error", "Hubo un error subiendo la imagen"));
        	$this->view->setFlash($msg);
          }
          $this->view->setVariable("pincho", $pincho);
          $msg = array();
       	  array_push($msg, array("success", "Pincho presentado correctamente"));
          $this->view->setFlash($msg);
          $this->view->render("pinchos", "view"); //redirigir a los datos introducidos una vista view de propuesta presentada
        } else {
          $this->view->render("pinchos","presentar");
        }

      } else {
      	$msg = array();
        array_push($msg, array("error", "Este establecimiento ya propuso un pincho"));
        $this->view->setFlash($msg);
        $this->view->redirect("pinchos","view");
      }
    } else {
    	$msg = array();
        array_push($msg, array("error", "Debe estar logueado como establecimiento para poder presentar un pincho"));
        $this->view->setFlash($msg);
        $this->view->redirect("pinchos","listar");
    }
  }


  /**
   * Checks if everything is okay in order to upload a picture
   * @return True if the picture was uploaded successfully or no picture was added
   */

  public function subirImagen(){
    if(isset($_FILES['fotoPincho']) and $_FILES['fotoPincho']['name']) {
      $name = $_SESSION["user"] . "." . substr(strrchr($_FILES['fotoPincho']['name'], '.'), 1);
      $path = "img/pinchos/" . $name;
      move_uploaded_file($_FILES['fotoPincho']['tmp_name'], $path);
      return true;
    }

    return false;
  }

  public function aprobar(){
    if (isset($_SESSION["user"]) && $_SESSION["type"] == 0) {
      $this->pinchoMapper->aceptarPincho($_GET['id']);

      $msg = array();
      array_push($msg, array("success", "Propuesta aceptada correctamente"));
      $this->view->setFlash($msg);
      $this->view->redirect("pinchos","listar");
    } else {
      $this->view->redirect("pinchos","listar");
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
          $this->pinchoMapper->getCodigoPinchoNoUtilizado($idElegido),
          $this->pinchoMapper->getCodigoPinchoNoUtilizado($idQuemar[0]),
          $this->pinchoMapper->getCodigoPinchoNoUtilizado($idQuemar[1]),
          date ("Y-m-d H:i:s",time())
      )){
        $msg = array();
        array_push($msg, array("success", "Votación recibida"));
        $this->view->setFlash($msg);
        $this->view->redirect("pinchos", "misVotos");
      } else {
        $msg = array();
        array_push($msg, array("error", "Error en votación"));
        $this->view->setFlash($msg);
        $this->view->redirect("pinchos", "getAllUsuarioCodigosPincho");
      }
    } else {
      if(count($_POST["pinchos"]) != 1) {
        $msg = array();
        array_push($msg, array("error", "Debes seleccionar solamente uno (1) para votar"));
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
    if(isset($_SESSION["user"])
        && isset($_SESSION["type"])
    ) {
      if(
          $_SESSION['type'] == Usuario::JURADO_POPULAR
      ) {
        $this->view->setVariable(
            "pinchos",
            $this->pinchoMapper->listarPinchosUsuario($_SESSION['user'])
        );
        $this->view->setVariable(
            "totalSinRepetir",
            $this->pinchoMapper->getPinchosUsuarioGroupBy($_SESSION['user'])
        );
        $this->view->setVariable(
            "totalPinchos",
            count($this->pinchoMapper->getAllPinchos())
        );
        $this->view->setVariable("concurso", (new ConcursoMapper())->getInfo());

        $this->view->render("pinchos", "mispinchos");
      }
    }
  }

  public function listarPinchosJuradoProfesional(){
    if(isset($_SESSION["user"])
        && isset($_SESSION["type"])
        && $_SESSION['type'] == Usuario::JURADO_PROFESIONAL) {

        $concurso = (new ConcursoMapper())->getInfo();
        $iter = 0;
        if($concurso->isStarted2Iter() && !$concurso->isFinished()) $iter = 2;
        else if($concurso->isStarted() && !$concurso->isStarted2Iter()) $iter = 1;

        $this->view->setVariable("pinchos", $this->pinchoMapper->listarPinchosJuradoProfesional($_SESSION['user'], $this->iteracionActual()));
        $this->view->render("juradoprofesional", "mispinchos");
    }
  }

  public function iniciarValoracion() {
    if(isset($_SESSION["user"])
        && isset($_SESSION["type"])
        && isset($_GET["id"])
        && $_SESSION['type'] == Usuario::JURADO_PROFESIONAL
    ) {
        $this->view->setVariable(
            "pincho",
            $this->pinchoMapper->getPincho($_GET["id"])
        );
        $valoracion= $this->pinchoMapper->dameMiValoracion($_GET["id"], $_SESSION["user"], $this->iteracionActual());
        $this->view->setVariable("valoracion", $valoracion );
        $this->view->render("juradoprofesional", "valorar");

    }
  }

  private function iteracionActual() {
      $concurso = (new ConcursoMapper())->getInfo();
      $iter = 0;
      if($concurso->isStarted2Iter() && !$concurso->isFinished()) $iter = 2;
      else if($concurso->isStarted() && !$concurso->isStarted2Iter()) $iter = 1;
      return $iter;
  }

  public function valorar() {
    if(isset($_SESSION["user"])
        && isset($_SESSION["type"])
        && isset($_POST["valoracion"])
    ) {
      if (
          $_SESSION['type'] == Usuario::JURADO_PROFESIONAL
      ) {
        $this->pinchoMapper->guardarValoracion($_POST["valoracion"], $_SESSION["user"], $_POST["idpincho"], $this->iteracionActual());
        $this->view->setVariable(
            "pincho",
            $this->pinchoMapper->getPincho($_POST["idpincho"])
        );
        $this->view->setVariable("valoracion", $this->pinchoMapper->dameMiValoracion($_POST["idpincho"], $_SESSION["user"], $this->iteracionActual()));
        $this->view->render("juradoprofesional", "valorar");
      }
    }
  }


  public function misVotos(){
    if(isset($_SESSION["user"])
        && isset($_SESSION["type"])
        && $_SESSION['type'] == Usuario::JURADO_POPULAR
    ) {
      $this->view->setVariable(
          "votados",
          $this->pinchoMapper->misVotaciones($_SESSION['user'])
      );
      $this->view->render("pinchos", "misVotos");
    }
  }

 public function view(){
    if(isset($_GET['id'])){
      $pincho = $this->pinchoMapper->getPincho($_GET['id']);
      $concurso = (new ConcursoMapper())->getInfo();
      $comentarios = (new ComentarioMapper())->getById($_GET['id']);

      $this->view->setVariable('pincho',$pincho);
      $this->view->setVariable('concurso',$concurso);
      $this->view->setVariable('comentarios',$comentarios);
      $this->view->render('pinchos','view');
    } else {
        if(isset($_SESSION["user"]) && ($_SESSION["type"] == Usuario::ESTABLECIMIENTO)){
          if ($this->pinchoMapper->existePincho($_SESSION["user"])) {
            $pincho = $this->pinchoMapper->getPinchoEstablecimiento($_SESSION['user']);
            $concurso = (new ConcursoMapper())->getInfo();
            $this->view->setVariable('pincho',$pincho);
            $this->view->setVariable('concurso',$concurso);
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
        && isset($_SESSION["user"])
        && count($_POST["pinchos"]) == 3

    ){
      $idPinchos = $_POST["pinchos"];
      $codigos = array();
      $pinchos = array();
      foreach($idPinchos as $pinchoId){
        array_push($codigos, $this->pinchoMapper->getCodigoPincho($pinchoId));
      }
        if($this->pinchoMapper->sonCodigosDistintos(
            $codigos[0],
            $codigos[1],
            $codigos[2]
            )) {

            foreach ($idPinchos as $idPincho) {
                array_push($pinchos, $this->pinchoMapper->getPincho($idPincho));
            }
            $this->view->setVariable("codigos", $codigos);
            $this->view->setVariable("pinchos", $pinchos);
            $this->view->setVariable("votar", 1);
            $this->view->render("pinchos", "votar");
        }else{
            $msg = array();
            array_push($msg, array("error", "Debes seleccionar 3 codigos distintos."));
            $this->view->setFlash($msg);
            $this->view->redirect("pinchos", "getAllUsuarioCodigosPincho");
        }
    } else {
      if(count($_POST["pinchos"]) != 3){
        $msg = array();
        array_push($msg, array("error", "Debes seleccionar exactamente tres pinchos"));
        $this->view->setFlash($msg);
        $this->view->redirect("pinchos", "getAllUsuarioCodigosPincho");
      } else {
        $this->view->redirect("concurso", "view");
      }
    }
  }

  public function borrar() {
    if(isset($_GET['id'])){
      $this->pinchoMapper->borrarPincho($_GET['id']);
      $msg = array();
      array_push($msg, array("success", "Pincho borrado correctamente"));
      $this->view->setFlash($msg);
    }

    $this->view->redirect("pinchos", "listar");
  }

   public function asignar() {
    if(isset($_SESSION["user"]) && $_SESSION["type"] == 0){
      if(isset($_POST['nAsignar'])){
        $maxProf = $this->jprofMapper->getNumeroJurado();
        if(($_POST['nAsignar'] >= 1) and ($_POST['nAsignar'] <= $maxProf)){
          $jprofs = $this->jprofMapper->findAll();

          $concurso = (new ConcursoMapper())->getInfo();
          if($concurso->isStarted2Iter()) {
              $pinchos = $this->pinchoMapper->getFinalistas(3);
          } else {
              $pinchos = $this->pinchoMapper->getAllPinchos();
          }

          $cont = 0;

          $iter=1;
          $c = (new ConcursoMapper())->getInfo();
          if($c->isStarted2Iter() && !$this->pinchoMapper->asignadaIter(2) && !$c->isFinished()) $iter=2;
          //echo $iter; die();
          for ($i = 0; $i < $_POST['nAsignar']; ++$i) {
            shuffle($pinchos);
            //shuffle($jprofs);
            foreach ($pinchos as $pincho){
              if($this->pinchoMapper->existePinchoProfesional($pincho->getIdPincho(), $jprofs[$cont]->getEmail(), $iter) == 0){
                $this->pinchoMapper->asignarPinchoAProfesional($pincho->getIdPincho(), $jprofs[$cont]->getEmail(), $iter);
              } else {
                $asignado = true;
                while($asignado){
                  $random = array_rand($jprofs);
                  if($this->pinchoMapper->existePinchoProfesional($pincho->getIdPincho(), $jprofs[$random]->getEmail(), $iter) == 0){
                   $this->pinchoMapper->asignarPinchoAProfesional($pincho->getIdPincho(), $jprofs[$random]->getEmail(), $iter);
                   $asignado = false;
                  }
                }
              }
              $cont++;
              if($cont >= count($jprofs)) $cont = 0;
            }
          }
          $msg = array();
          array_push($msg, array("success", "Pinchos asignados correctamente a los miembros del jurado Profesional"));
          $this->view->setFlash($msg);
          $this->view->redirect("juradoprofesional", "index");
        } else {
          $msg = array();
          array_push($msg, array("error", "El numero indicado no es valido"));
          $this->view->setFlash($msg);
          $this->view->redirectToReferer();
        }
      } else {
        $nMax = $this->jprofMapper->getNumeroJurado();
        $this->view->setVariable("nMax", $nMax);
        $this->view->render("pinchos", "asignar");
      }
    } else {
       $msg = array();
       array_push($msg, array("error", "Esta accion esta disponible solo para el organizador"));
       $this->view->setFlash($msg);
       $this->view->redirect("juradoprofesional" , "index");
    }
  }


  public function buscar() {
    if(isset($_POST["text"]) and $_POST["cat"]) {
      //echo $_POST["text"]."-".$_POST["cat"]; die();

      switch($_POST["cat"]) {
        case "Pincho":
            $pinchos = $this->pinchoMapper->buscar($_POST["text"]);
            $this->view->setVariable("res", $pinchos);
            $this->view->setVariable("cat", "Pincho");
          break;
        case "Establecimiento":
          $establecimientos = (new EstablecimientoMapper())->buscar($_POST["text"]);
          $this->view->setVariable("res", $establecimientos);
          $this->view->setVariable("cat", "Establecimiento");
      }
      $this->view->render("pinchos", "buscar");
    } else {
      $this->view->render("pinchos", "buscar");
    }
  }

}
