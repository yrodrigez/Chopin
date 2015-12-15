<?php
/**
 * @author Yago Rodríguez
 * Date: 11/11/2015
 * Time: 10:40
 */


include_once("Usuario.php");

class JuradoProfesional extends Usuario {

    private $experiencia;
    private $nombre;

    public function __construct(
        $email,
        $password=NULL,
        $nombre=NULL,
        $telefono=NULL,
        $fotoUsuario=NULL,
        $experiencia=NULL,
        $nombre=NULL,
        $preferencias=NULL
    ) {
        parent::__construct(
            $email,
            $password,
            2,
            $telefono,
            $fotoUsuario,
            $preferencias
        );
        $this->setExperiencia($experiencia);
        $this->setNombre($nombre);
    }

    public function getExperiencia()
    {
        return $this->experiencia;
    }

    public function setExperiencia($experiencia)
    {
        $this->experiencia = $experiencia;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
}