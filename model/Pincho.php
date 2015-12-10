<?php
// file: model/pincho.php
//require_once(__DIR__."/../core/ValidationException.php");
/**
 * Class pincho
 * 
 * Represents a "Pincho" in the system
 * 
 * @author Jose Miguel Meilan Maldonado
 */
class pincho {
  /**
   * The id of the pincho
   * @var int
   */
  private $idPincho;
  /**
   * The name of the pincho
   * @var string
   */
  private $nombrePincho;
  /**
   * A brief description of the pincho
   * @var string
   */
  private $descripcionPincho;
  /**
   * The ingredients of the pincho
   * @var Array of String
   */
  private $ingredientesPincho;
  /**
   * The price of the pincho
   * @var float
   */
  private $precioPincho;
  /**
   * The email of the establishment
   * @var string
   */
  private $emailPincho;
  /**
   * If the pincho has been approved or not
   * @var int
   */
  private $aprobadaPincho;
  /**
   * The picture of the pincho
   * @var int
   */
  private $fotoPincho;

  /**
   * The constructor
   * 
   * @param string $nombrePincho The name of the pincho
   * @param string $descripcionPincho Brief description of the pincho
   * @param arrayStrings $ingredientesPincho Ingredients of the pincho
   * @param float  $precioPincho Price of the pincho
   * @param string $emailPincho Email of the establishment that proposed the pincho
   * @param int  $aprobadaPincho If the pincho has been approved or not
   * @param string $fotoPincho Path of the picture of the pincho
   */
  const NO_APROBADO =  0;
  const APROBADO = 1;
  const NO_UTILIZADO = 0;
  const UTILIZADO = 1;
  const NO_ELEGIDO = 0;
  const ELEGIDO =1;
  public function __construct(
          $idPincho=NULL, 
          $nombrePincho=NULL, 
          $descripcionPincho=NULL, 
          $ingredientesPincho=NULL, 
          $precioPincho=NULL, 
          $emailPincho=NULL, 
          $aprobadaPincho=NULL, 
          $fotoPincho=NULL
  ) {
    $this->idPincho= $idPincho;
    $this->nombrePincho = $nombrePincho;
    $this->descripcionPincho = $descripcionPincho;
    $this->ingredientesPincho = $ingredientesPincho;
    $this->precioPincho = $precioPincho; 
    $this->emailPincho = $emailPincho; 
    $this->aprobadaPincho = $aprobadaPincho; 
    $this->fotoPincho = $fotoPincho;    
  }
  /**
   * Gets the id of this pincho
   * 
   * @return string The id of this pincho
   */  
  public function getIdPincho() {
    return $this->idPincho;
  }
  /**
   * Sets the id of this pincho
   * 
   * @param string $idPincho The id of this pincho
   * @return void
   */  
  public function setIdPincho(
          $idPincho
  ) {
    $this->idPincho = $idPincho;
  }
  /**
   * Gets the name of this pincho
   * 
   * @return string The name of this pincho
   */  
  public function getNombrePincho() {
    return $this->nombrePincho;
  }
  /**
   * Sets the name of this pincho
   * 
   * @param string $nombrePincho The name of this pincho
   * @return void
   */  
  public function setNombrePincho(
          $nombrePincho
  ) {
    $this->nombrePincho = $nombrePincho;
  }
  
  /**
   * Gets the description of this pincho
   * 
   * @return string The description of this pincho
   */  
  public function getDescripcionPincho() {
    return $this->descripcionPincho;
  }
  /**
   * Sets the description of this pincho
   * 
   * @param string $descripcionPincho The description of this pincho
   * @return void
   */  
  public function setDescripcionPincho(
          $descripcionPincho
  ) {
    $this->descripcionPincho = $descripcionPincho;
  }

  /**
   * Gets the ingredients of this pincho
   * 
   * @return string The ingredients of this pincho
   */  
  public function getIngredientesPincho() {
    return $this->ingredientesPincho;
  }
  /**
   * Sets the ingredients of this pincho
   * 
   * @param string $ingredientespincho The ingredients of this pincho
   * @return void
   */  
  public function setIngredientesPincho(
          $ingredientesPincho
  ) {
    $this->ingredientesPincho = $ingredientesPincho;
  }

  /**
   * Gets the price of this pincho
   * 
   * @return string The price of this pincho
   */  
  public function getPrecioPincho() {
    return $this->precioPincho;
  }
  /**
   * Sets the price of this pincho
   * 
   * @param string $precioPincho The price of this pincho
   * @return void
   */  
  public function setPrecioPincho(
          $precioPincho
  ) {
    $this->precioPincho = $precioPincho;
  }

  /**
   * Gets the email of this pincho
   * 
   * @return string The email of the establishment that proposed this pincho
   */  
  public function getEmailPincho() {
    return $this->emailPincho;
  }
  /**
   * Sets the email of this pincho
   * 
   * @param string $emailPincho The email of this pincho
   * @return void
   */  
  public function setEmailPincho(
          $emailPincho
  ) {
    $this->emailPincho = $emailPincho;
  }

  /**
   * Gets the approved flag of this pincho
   * 
   * @return string The approved flag of this pincho
   */  
  public function getAprobadaPincho() {
    return $this->aprobadaPincho;
  }
  /**
   * Sets the approved flag of this pincho
   * 
   * @param string $aprobadaPincho The approved flag of this pincho
   * @return void
   */  
  public function setAprobadaPincho(
          $aprobadaPincho
  ) {
    $this->aprobadaPincho = $aprobadaPincho;
  }

  /**
   * Gets the picture path of this pincho
   * 
   * @return string The picture path of this pincho
   */  
  public function getFotoPincho() {
    return $this->fotoPincho;
  }
  /**
   * Sets the picture path of this pincho
   * 
   * @param string $fotoPincho The new picture path of this pincho
   * @return void
   */  
  public function setFotoPincho(
          $fotoPincho
  ) {
    $this->fotoPincho = $fotoPincho;
  }

  public function getPinchosGanadoresPopulares(){
    $mapper = new PinchoMapper();
    return $mapper->getGanadoresPopulares();
  }
}
?>