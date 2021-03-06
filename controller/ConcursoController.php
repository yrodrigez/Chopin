<?php
//file: /controller/CommentsController.php

session_start();
require_once(__DIR__ . "/../model/Concurso.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/EstablecimientoMapper.php");
require_once(__DIR__ . "/../model/PinchoMapper.php");

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

    public function ganadores() {
        require_once(__DIR__ . "/../model/ConcursoMapper.php");
        $concursomapper = new ConcursoMapper();
        $mapper = new PinchoMapper();

        $finalistas = $mapper->getFinalistas(3);
        $concurso = $concursomapper->getInfo();

        $this->view->setVariable("finalistas", $finalistas);
        $this->view->setVariable("concurso", $concurso);

        if($concurso->isFinished()) {
            $ganadoresPop = $mapper->getGanadoresPopulares(3);
            $ganadoresProf = $mapper->getGanadoresProfesionales(3);

            $this->view->setVariable("ganadoresPo", $ganadoresPop);
            $this->view->setVariable("ganadoresPr", $ganadoresProf);
        }

        $this->view->render("concurso", "ganadores");
    }

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
        if (isset($_POST["nombre"])) {

            if ($this->importSQL("sql/db.sql", "127.0.0.1", $_POST["db_username"], $_POST["db_password"])) {

                require_once(__DIR__ . "/../model/ConcursoMapper.php");
                require_once(__DIR__ . "/../model/UsuarioMapper.php");

                if ($_FILES['imagenConcurso'] and $_FILES['imagenConcurso']['name']) {
                    $name = "concurso." . substr(strrchr($_FILES['imagenConcurso']['name'], '.'), 1);
                    $path = "img/" . $name;
                    move_uploaded_file($_FILES['imagenConcurso']['tmp_name'], $path);
                    $imgConcurso = $name;
                } else {
                    $imgConcurso = "default.png";
                }

                $concursomapper = new ConcursoMapper();
                $fechaInicio = implode("-", array_reverse(explode("/", $_POST["fechaInicio"])));
                $fechaFinalistas = implode("-", array_reverse(explode("/", $_POST["fechaFinalistas"])));
                $fechaFin = implode("-", array_reverse(explode("/", $_POST["fechaFin"])));
                $concurso = new Concurso($_POST["nombre"], $_POST["descripcion"], $_POST["localizacion"], $fechaInicio, $imgConcurso, $_POST["cord"], $fechaFinalistas, $fechaFin);
                $concursomapper->add($concurso);


                if ($_FILES['imagenOrganizador'] and $_FILES['imagenOrganizador']['name']) {
                    $name = $_POST["username"] . "." . substr(strrchr($_FILES['imagenOrganizador']['name'], '.'), 1);
                    $path = "img/usuarios/" . $name;
                    move_uploaded_file($_FILES['imagenOrganizador']['tmp_name'], $path);
                    $imgOrganizador = $name;
                } else {
                    $imgOrganizador = "default.png";
                }

                $user = new Usuario($_POST["username"], $_POST["password"]);
                $user->setTipo(0);
                $user->setFotoUsuario($imgOrganizador);
                (new UsuarioMapper())->save($user);

                if (isset($_POST["sampleData"]))
                    $this->importSQL("sql/data.sql", "127.0.0.1", $_POST["db_username"], $_POST["db_password"]);


                $msg = array();
                array_push($msg, array("success", "El concurso se ha creado correctamente"));
                $this->view->setFlash($msg);
                $this->view->redirect("concurso", "view");
            } else {
                $msg = array();
                array_push($msg, array("error", "No se ha podido conectar a la base de datos. Compruebe los datos de acceso."));
                $this->view->setFlash($msg);
                $this->view->redirect("concurso", "view");
            }


        }

        $this->view->setLayout("setup");
        $this->view->render("concurso", "configurar");
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

    public function gastromapa()
    {
        require_once(__DIR__ . "/../model/ConcursoMapper.php");
        $concurso = (new ConcursoMapper())->getInfo();
        $establecimientos = (new EstablecimientoMapper())->listarEstablecimientos();
        $this->view->setVariable("establecimientos", $establecimientos);
        $this->view->setVariable("concurso", $concurso);
        $this->view->render("concurso", "gastromapa");
    }

}
