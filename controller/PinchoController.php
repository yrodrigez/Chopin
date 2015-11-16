<?php
//file: /controller/CommentsController.php

//require_once(__DIR__."/../model/User.php");
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

    if ((isset($_SESSION['user'])) && ($_SESSION['type'] == 3)) {
      $pincho = new Pincho (
          $_POST['nombrePincho'],
          $_POST['descripcionPincho'],
          $_POST['ingredientesPincho'],
          $_POST['precioPincho'],
          $_SESSION['user'],
          NO_APROBADO,
          $_POST['fotoPincho']
      );
      $this->pinchoMapper->save($pincho);
      return true;
    } else {
      echo "Debe estar logueado como establecimiento para poder presentar un pincho";
      return false;
    }

  }
}
