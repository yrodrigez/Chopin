<?php

class Comentario{
	private $email;
	private $contenido;
	private $fecha;
	private $id;

	public function __construct($email, $contenido, $fecha, $id){
		$this->email = $email;
		$this->contenido = $contenido;
		$this->fecha = $fecha;
		$this->id = $id;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getContenido(){
		return $this->contenido;
	}

	public function getFecha(){
		return $this->fecha;
	}

	public function getId(){
		return $this->id;
	}

	public function setEmail($email){
		$this->email = $email;
	}  

	public function setContenido($contenido){
		$this->contenido = $contenido;
	}

	public function setFecha($fecha){
		$this->fecha = $fecha;
	}

	public function setId($id){
		$this->id = $id;
	}


}

?>