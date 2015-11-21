<?php

class Codigo{
    private $idCodigo;
    private $idPropuesta;
    private $email;
    private $utilizado;
    private $elegido;
    private $fechaVotacion;

    /**
     * Comentario constructor.
     * @param $idCodigo
     * @param $idPropuesta
     * @param $email
     * @param $utilizado
     * @param $elegido
     * @param $fechaVotacion
     */
    public function __construct($idCodigo=NULL, $idPropuesta=NULL, $email=NULL, $utilizado=NULL, $elegido=NULL, $fechaVotacion=NULL)
    {
        $this->idCodigo = $idCodigo;
        $this->idPropuesta = $idPropuesta;
        $this->email = $email;
        $this->utilizado = $utilizado;
        $this->elegido = $elegido;
        $this->fechaVotacion = $fechaVotacion;
    }

    /**
     * @return mixed
     */
    public function getIdCodigo()
    {
        return $this->idCodigo;
    }

    /**
     * @param mixed $idCodigo
     */
    public function setIdCodigo($idCodigo)
    {
        $this->idCodigo = $idCodigo;
    }

    /**
     * @return mixed
     */
    public function getIdPropuesta()
    {
        return $this->idPropuesta;
    }

    /**
     * @param mixed $idPropuesta
     */
    public function setIdPropuesta($idPropuesta)
    {
        $this->idPropuesta = $idPropuesta;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getUtilizado()
    {
        return $this->utilizado;
    }

    /**
     * @param mixed $utilizado
     */
    public function setUtilizado($utilizado)
    {
        $this->utilizado = $utilizado;
    }

    /**
     * @return mixed
     */
    public function getElegido()
    {
        return $this->elegido;
    }

    /**
     * @param mixed $elegido
     */
    public function setElegido($elegido)
    {
        $this->elegido = $elegido;
    }

    /**
     * @return mixed
     */
    public function getFechaVotacion()
    {
        return $this->fechaVotacion;
    }

    /**
     * @param mixed $fechaVotacion
     */
    public function setFechaVotacion($fechaVotacion)
    {
        $this->fechaVotacion = $fechaVotacion;
    }
}

?>