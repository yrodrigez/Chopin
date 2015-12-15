<?php

require_once(__DIR__."/../core/ViewManager.php");

require_once(__DIR__."/../model/Concurso.php");
require_once(__DIR__."/../model/ConcursoMapper.php");
require_once(__DIR__."/../model/PinchoMapper.php");

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
		$concurso = (new ConcursoMapper())->getInfo();
		$this->view->setVariable("jurado", $jurado);
		$this->view->setVariable("concurso", $concurso);
		$c = (new ConcursoMapper())->getInfo();
		if($c->isStarted() && !(new PinchoMapper())->asignadaIter(1) && !$c->isStarted2Iter()
				|| $c->isStarted2Iter() && !(new PinchoMapper())->asignadaIter(2) && !$c->isFinished())
			$this->view->setVariable("iter2asign", "1");
		$this->view->render("juradoprofesional", "index");
	}
	
	public function add() {
		
		if(isset($_POST["email"])) {
			$email = $_POST["email"];
			$pwd = $_POST["pwd"];
			$tel = ($_POST["tel"])?$_POST["tel"]:NULL;
			$exp = ($_POST["exp"])?$_POST["exp"]:NULL;
			$nombre = ($_POST["nombre"])?$_POST["nombre"]:NULL;

			if($_FILES['avatar'] and $_FILES['avatar']['name']) {
				$name = $_POST["email"] . "." . substr(strrchr($_FILES['avatar']['name'], '.'), 1);
				$path = "img/usuarios/" . $name;
				move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
				$avatar = $name;
			} else {
				$avatar="default.png";
			}
			
			$jp = new JuradoProfesional($email, $pwd, "", $tel, $avatar, $exp, $nombre);
			$this->juradoProfesionalMapper->resgitrarJuradoProfesional($jp);

			$msg = array();
			array_push($msg, array("success", "El miembro del jurado se ha añadido correctamente"));
			$this->view->setFlash($msg);
			
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
			if($_POST["nombre"]) $jp->setNombre($_POST["nombre"]);

			if($_FILES['avatar'] and $_FILES['avatar']['name']) {
				$name =  $_POST["email"] . "." . substr(strrchr($_FILES['avatar']['name'], '.'), 1);
				$path = "img/usuarios/" . $name;
				move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
				$jp->setFotoUsuario($name);
			}
			
			$this->juradoProfesionalMapper->modificarJuradoProfesional($_POST["email"], $jp);

			$msg = array();
			array_push($msg, array("success", "El miembro del jurado se ha modificado correctamente"));
			$this->view->setFlash($msg);
 
			$this->view->redirect("juradoprofesional", "index");
		} elseif(!isset($_GET["id"])) {
			$this->view->redirect("juradoprofesional", "index");
		} else {
			$jp = new JuradoProfesional($_GET["id"]);
			$this->juradoProfesionalMapper->fill($jp);

			$concurso = (new ConcursoMapper())->getInfo();

			$this->view->setVariable("miembro", $jp);
			$this->view->setVariable("concurso", $concurso);
			
			$this->view->render("juradoprofesional", "edit");
		}

	}

	public function delete() {
		if(isset($_GET["email"])) {
			$jp = new JuradoProfesional($_GET["email"]);
			$this->juradoProfesionalMapper->borrarJuradoProfesional($jp);

			$msg = array();
			array_push($msg, array("success", "El miembro del jurado se ha borrado correctamente"));
			$this->view->setFlash($msg);
		}

		$this->view->redirect("juradoprofesional", "index");
	}

	public function view() {
		if(isset($_GET['id'])){
			$usuario = new JuradoProfesional($_GET["id"]);

			$this->juradoProfesionalMapper->fill($usuario);

			$this->view->setVariable('usuario',$usuario);
			$this->view->render('juradoprofesional','view');
		} else {
			$this->view->redirect('concurso','view');
		}

	}
}
