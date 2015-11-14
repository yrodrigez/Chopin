<?php
/**
 * @author Yago Rodríguez
 * Date: 11/11/2015
 * Time: 10:40
 */


include_once("Usuario.php");

class JuradoProfesional extends Usuario {

    private $experiencia;

    public function __construct(
        $email,
        $password,
        $nombre,
        $tipo,
        $telefono,
        $fotoUsuario,
        $experiencia
    ) {
        parent::__construct(
            $email,
            $password,
            $nombre,
            $tipo,
            $telefono,
            $fotoUsuario
        );
        self::setExperiencia($experiencia);
    }

    public function getExperiencia()
    {
        return $this->experiencia;
    }

    public function setExperiencia($experiencia)
    {
        $this->experiencia = $experiencia;
    }

}