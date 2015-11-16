<?php
// file: model/pinchoMapper.php
require_once("/../core/PDOConnection.php");
require_once("/../model/Pincho.php");
require_once("/../model/ConstantesPincho.php");
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
   * @return True if the pincho was successfully saved in the DB
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

    $pinchoInsertado = $this->db->lastInsertId();
    $stmt = $this->db->prepare(
        "INSERT INTO Ingredientes(idpropuesta, nombreCategoria) VALUES (?, ?);"
    );
    foreach($pincho->getIngredientesPincho() as $ingrediente){
      $stmt->execute(array($pinchoInsertado,
          $ingrediente));
    }
    return true;
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
    if($stmt->rowCount()>0) {
      foreach (
        $stmt as $pincho
      ) {
        $ingredientes = $this->getIngredientesPincho($idPincho);
        return new Pincho(
          $pincho["idpropuesta"],
          $pincho["nombre"],
          $pincho["descripcion"],
          $ingredientes,
          $pincho["precio"],
          $pincho["email"],
          $pincho["aprobada"],
          $pincho["fotoPropuesta"]
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
    $ingredientes = array();
    $stmt = $this->db->prepare("SELECT nombreCategoria FROM ingredientes WHERE idpropuesta=?");
    $stmt->execute(array($idPincho));
    $i = $stmt->rowCount();
    while($i>0) {
      array_push($ingredientes, $stmt->fetchColumn());
      $i--;
    }
    return $ingredientes;
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
    $stmt = $this->db->prepare("UPDATE Propuesta Set aprobada = ? WHERE idpropuesta = ?;");
    return $stmt->execute(array(APROBADO,$idPincho));
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
    $toReturn = $stmt->execute(array(UTILIZADO,ELEGIDO, $fechaVotacion, $idCodigoElegido));
    $stmt = $this->db->prepare("UPDATE codigo SET utilizado = ?, fechaVotacion = ? WHERE idcodigo = ? OR idcodigo = ?;");
    return $toReturn && $stmt->execute(array(UTILIZADO, $fechaVotacion, $idCodigoUtilizado1, $idCodigoUtilizado2));
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
  /**
   * Deletes a pincho
   * 
   * @param Int $idPincho The id of the pincho we want to delete
   * @throws PDOException if a database error occurs
   * @return True if the pincho was successfully deleted
   */
  public function borrarPincho(
          $idPincho
  ) {
    $stmt = $this->db->prepare("DELETE FROM Propuesta WHERE idpropuesta= ?;");
    return $stmt->execute(array($idPincho));
  }

  /**
   * Checks if it exists a Pincho with the specified email (foreign key)
   * 
   * @param String $email The email (foreign key) to check
   * @throws PDOException if a database error occurs
   * @return True If it exists a Pincho with the specified foreign key, else false
   */
  public function existePincho(
          $email
  ) {
    $stmt = $this->db->prepare("SELECT * FROM Propuesta WHERE email=?");
    $stmt->execute(array($email));
    if($stmt->rowCount()>0) {
      return true;
    } else {
      return false;
    }
  }
}
?>