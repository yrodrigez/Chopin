<?php
	private $usuario;
	private $idPropuesta;

	public function __construct($idCodigo, $idPropuesta, $email=NULL, $utilizado=NULL, $elegido=NULL, $fechaVotacion=NULL) {
	        $this->setIdCodigo($idCodigo);
	        $this->setIdPropuesta($idPropuesta);
	}

	public function setIdCodigo(){
		return $this->$idCodigo;
	}

	public function getIdPropuesta(){
		return $this->$idPropuesta;
	}

	public function getIdCodigo(){
		$this->$idCodigo = $idCodigo;
	}

	public function setIdPropuesta(){
		$this->$idPropuesta = $idPropuesta;
	}

?>