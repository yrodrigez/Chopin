<?php
//file: /controller/CommentsController.php

session_start();
require_once(__DIR__ . "/../model/Concurso.php");
require_once(__DIR__ . "/../model/Usuario.php");



require_once(__DIR__ . "/../controller/BaseController.php");

/**
 * Class CommentsController
 *
 * Controller for comments related use cases.
 *
 */
class ConcursoController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }


    /*public function add()
    {
        require_once(__DIR__ . "/../model/ConcursoMapper.php");

        $this->concursomapper = new ConcursoMapper();

        if ((isset($_SESSION["user"])) && ($_SESSION["type"] == Usuario::ORGANIZADOR)) {
            if (!$this->concursomapper->existeConcurso()) {
                $this->view->render("concurso", "configurar");
            } else {
                $msg = array();
                if ($_POST["nombre"] == NULL || $_POST["localizacion"] == NULL || $_POST["fecha"] == NULL) {
                    array_push($msg, array("error", "Deben especificarse un nombre, una localización y una fecha"));
                }
                // TODO: Check if valid
                $concurso = new Concurso($_POST["nombre"], $_POST["descripcion"], $_POST["localizacion"], $_POST["fecha"]);
                $this->concursomapper->add($concurso);
                $this->view->setFlash($msg);
                $this->view->redirect("concurso", "view");
            }
        } else {
            array_push($msg, array("error", "Solo el organizador puede agregar un concurso"));
            $this->view->setFlash($msg);
            $this->view->redirect("concurso", "view");
        }
    }*/

    public function view()
    {
        require_once(__DIR__ . "/../model/ConcursoMapper.php");
        $concursomapper = new ConcursoMapper();

        if (!$concursomapper->existeConcurso()) {
            $this->view->render("concurso", "configurar");
        } else {
            $concurso = $concursomapper->getInfo();
            $this->view->setVariable("concurso", $concurso);
            $this->view->render("concurso", "view");
        }
    }

    public function configurar()
    {
        /*if ($this->concursomapper->existeConcurso()) {
            $this->view->render("concurso", "view");
        } else {*/

            if (isset($_POST["nombre"])) {
                if($this->importSQL("sql/db.sql", "127.0.0.1", "root", "")) {
                    require_once(__DIR__ . "/../model/ConcursoMapper.php");
                    require_once(__DIR__ . "/../model/UsuarioMapper.php");
                    $concursomapper = new ConcursoMapper();
                    $concurso = new Concurso($_POST["nombre"], $_POST["descripcion"], $_POST["localizacion"], $_POST["fecha"]);
                    $concursomapper->add($concurso);

                    $user = new Usuario($_POST["username"], $_POST["password"]);
                    $user->setTipo(0);
                    (new UsuarioMapper())->save($user);

                    $msg = array();
                    array_push($msg, array("success", "El concurso se ha creado correctamente"));
                    $this->view->setFlash($msg);
                    $this->view->redirect("concurso","view");
                } else {
                    $msg = array();
                    array_push($msg, array("error", "No se ha podido conectar a la base de datos. Compruebe los datos de acceso."));
                    $this->view->setFlash($msg);
                    $this->view->redirect("concurso","view");
                }


            }

            $this->view->setLayout("setup");
            $this->view->render("concurso", "configurar");
        //}
    }

    private function importSQL($sqlFile, $host, $user, $password)
    {
        $link = mysqli_connect($host, $user, $password);
        if (mysqli_connect_errno()) return false;

        $f = fopen($sqlFile, "r+");
        $sqlFile = fread($f, filesize($sqlFile));
        $sqlArray = explode(';', $sqlFile);
        foreach ($sqlArray as $stmt) {
            if (strlen($stmt) > 3 && substr(ltrim($stmt), 0, 2) != '/*') {
                $result = mysqli_query($link, $stmt);
                if (!$result) break;
            }
        }
        return true;
    }
}
