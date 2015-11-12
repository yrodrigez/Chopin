<?php
//file: /controller/CommentsController.php

//require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/Concurso.php");

require_once(__DIR__."/../model/ConcursoMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
 * Class CommentsController
 * 
 * Controller for comments related use cases.
 * 
 * @author lipido <lipido@gmail.com>
 */
 
class ConcursoController extends BaseController {
  

  private $concursomapper;
  
  public function __construct() {
    parent::__construct();
    
    $this->concursomapper = new ConcursoMapper();
  }
  
  
  public function add() {
	  if($_POST["nombre"] == NULL || $_POST["localizacion"] == NULL || $_POST["fecha"] == NULL) {  // TODO: add isset($_POST["submit"]))
		  echo "Deben especificarse un nombre, una localización y una fecha";
	  }
	  
	  // (?) Check if valid
	  
	  $concurso =  new Concurso($_POST["nombre"], $_POST["descripcion"], $_POST["localizacion"], $_POST["fecha"]);
	  $this->concursomapper->add($concurso);
	  
	  $this->concursomapper->redirect("concurso", "view");
  }

  public function view() {
	
    /*if (!isset($this->currentUser)) {
      throw new Exception("Not in session. Adding posts requires login");
    }*/
    
    $concurso = $this->concursomapper->getInfo();
    
    if ($concurso == NULL) {
		throw new Exception("no existe el concurso");
    }

	$this->view->setVariable("concurso", $concurso);
	$this->view->render("concurso", "view");
  }  
}
