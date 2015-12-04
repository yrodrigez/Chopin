<?php

require_once(__DIR__."/../core/ViewManager.php");

require_once(__DIR__."/../model/Usuario.php");
require_once(__DIR__."/../model/UsuarioMapper.php");

require_once(__DIR__."/../model/Concurso.php");
require_once(__DIR__."/../model/ConcursoMapper.php");

require_once(__DIR__."/../model/Establecimiento.php");
require_once(__DIR__."/../model/EstablecimientoMapper.php");

require_once(__DIR__."/../controller/BaseController.php");


class UsuariosController extends BaseController {
  
	private $userMapper;    
  
	public function __construct() {    
		parent::__construct();

		$this->userMapper = new UsuarioMapper();
		$this->estabMapper = new EstablecimientoMapper();
	}

	public function login() {
		if (isset($_POST["username"])){ 
			$user = new Usuario($_POST["username"], $_POST["passwd"]);
			
			if ($this->userMapper->isValid($user)) {
				$_SESSION["user"]=$_POST["username"];
				$this->userMapper->fill($user);
				$_SESSION["type"]=$user->getTipo();
				$this->view->redirect("concurso", "view");
			} else {
				$msg = array();
                array_push($msg, array("error", "Datos de sesión inválidos"));
				$this->view->setFlash($msg);
			}
		}       
    
		$this->view->render("usuarios", "login");
	}


	public function register() {

		$user=NULL;
    
		if (isset($_POST["username"])){ 


			$concurso = (new ConcursoMapper())->getInfo();

			if($concurso->isStarted()) {
				$user = new Usuario($_POST["username"], $_POST["passwd"]);

				try{
					$user->isValidForRegister(); // if it fails, ValidationException

					if (!$this->userMapper->exists($user)) {

						if($_POST["tel"]) $user->setTelefono($_POST["tel"]);
						if($_POST["prefs"]) $user->setPreferencias($_POST["prefs"]);
						if($_FILES['avatar'] and $_FILES['avatar']['name']) {
							$name = $_POST["username"] . "." . substr(strrchr($_FILES['avatar']['name'], '.'), 1);
							$path = "img/usuarios/" . $name;
							move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
							$user->setFotoUsuario($name);
						} else {
							$user->setFotoUsuario("default.png");
						}

						$user->setTipo(1);
						$this->userMapper->save($user);

                        $msg = array();
                        array_push($msg, array("success", "El jurado popular se ha creado correctamente"));
                        $this->view->setFlash($msg);
						$this->view->redirect("usuarios", "login");
					} else {
                        $msg = array();
                        array_push($msg, array("error", "El usuario ya existe"));
                        $this->view->setFlash($msg);
					}
				} catch(ValidationException $ex) {
					$errors = $ex->getErrors();
                    $this->view->setFlash($errors);
				}
			} else {
				$user = new Establecimiento($_POST["username"], $_POST["passwd"]);

				try{
					$user->isValidForRegister(); // if it fails, ValidationException

					if (!$this->userMapper->exists($user)) {

						if($_POST["tel"]) $user->setTelefono($_POST["tel"]);
						if($_POST["prefs"]) $user->setPreferencias($_POST["prefs"]);
						if($_FILES['avatar'] and $_FILES['avatar']['name']) {
							$name = $_POST["username"] . "." . substr(strrchr($_FILES['avatar']['name'], '.'), 1);
							$path = "img/usuarios/" . $name;
							move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
							$user->setFotoUsuario($name);
						} else {
							$user->setFotoUsuario("default.png");
						}

						if($_POST["dir"]) $user->setDireccion($_POST["dir"]);
						if($_POST["cord"]) $user->setCoordenadas($_POST["cord"]);

						$user->setTipo(3);
						$this->estabMapper->registrarEstablecimiento($user);

						$msg = array();
                        array_push($msg, array("success", "El establecimiento se ha creado correctamente"));
                        $this->view->setFlash($msg);
						$this->view->redirect("usuarios", "login");
					} else {
                        $msg = array();
                        array_push($msg, array("error", "El usuario ya existe"));
                        $this->view->setFlash($msg);
					}
				} catch(ValidationException $ex) {
                    $errors = $ex->getErrors();
                    $this->view->setFlash($errors);
				}
			}

		}

		$this->view->setVariable("user", $user);
		$this->view->render("usuarios", "register");
	}

	public function index(){
        $this->view->setVariable("jpops", $this->userMapper->listarJuradoPopular());
        $this->view->render("usuarios","index");
    }

	public function modificar() {
		if(isset($_SESSION["user"]) && $_SESSION["type"] == Usuario::JURADO_POPULAR || $_SESSION["type"] == Usuario::ORGANIZADOR){
			if(isset($_POST["email"])) {
			
				$jpop = new Usuario($_POST["email"]);
				$this->userMapper->fill($jpop);

				if($_POST["telefono"]) $jpop->setTelefono($_POST["telefono"]);
				if($_POST["preferencias"]) $jpop->setPreferencias($_POST["preferencias"]);
				if($_POST["password"]) $jpop->setPassword($_POST["password"]);

				if($_FILES['avatar'] and $_FILES['avatar']['name']) {
					$name =  $_POST["email"] . "." . substr(strrchr($_FILES['avatar']['name'], '.'), 1);
					$path = "img/usuarios/" . $name;
					move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
					$jpop->setFotoUsuario($name);
				}
				$this->userMapper->edit($_POST["email"], $jpop);
	 			$msg = array();
		       	array_push($msg, array("success", "Usuario modificado correctamente"));
		        $this->view->setFlash($msg);
				$this->view->redirect("concurso", "view");
			} else {
				$jpop = new Usuario($_GET["id"]);
				$this->userMapper->fill($jpop);
				$this->view->setVariable("jpop", $jpop);
				$this->view->render("usuarios", "modificar");
			}
		} else {
			$msg = array();
		    array_push($msg, array("error", "Debe estar logueado para modificar su Usuario"));
		    $this->view->setFlash($msg);
		    $this->view->redirect("usuarios", "login");
		}


	}

	public function view(){
	    if(isset($_GET['id'])){
	      $usuario = new Usuario($_GET["id"]);
	      $this->userMapper->fill($usuario);
	      $this->view->setVariable('usuario',$usuario);
	      $this->view->render('usuarios','view');
	    } /*else {
	        if(isset($_SESSION["user"]) && ($_SESSION["type"] == Usuario::ESTABLECIMIENTO)){
	          if ($this->pinchoMapper->existePincho($_SESSION["user"])) {
	           $pincho = $this->pinchoMapper->getPinchoEstablecimiento($_SESSION['user']);
	            $this->view->setVariable('pincho',$pincho);
	            $this->view->render('pinchos','view');
	          } else {
	            $this->view->redirect("pinchos","presentar");
	          }
	        } else {
	        $this->view->redirect("pinchos","listar");
	      	}
	    }*/
		$this->view->redirect('concurso','view');
    }
		
	public function eliminar(){
	    if(isset($_GET['id'])){
	      $usuario = new Usuario($_GET["id"]);
	      $this->userMapper->fill($usuario); //PUEDE SOBRAR
	      $this->userMapper->remove($usuario);
	      $msg = array();
		  array_push($msg, array("success", "El usuario ha sido eliminado exitosamente"));
		  $this->view->setFlash($msg);
	      $this->view->redirect("usuarios","index");
	    }/* else {
	      $msg = array();
		  array_push($msg, array("error", "Debe indicar el usuario que desea eliminar"));
		  $this->view->setFlash($msg);
	    } */
    }

	public function logout() {
		session_destroy();
		$this->view->redirect("concurso", "view");
	}
}
