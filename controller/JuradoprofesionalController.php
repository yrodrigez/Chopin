<?php

require_once(__DIR__."/../core/ViewManager.php");

require_once(__DIR__."/../model/JuradoProfesional.php");
require_once(__DIR__."/../model/JuradoProfesionalMapper.php");

require_once(__DIR__."/../controller/BaseController.php");


class JuradoProfesionalController extends BaseController {
  
	private $juradoProfesionalMapper;    
  
	public function __construct() {    
		parent::__construct();
    
		$this->juradoProfesionalMapper = new JuradoProfesionalMapper();
	}

	public function index() {
		$jurado = $this->juradoProfesionalMapper->findAll(); 
		$this->view->setVariable("jurado", $jurado);    
		$this->view->render("juradoprofesional", "index");
	}
	
	public function add() {
		//echo isset($_POST["email"])?"a":"b";
		
		if(isset($_POST["email"])) {
			$email = $_POST["email"];
			$pwd = $_POST["pwd"];
			$tel = $_POST["tel"];
			$avatar = $_POST["avatar"];
			$exp = $_POST["exp"];
			
			$jp = new JuradoProfesional($email, $pwd, "", $tel, $avatar, $exp);
			$this->juradoProfesionalMapper->resgitrarJuradoProfesional($jp);
			
			$this->view->redirect("juradoprofesional", "index");
		}
		
		$this->view->render("juradoprofesional", "add");
	}
	
	public function edit() {
		
		if(isset($_POST["email"])) {
			
			$jp = new JuradoProfesional($_POST["email"]);
			$this->juradoProfesionalMapper->fill($jp);
			
			if(isset($_POST["pwd"])) $jp->setPassword($_POST["pwd"]);
			if(isset($_POST["tel"])) $jp->setTelefono($_POST["tel"]);
			if(isset($_POST["avatar"])) $jp->setFotoUsuario($_POST["avatar"]);
			if(isset($_POST["exp"])) $jp->setExperiencia($_POST["exp"]);
			
			$this->juradoProfesionalMapper->modificarJuradoProfesional($_POST["email"], $jp);
 
			$this->view->redirect("juradoprofesional", "index");
		} elseif(!isset($_GET["id"])) {
			$this->view->redirect("juradoprofesional", "index");
		} else {
			$jp = new JuradoProfesional($_GET["id"]);
			$this->juradoProfesionalMapper->fill($jp);
			
			$this->view->setVariable("miembro", $jp);
			
			$this->view->render("juradoprofesional", "edit");
		}

	}
}
