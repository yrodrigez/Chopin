<?php
	require_once(__DIR__."/../controller/BaseController.php");
	require_once(__DIR__."/../model/CodigoMapper.php");

/**
 * Class CodigosController
 * 
 * Controller for codes related use cases.
 * 
 * @author Lorena Docasar
 */

class CodigosController extends BaseController {


  private $codigosMapper;
  
  public function __construct() {
    parent::__construct();
    
    $this->codigosMapper = new CodigoMapper();
  }

  public function generar(){
  	$id = $_GET['id'];
	$num = $_GET['num'];
	$this->codigosMapper->generar($id, $num);
  }

  public function listar(){
  	$idPropuesta = $_GET['$idpropuesta'];
  	$this->codigosMapper->retornarCodigosEstablecimiento($idPropuesta);
  }
  
}
?>