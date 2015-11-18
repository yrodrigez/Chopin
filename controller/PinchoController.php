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

    /**
     * @return bool|True
     */
    public function introducirVotacion()
    {
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

    /**
     * @return bool|True
     */
    public function introducirCodigo()
    {
        if(
            isset($_SESSION["user"])
            && isset($_SESSION["type"])
            && $_SESSION['type'] == Usuario::JURADO_POPULAR
        ) {
            if (
                isset($_POST["idUsuario"])
                && isset($_POST["Codigo"])
            ) {
                return $this->pinchoMapper->agregarPinchoUsuario(
                    $_POST["Codigo"],
                    $_POST["idUsuario"]
                );
            } else {
                echo "<br><span style='red'>Error PinchoController::introducirCodigo(), sin código o idusuario</span> "; //borrar después
                return false;
            }
        }else{
            echo "<br><span style='red'>Error PinchoController::introducirCodigo(), sin sesion o no es jurado popular</span> "; //borrar después
            return false;
        }

    }


}
