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
		
		if(isset($_POST["email"])) {
			$email = $_POST["email"];
			$pwd = $_POST["pwd"];
			$tel = ($_POST["tel"])?$_POST["tel"]:NULL;
			$exp = ($_POST["exp"])?$_POST["exp"]:NULL;

			if($_FILES['avatar'] and $_FILES['avatar']['name']) {
				$name = $_POST["username"] . "." . substr(strrchr($_FILES['avatar']['name'], '.'), 1);
				$path = "img/usuarios/" . $name;
				move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
				$avatar = $name;
			} else {
				$avatar="default.png";
			}
			
			$jp = new JuradoProfesional($email, $pwd, "", $tel, $avatar, $exp);
			$this->juradoProfesionalMapper->resgitrarJuradoProfesional($jp);
			
			$this->view->redirect("juradoprofesional", "index");
		}
		
		$this->view->render("juradoprofesional", "add");
	}

	//public function
	
	public function edit() {
		
		if(isset($_POST["email"])) {
			
			$jp = new JuradoProfesional($_POST["email"]);
			$this->juradoProfesionalMapper->fill($jp);

			if($_POST["pwd"]) $jp->setPassword($_POST["pwd"]);
			if($_POST["tel"]) $jp->setTelefono($_POST["tel"]);
			if($_POST["exp"]) $jp->setExperiencia($_POST["exp"]);

			if($_FILES['avatar'] and $_FILES['avatar']['name']) {
				$path = "img/usuarios/" . basename( $_FILES['avatar']['name']);
				move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
				$jp->setFotoUsuario(basename($_FILES['avatar']['name']));
			}
			
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
