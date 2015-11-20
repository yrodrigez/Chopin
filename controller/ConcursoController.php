<?php
//file: /controller/CommentsController.php

//require_once(__DIR__."/../model/User.php");
session_start();
require_once(__DIR__."/../model/Concurso.php");

require_once(__DIR__."/../model/ConcursoMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
 * Class CommentsController
 * 
 * Controller for comments related use cases.
 * 
 */

class ConcursoController extends BaseController {


	private $concursomapper;

	public function __construct() {
		parent::__construct();

		$this->concursomapper = new ConcursoMapper();
	}


	public function add() {
		if ((isset($_SESSION["user"])) && ($_SESSION["type"] == 0)){
			if (!$this->concursomapper->existeConcurso()){
				$this->view->render("concurso","configurar");
			} else {
				if($_POST["nombre"] == NULL || $_POST["localizacion"] == NULL || $_POST["fecha"] == NULL) {  // TODO: add isset($_POST["submit"]))
				echo "Deben especificarse un nombre, una localización y una fecha";
				}				
				// TODO: Check if valid
				$concurso =  new Concurso($_POST["nombre"], $_POST["descripcion"], $_POST["localizacion"], $_POST["fecha"]);
				$this->concursomapper->add($concurso);
				$this->view->redirect("concurso", "view");
			}
		} else {
			echo "Solo el organizador puede agregar un concurso";
			$this->view->redirect("concurso", "view");
		}		
	}

	public function view() {

		$concurso = $this->concursomapper->getInfo();

		if ($concurso == NULL) {
			$this->view->render("concurso", "configurar");
		} else {
			$this->view->setVariable("concurso", $concurso);
			$this->view->render("concurso", "view");
		}
	}   
}
