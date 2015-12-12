<?php
/**
 * @author Yago Rodríguez
 * Date: 11/11/2015
 * Time: 10:40
 */

include_once("Usuario.php");
class Establecimiento extends Usuario {

    private $coordenadas;
    private $direccion;
    private $nombre;
    private $horario;

    public function __construct(
        $email,
        $password=NULL,
        $tipo=NULL,
        $telefono=NULL,
        $fotoUsuario=NULL,
        $coordenadas=NULL,
        $direccion=NULL,
        $nombre=NULL,
        $horario=NULL
    ) {
        parent::__construct(
            $email,
            $password,
            $tipo,
            $telefono,
            $fotoUsuario,
            ""
        );
        $this->setCoordenadas($coordenadas);
        $this->setDireccion($direccion);
        $this->setNombre($nombre);
        $this->setHorario($horario);
    }

    public function getCoordenadas()
    {
        return $this->coordenadas;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setCoordenadas($coordenadas)
    {
        $this->coordenadas = $coordenadas;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getHorario()
    {
        return $this->horario;
    }

    public function setHorario($horario)
    {
        $this->horario = $horario;
    }


}