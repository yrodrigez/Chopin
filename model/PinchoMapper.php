<?php
// file: model/pinchoMapper.php
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Pincho.php");
require_once(__DIR__."/../model/IngredienteMapper.php");
require_once(__DIR__."/../model/ComentarioMapper.php");
require_once(__DIR__."/../model/CodigoMapper.php");

/**
 * Class pinchoMapper
 *
 * Database interface for User entities
 * 
 * @author José Miguel Meilán Maldonado 
 */

class PinchoMapper {
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
      "INSERT INTO pincho(precio, idpincho, nombre, descripcion, email, aprobada, foto)
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

      $stmt = $this->db->prepare(
          "INSERT INTO ingredientes(idpincho, nombreCategoria) VALUES (?, ?);"
      );
      $stmt->execute(array($pinchoInsertado, $ingrediente));
    }
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
    $stmt = $this->db->prepare("SELECT * FROM pincho WHERE idpincho=?");
    $stmt->execute(array($idPincho));
    if($stmt->rowCount()>0) {
      foreach (
        $stmt as $pincho
        ) {
        $ingredientes = $this->getIngredientesPincho($idPincho);
      return new Pincho(
        $pincho["idpincho"],
        $pincho["nombre"],
        $pincho["descripcion"],
        $ingredientes,
        $pincho["precio"],
        $pincho["email"],
        $pincho["aprobada"],
        $pincho["foto"]
        );
    }
  } else {
    return NULL;
  }
}

  public function getCodigoPincho(
    $idPincho
  ){
    $stmt = $this->db->prepare("SELECT idcodigo FROM codigo WHERE idpincho= ? AND email = ?");
    if($stmt->execute(array($idPincho, $_SESSION["user"]))){
      return $stmt->fetchColumn();
    }
    return null;
  }

  public function getCodigoPinchoNoUtilizado($idPincho) {
    $stmt = $this->db->prepare("SELECT idcodigo FROM codigo WHERE idpincho= ? AND email = ? AND utilizado = ?");
    if($stmt->execute(array($idPincho, $_SESSION["user"], Pincho::NO_UTILIZADO))){
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
  /*public function comprobarCategoria(
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
  }*/

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
    $stmt = $this->db->prepare("SELECT nombreCategoria FROM ingredientes WHERE idpincho=?");
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
    $stmt = $this->db->prepare("UPDATE pincho Set aprobada = ? WHERE idpincho = ?;");
    return $stmt->execute(array(Pincho::APROBADO,$idPincho));
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
    //echo $idCodigoElegido."-".$idCodigoUtilizado1."-".$idCodigoUtilizado2."-".$fechaVotacion;
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

  public function sonCodigosDistintos(
      $idCodigoElegido,
      $idCodigoUtilizado1,
      $idCodigoUtilizado2
  ) {

    $propuestas= array();
    $stmt = $this->db->prepare("SELECT idpincho FROM codigo WHERE idcodigo= ? OR idcodigo= ? OR idcodigo= ?");
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
    }else {
      return false;
    }
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
      (new CodigoMapper())->borrar($idPincho);
      (new IngredienteMapper())->borrar($idPincho);
      (new ComentarioMapper())->deleteByIdPincho($idPincho);

      $stmt = $this->db->prepare("DELETE FROM pincho WHERE idpincho= ?;");
      $stmt->execute(array($idPincho));
  }


  public function borrarPinchoEstablecimiento(
      $estab
  ) {
    $id = $this->getPinchoEstablecimiento($estab)->getIdPincho();
    $this->borrarPincho($id);
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
    $stmt = $this->db->prepare("SELECT * FROM pincho WHERE email=?");
    $stmt->execute(array($email));

    return $stmt->rowCount()>0;
  }

  public function getPinchoValidado(
      $email
  ) {
    $stmt = $this->db->prepare("SELECT * FROM pincho WHERE email=? AND aprobada=1");
    $stmt->execute(array($email));
    if($stmt->rowCount()>0) {
      $prop = $stmt->fetch(PDO::FETCH_ASSOC);
      return $prop["idpincho"];
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
    $stmt = $this->db->prepare("SELECT idpincho FROM codigo WHERE email= ? AND utilizado= ?");

    if($stmt->execute(array($idUsuario, Pincho::NO_UTILIZADO))){
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

  public function listarPinchosQuemadosUsuario(
      $idUsuario
  ) {
    $pinchos = array();
    $stmt = $this->db->prepare("SELECT idpincho FROM codigo WHERE email= ? AND utilizado= ?");

    if($stmt->execute(array($idUsuario, Pincho::UTILIZADO))){
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

  public function listarPinchosJuradoProfesional(
      $idUsuario, $iter
  ) {
    $pinchos = array();
    $stmt = $this->db->prepare("SELECT idpincho FROM valoracion WHERE email= ? AND iteracion = ?");

    if($stmt->execute(array($idUsuario, $iter))) {
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
   * @param $idUsuario
   * @return array de todos los pinchos relacionados con el usuario que han sido votados
   */
  public function misVotaciones(
      $idUsuario
  ) {
    $pinchos = array();
    $stmt = $this->db->prepare("SELECT idpincho, count(idpincho) FROM codigo WHERE email= ? AND elegido= ? GROUP BY idpincho");
    if($stmt->execute(array($idUsuario, Pincho::ELEGIDO))){
      if($stmt->rowCount() > 0){
        foreach (
        $stmt as $pincho
        ) {
          array_push($pinchos, array($this->getPincho($pincho["idpincho"]), 
                               $pincho["count(idpincho)"]));
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
    $stmt = $this->db->prepare("SELECT idpincho FROM pincho");
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

    $stmt = $this->db->prepare("SELECT * FROM pincho WHERE email=?");
    $stmt->execute(array($email));
    if($stmt->rowCount()>0) {
      $pincho = $stmt->fetch(PDO::FETCH_ASSOC);
      $ingredientes = $this->getIngredientesPincho($pincho["idpincho"]);

      return new Pincho(
        $pincho["idpincho"],
        $pincho["nombre"],
        $pincho["descripcion"],
        $ingredientes,
        $pincho["precio"],
        $pincho["email"],
        $pincho["aprobada"],
        $pincho["foto"]
        );
    }

    return NULL;

}
  public function getPinchosUsuarioGroupBy(
    $email
  ){
    $stmt = $this->db->prepare(
        "SELECT COUNT(*) FROM codigo WHERE email=? GROUP BY idpincho"
    );
    if(
      $stmt->execute(array($email))
    ) {
      return $stmt->rowCount();
    }
  }

  public function asignarPinchoAProfesional(
    $idPincho,
    $emailProfesional,
    $iter
  ){
    $stmt = $this->db->prepare(
       "INSERT INTO valoracion(idpincho, email, puntuacion, fecha, iteracion)
      VALUES (?, ?, -1, NULL, ?);"
    );
    return $stmt->execute(array($idPincho, $emailProfesional, $iter));
  }

  public function existePinchoProfesional(
    $idPincho,
    $emailProfesional,
    $iter
  ){
    $stmt = $this->db->prepare(
       "SELECT COUNT(*) FROM valoracion WHERE email=? and idpincho = ? and iteracion = ?;");
    if($stmt->execute(array($emailProfesional, $idPincho, $iter))) {
      $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
      return $resultado["COUNT(*)"];
    }
  }

  public function dameMiValoracion(
    $idPincho,
    $idProfesional,
    $iter
  ){
    $stmt= $this->db->prepare(
        "SELECT puntuacion FROM valoracion WHERE idpincho= ? AND email=? AND iteracion = ?"
    );
    $stmt->execute(array($idPincho, $idProfesional, $iter));
    $row= $stmt->fetch(PDO::FETCH_ASSOC);
    return $row["puntuacion"];
  }

  public function guardarValoracion(
      $valoracion,
      $idUsuario,
      $idPincho,
      $iter
  ){
    $stmt= $this->db->prepare(
        "UPDATE valoracion SET puntuacion = ? WHERE email = ? AND idpincho = ? AND iteracion = ?"
    );

     $stmt->execute(
        array(
          $valoracion,
          $idUsuario,
          $idPincho,
          $iter
        )
    );
  }

  public function getGanadoresPopulares($numGanadores){
    $stmt= $this->db->prepare("SELECT * FROM codigo WHERE elegido = '1'");
    $stmt->execute();
    $votosPopular = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $arrayVotos = "";
    foreach ($votosPopular as $fila) {
      if (isset($arrayVotos[$fila["idpincho"]])){
        $arrayVotos[$fila["idpincho"]]++;
      }else{
        $arrayVotos[$fila["idpincho"]] = 1;
      }
    }
    arsort($arrayVotos);
    $count = 0;
    foreach ($arrayVotos as $key => $value) {
      
      $mapper = new PinchoMapper();
      $target = $mapper->getPincho($key);
      $toRet["pincho_".$key."_obj"] = $target;
      $toRet["pincho_".$key."_votos"] = $value;
      $count++;
      if($count == $numGanadores) break;
    }
    return $toRet;
  }

  public function getGanadoresProfesionales($numGanadores){
    $stmt= $this->db->prepare("SELECT V.idpincho, (SELECT ROUND(AVG(puntuacion),2) FROM valoracion A WHERE A.idpincho = V.idpincho AND puntuacion <> -1) AS resultado FROM valoracion V WHERE puntuacion <> -1 GROUP BY V.idpincho");
    $stmt->execute();
    $votosProfesional = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $arrayVotosProf = "";
    foreach ($votosProfesional as $fila) {
      $arrayVotosProf[$fila["idpincho"]] = $fila["resultado"];
    }
    arsort($arrayVotosProf);
    $count = 0;
    foreach ($arrayVotosProf as $key => $value) {
      
      $mapper = new PinchoMapper();
      $target = $mapper->getPincho($key);
      $toRet["pincho_".$key."_obj"] = $target;
      $toRet["pincho_".$key."_resultado"] = $value;
      $count++;
      if($count == $numGanadores) break;
    }

    return $toRet;
  }

  /* Para la elección de los finalistas, se cogen los cinco mejor valorados tanto en la categoría popular
     como profesional. Para cada uno de los grupos el mejor valorado aporta cinco puntos, el segundo tres
     y los demás uno. */
  public function getFinalistas($numFinalistas){
    $pop = $this -> getGanadoresPopulares(5);
    $pro = $this -> getGanadoresProfesionales(5);

    foreach(array($pop, $pro) as $list) {
      $num = 5;
      foreach($list as $key => $value) {
        $pos = substr($key, 7, strrpos($key, "_", 8)-7);
        if(strrpos($key, "_obj")) {
          if(!isset($punt[$pos])) $punt[$pos] = 0;
          $punt[$pos] += $num;
          if($num > 1) $num -= 2;
        }
      }
    }

    $fin = array();
    $num = 1;
    $limit = $numFinalistas;
    foreach($punt as $id => $value) {
      if(isset($pop["pincho_" . $id . "_obj"])) {
        $fin["pincho_" . $num . "_obj"] = $pop["pincho_" . $id . "_obj"];
      } else {
        $fin["pincho_" . $num . "_obj"] = $pro["pincho_" . $id . "_obj"];
      }
      $num += 1;
      $limit -=1;
      if($limit == 0) break;
    }

    return $fin;
  }


  public function buscar($text) {
      $stmt= $this->db->prepare("SELECT * FROM pincho WHERE nombre like ?");
      $stmt->execute(array("%".$text."%"));
      $pinchos = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $ret = [];
      foreach ($pinchos as $pincho) {
          array_push($ret, new Pincho($pincho["idpincho"], $pincho["nombre"], $pincho["descripcion"], NULL, $pincho["precio"], $pincho["email"], $pincho["aprobada"], $pincho["foto"]));
      }
      return $ret;
  }

  public function asignadaIter($num) {
    $stmt = $this->db->prepare("SELECT * FROM valoracion WHERE iteracion=?;");

    $stmt->execute(array($num));
    return $stmt->rowCount()>0;
  }

}
