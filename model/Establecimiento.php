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

    public function __construct(
        $email,
        $password=NULL,
        $nombre=NULL,
        $tipo=NULL,
        $telefono=NULL,
        $fotoUsuario=NULL,
        $coordenadas=NULL,
        $direccion=NULL
    ) {
        parent::__construct(
            $email,
            $password,
            $tipo,
            $telefono,
            $fotoUsuario,
            ""
        );
        self::setCoordenadas($coordenadas);
        self::setDireccion($direccion);
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


}