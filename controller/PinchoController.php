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

class PinchoController extends BaseController {


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

/**
 * Changes the flags of used and chosen of three codes
 *
 * @param Int $idCodigoElegido The id of the code the user wants to vote
 * @param Int $idCodigoUtilizado1 The id of the pincho we want to mark as used
 * @param Int $idCodigoUtilizado2 The id of the second pincho we want to mark as used
 * @param string $fechaVotacion The date when the voting ocurred
 * @throws PDOException if a database error occurs
 * @return True when all the updates were successful
 */
  public function agregarVoto(
    $idCodigoElegido,
    $idCodigoUtilizado1,
    $idCodigoUtilizado2,
    $fechaVotacion
  ) {

    if($this->sonCodigosDistintos(
      $idCodigoElegido,
      $idCodigoUtilizado1,
      $idCodigoUtilizado2
    )) {
      $stmt = $this->db->prepare("UPDATE codigo SET utilizado = ?, elegido = ?, fechaVotacion = ? WHERE idcodigo = ?;");
      $toReturn = $stmt->execute(array(UTILIZADO, ELEGIDO, $fechaVotacion, $idCodigoElegido));
      $stmt = $this->db->prepare("UPDATE codigo SET utilizado = ?, fechaVotacion = ? WHERE idcodigo = ? OR idcodigo = ?;");
      return $toReturn && $stmt->execute(array(UTILIZADO, $fechaVotacion, $idCodigoUtilizado1, $idCodigoUtilizado2));
    } else {
      return false;
    }
    return false;
  }

  private function sonCodigosDistintos(
    $idCodigoElegido,
    $idCodigoUtilizado1,
    $idCodigoUtilizado2
  ) {
    $propuestas= array();
    $stmt = $this->db->prepare("SELECT idpropuesta FROM codigo WHERE idcodigo= ? OR idcodigo= ? OR idcodigo= ?");
    $stmt->execute(array(
      $idCodigoElegido,
      $idCodigoUtilizado1,
      $idCodigoUtilizado2
    ));
    $i = $stmt->rowCount();
    while($i>0) {
      array_push($propuestas, $stmt->fetchColumn());
      $i--;
    }

    if(count($propuestas != 3)) return false;
    $id1= $propuestas[0];
    $id2= $propuestas[1];
    $id3= $propuestas[2];
    if($id1!=$id2 && $id1!=$id3 && $id2!=$id3){
      return true;
    }
    return false;
  }




}

