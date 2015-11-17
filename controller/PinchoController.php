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
   * @return True if the pincho was successfully presented 
   */
  public function presentar(){

    if ((isset($_SESSION["user"])) && ($_SESSION["type"] == 3)) {
      if(!$this->pinchoMapper->existePincho($_SESSION["user"])){
          $pincho = new Pincho (
          0,
          $_POST['nombrePincho'],
          $_POST['descripcionPincho'],
          $_POST['ingredientes'],
          $_POST['precioPincho'],
          $_SESSION["user"],
          NO_APROBADO,
          $_POST['fotoPincho']
          );
           $this->pinchoMapper->save($pincho);
          return true;
          } else {
            echo "Este establecimiento ya propuso un pincho";
            return false;
          }
    } else {
      echo "Debe estar logueado como establecimiento para poder presentar un pincho";
      return false;
    }

  }

  public function aprobar(){
    if (isset($_SESSION["user"]) && $_SESSION["type"] == 0) {
      $this->pinchoMapper->aceptarPincho($_GET['id']);
      //$this->view->render('pinchos','index'); cuando exista tendrá que ir a pinchosIndex o como se llame
    }

  }

  public function view(){
    $datos = $this->pinchoMapper->getPincho($_GET['id']);
    $this->view->setVariable('pincho',$datos);
    $this->view->render('pinchos','view');
  }
}
