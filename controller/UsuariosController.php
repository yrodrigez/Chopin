<?php

require_once(__DIR__."/../core/ViewManager.php");

require_once(__DIR__."/../model/Usuario.php");
require_once(__DIR__."/../model/UsuarioMapper.php");

require_once(__DIR__."/../controller/BaseController.php");


class UsuariosController extends BaseController {
  
	private $userMapper;    
  
	public function __construct() {    
		parent::__construct();
    
		$this->userMapper = new UsuarioMapper();
		$this->view->setLayout("welcome");     
	}

	public function login() {
		if (isset($_POST["username"])){ 
			$user = new Usuario($_POST["username"], $_POST["passwd"]);
			
			if ($this->userMapper->isValid($user)) {
				$_SESSION["user"]=$_POST["username"];
				//$this->userMapper->fill($user);
				//$_SESSION["type"]=$user->getTipo();
				$this->view->redirect("concurso", "view");
			}else{
				$errors = array();
				$errors["general"] = "Username is not valid";
				$this->view->setVariable("errors", $errors);
			}
		}       
    
		$this->view->render("usuarios", "login");    
	}


	public function register() {
    
		$user = new Usuario();
    
		if (isset($_POST["username"])){ 
			$user->setEmail($_POST["username"]);
			$user->setPassword($_POST["passwd"]);
			$user->setTipo(1); // TODO: comprobar si debe ser establecimiento o jurado popular según la fecha de inicio
			
			try{
				$user->isValidForRegister(); // if it fails, ValidationException
	
				if (!$this->userMapper->exists($user)) {
					$this->userMapper->save($user);
	  
					// message to show in the next view
					$this->view->setFlash("Usuario ".$user->getEmail()." añadido correctamente. Por favor, identifícate.");
				  
					$this->view->redirect("usuarios", "login");	  
				} else {
					$errors = array();
					$errors["username"] = "Username already exists";
					$this->view->setVariable("errors", $errors);
				}
			} catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}
    
		// Put the User object visible to the view
		$this->view->setVariable("user", $user);
		 
		$this->view->render("usuarios", "register");
	}
	
	public function logout() {
		session_destroy();
		$this->view->redirect("concurso", "view");
	}
}
