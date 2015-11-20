<?php
// file: model/codigoMapper.php
require_once("/../core/PDOConnection.php");
require_once("/../model/Pincho.php");
require_once("/../model/ConstantesPincho.php");
/**
 * Class codigoMapper
 *
 * Database interface for User entities
 * 
 * @author Lorena Docasar 
 */

	class CodigoMapper {
	  /**
	   * Reference to the PDO connection
	   * @var PDO
	   */
	  private $db;
	  
	  public function __construct() {
	    $this->db = PDOConnection::getInstance();
	  }

	  public function generar($id, $num){
	  	$stmt = $this->db->prepare( "SELECT COUNT(*) AS offset FROM Codigo WHERE idcodigo LIKE ?-");
	  	$stmt->execute(array($id));
	  	$offset = $stmt["offset"];

	  	$stmt = $this->db->prepare(
      	"INSERT INTO Codigo(idcodigo, idpropuesta, utilizado, elegido, fechaVotacion) VALUES (?, ?, ?, ?, ?);");
	  	$cont = 0;
	  	while($cont > $num){
	  		$stmt->execute(array($id."-".($offset + $cont),$id,0,0,date("Y-m-d")));
	  	}
	  }

	  public function retornarCodigosEstablecimiento($id){
	  	$stmt = $this->db->query("SELECT * FROM codigo, propuesta WHERE propuesta.email=".$id);
		$codigos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$codigos = $array();

		foreach ($codigos_db as $codigos) {
			$codigo = new Codigo($codigos_db['idpropuesta'],$codigos_db['idcodigo']);
			array_push($codigos, $codigo);
		}

		return $codigos;
	  }

	}
  ?>
