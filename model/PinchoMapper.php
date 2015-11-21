<?php
// file: model/pinchoMapper.php
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Pincho.php");

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
    foreach($pincho->getIngredientesPincho() as $ingrediente){
      $ingredienteDB = $this->comprobarCategoria($ingrediente);
      if($ingredienteDB==NULL){
        $stmt = $this->db->prepare(
         "INSERT INTO categoria(nombreCategoria) VALUES (?);"
         );
        $stmt->execute(array($ingrediente));
        $stmt = $this->db->prepare(
          "INSERT INTO Ingredientes(idpropuesta, nombreCategoria) VALUES (?, ?);"
          );
        $stmt->execute(array($pinchoInsertado,
          $ingrediente));
      } else {
        $stmt = $this->db->prepare(
          "INSERT INTO Ingredientes(idpropuesta, nombreCategoria) VALUES (?, ?);"
          );
        $stmt->execute(array($pinchoInsertado,
          $ingredienteDB));
      }
      
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
    $stmt = $this->db->prepare("SELECT * FROM propuesta WHERE idpropuesta=?");
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

  public function getCodigoPincho(
    $idPincho
  ){
    $stmt = $this->db->prepare("SELECT idcodigo FROM codigo WHERE idpropuesta= ?");
    if($stmt->execute(array($idPincho))){
      return $stmt->fetchColumn();
    }
    return null;
  }

  /**
   * Checks if there's an ingredient like the one specified
   * 
   * @param String $categoria The ingredient we want to check if its already in the DB
   * @throws PDOException if a database error occurs
   * @return String Returns the String if the category is already in the DB, else NULL
   */
  public function comprobarCategoria(
    $categoria 
    ) {
    $category = strToUpper(substr($categoria, 0, 1).substr($categoria, 1));
    $stmt = $this->db->prepare("SELECT * FROM categoria WHERE nombreCategoria = ?");
    $stmt->execute(array($category));
    if($stmt->rowCount()>0) {
      return $stmt->fetchColumn();
      //return true;
    } else {
      //return false;
      return null;
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
    echo $idCodigoElegido.$idCodigoUtilizado1.$idCodigoUtilizado2.$fechaVotacion;
    if($this->sonCodigosDistintos(
        $idCodigoElegido,
        $idCodigoUtilizado1,
        $idCodigoUtilizado2
    )) {
      $stmt = $this->db->prepare("UPDATE codigo
                                  SET utilizado = ?,
                                  elegido = ?,
                                  fechaVotacion = ?
                                  WHERE idcodigo = ?;
                                  ");

      $toReturn = $stmt->execute(array(
          Pincho::UTILIZADO,
          Pincho::ELEGIDO,
          $fechaVotacion,
          $idCodigoElegido));
      $stmt = $this->db->prepare("UPDATE codigo
                                  SET utilizado = ?,
                                  fechaVotacion = ?
                                  WHERE idcodigo = ?
                                  OR idcodigo = ?;");
      return $toReturn && $stmt->execute(array(
          Pincho::UTILIZADO,
          $fechaVotacion,
          $idCodigoUtilizado1,
          $idCodigoUtilizado2
      ));
    } else {
      return false;
    }
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

    if(count($propuestas) != 3) return false;
    $id1= $propuestas[0];
    $id2= $propuestas[1];
    $id3= $propuestas[2];
    if($id1!=$id2 && $id1!=$id3 && $id2!=$id3){
      return true;
    }
    return false;
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

  public function getPinchoValidado(
      $email
  ) {
    $stmt = $this->db->prepare("SELECT * FROM propuesta WHERE email=? AND aprobada=1");
    $stmt->execute(array($email));
    if($stmt->rowCount()>0) {
      $prop = $stmt->fetch(PDO::FETCH_ASSOC);
      return $prop["idpropuesta"];
    } else {
      return -1;
    }
  }

  /**
   * @param $idUsuario
   * @return array de todos los pinchos relacionados con el usuario
   */
  public function listarPinchosUsuario(
      $idUsuario
  ) {
    $pinchos = array();
    $stmt = $this->db->prepare("SELECT idpropuesta FROM codigo WHERE email= ? AND utilizado= ?");
    if($stmt->execute(array(
        $idUsuario,
        Pincho::NO_ELEGIDO
    ))){
      if($stmt->rowCount() > 0){
        $i = $stmt->rowCount();
        while($i>0) {
          array_push($pinchos, $this->getPincho($stmt->fetchColumn()));
          $i--;
        }
      }
    }
    return $pinchos;
  }

  /**
   * @return array de pinchos si existen y array vacío si no hay ningun pincho
   */
  public function getAllPinchos(

  ){
    $pinchos= array();
    $stmt = $this->db->prepare("SELECT idpropuesta FROM propuesta");
    if($stmt->execute(array())){
      if($stmt->rowCount() > 0){
        $i = $stmt->rowCount();
        while($i>0) {
          array_push($pinchos, $this->getPincho($stmt->fetchColumn()));
          $i--;
        }
      }
    }
    return $pinchos;
  }

  /**
   * Gets the pincho associated with an establishment
   * 
   * @param String $email The email of the establishment
   * @throws PDOException if a database error occurs
   * @return Pincho The pincho of the establishment, NULL if its not found
   */
  public function getPinchoEstablecimiento(
    $email
    ) {
    $stmt = $this->db->prepare("SELECT * FROM Propuesta WHERE email=?");
    $stmt->execute(array($email));
    if($stmt->rowCount()>0) {
      foreach (
        $stmt as $pincho
        ) {
        $ingredientes = $this->getIngredientesPincho($pincho["idpropuesta"]);
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

}
