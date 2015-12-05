<?php

require_once(__DIR__."/../controller/BaseController.php");
require_once(__DIR__."/../model/Comentario.php");
require_once(__DIR__."/../model/ComentarioMapper.php");


class ComentariosController extends BaseController{

    private $comentarioMapper;

    public function __construct()
    {
        parent::__construct();
        $this->comentarioMapper = new ComentarioMapper();
    }

    public function add() {

        if(isset($_SESSION["user"]) && isset($_POST["content"]) && isset($_POST["questionid"])) {
            $date = date("Y-m-d",time());
            $comentario = new Comentario($_SESSION["user"], $_POST["content"], $date, $_POST["questionid"]);

            $this->comentarioMapper->save($comentario);

            $this->view->setFlash(array(array("success", "Comentario añadido correctamente")));
            $this->view->redirect("pinchos", "view","id=".$_POST["questionid"]);
        } else {
            echo "no"; die();
            $this->view->redirect("concurso", "view");
        }

    }


}