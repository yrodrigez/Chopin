<?php
// file: model/pinchoMapper.php
require_once("/../core/PDOConnection.php");
require_once("/../model/Pincho.php");
/**
 * Class pinchoMapper
 *
 * Database interface for User entities
 * 
 * @author José Miguel Meilán Maldonado 
 */

class pinchoMapper {
  /**
   * Reference to the PDO connection
   * @var PDO
   */
  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }

  /**
   * Saves a Pincho into the database
   * 
   * @param Pincho $pincho The pincho to be saved
   * @throws PDOException if a database error occurs
   * @return void
   */      
  public function save(
        $pincho
  ) {
    $stmt = $this->db->prepare(
      "INSERT INTO Propuesta(precio, idpropuesta, nombre, descripcion, email, aprobada, fotoPropuesta) 
      VALUES (?, ?, ?, ?, ?, ?, ?);"
    );
    $stmt->execute(array($pincho->getPrecioPincho(), 
                         $pincho->getIdPincho(), 
                         $pincho->getNombrePincho(), 
                         $pincho->getDescripcionPincho(), 
                         $pincho->getEmailPincho(), 
                         $pincho->getAprobadaPincho(), 
                         $pincho->getFotoPincho()));  
  }

  /**
   * Gets the pincho specified by the id
   * 
   * @param Int $id The id of the pincho we want to retrieve
   * @throws PDOException if a database error occurs
   * @return Pincho The pincho with the id, NULL if its not found
   */
  public function getPincho(
          $idPincho
  ) {
    $stmt = $this->db->prepare("SELECT * FROM Propuesta WHERE idpropuesta=?");
    $stmt->execute(array($idPincho));
    if(!($stmt->num_rows==0)) {
      foreach (
        $stmt as $stmt
      ) {
        $ingredientes = getIngredientesPincho($idPincho);
        return new Pincho(
          $stmt["idpropuesta"],
          $stmt["nombre"],
          $stmt["descripcion"],
          $ingredientes,
          $stmt["precio"],
          $stmt["email"],
          $stmt["aprobada"],
          $stmt["fotoPropuesta"]
        );
      }
    } else {
      return NULL;
    }
  }


  /**
   * Gets the ingredients of the Pincho specified by the id
   * 
   * @param Int $id The id of the pincho we want to get the ingredients from
   * @throws PDOException if a database error occurs
   * @return Array Array with the ingredients of the specified Pincho, else returns NULL
   */
  public function getIngredientesPincho(
          $idPincho
  ) {
    $stmt = $this->db->prepare("SELECT nombreCategoria FROM ingredientes WHERE idpropuesta=?");
    $stmt->execute(array($idPincho));
    if(!$stmt->num_rows==0) {
      return $stmt;
    } else {
      return NULL;
    }
  }

    /**
   * Changes the approved flag of the Pincho specified by the id
   * 
   * @param Int $id The id of the pincho we want to change the approved flag
   * @throws PDOException if a database error occurs
   * @return True if the SQL query was successful
   */
  public function aceptarPincho(
          $idPincho
  ) {
    $stmt = $this->db->prepare("UPDATE aprobada = ? WHERE idpropuesta = ?;");
    return $stmt->execute(array(1,$idPincho));
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
    $stmt = $this->db->prepare("UPDATE codigo SET utilizado = ?, elegido = ?, fechaVotacion = ? WHERE idcodigo = ?;");
    $toReturn = $stmt->execute(array(1,1, $fechaVotacion, $idCodigoElegido));
    $stmt = $this->db->prepare("UPDATE codigo SET utilizado = ?, fechaVotacion = ? WHERE idcodigo = ? OR idcodigo = ?;");
    return $toReturn && $stmt->execute(array(1, $fechaVotacion, $idCodigoUtilizado1, $idCodigoUtilizado2));
  }

  /**
   * Assigns a pincho to an user (He ate the pincho)
   * 
   * @param Int $idCodigo The id of the code of the pincho to assign to an user
   * @param string $emailUser The user we want to assign the code to
   * @throws PDOException if a database error occurs
   * @return True when all the updates were successful
   */
  public function agregarPinchoUsuario(
          $idCodigo,
          $emailUser
  ) {
    $stmt = $this->db->prepare("UPDATE codigo SET email = ? WHERE idcodigo = ?;");
    return $stmt->execute(array($emailUser, $idCodigo));
  }
}
?>