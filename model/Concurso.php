<?php
// file: model/Comment.php

require_once(__DIR__."/../core/ValidationException.php");

/**
 * Class Comment
 * 
 * Represents a Comment in the blog. A Comment is attached
 * to a Post and was written by an specific User (author)
 * 
 * @author lipido <lipido@gmail.com>
 */
class Concurso {
	
  private $nombre;
  private $descripcion;
  private $localizacion;
  private $fecha;
  private $imagen;
  private $coordenadas;
  
  
  public function __construct($nombre=NULL, $descripcion=NULL, $localizacion=NULL, $fecha=NULL, $imagen=NULL, $coordenadas = NULL) {
    $this->nombre = $nombre;
	$this->descripcion = $descripcion;
    $this->localizacion = $localizacion;    
    $this->fecha = $fecha;
    $this->imagen = $imagen;
    $this->coordenadas = $coordenadas;
  }
  
  public function getNombre() {
    return $this->nombre;
  }

  public function setNombre($nombre) {
    $this->nombre = $nombre;
  }
  
  public function getDescripcion() {
    return $this->descripcion;
  }
  
  public function setDescripcion($descripcion) {
    return $this->descripcion;
  }

  public function getLocalizacion() {
    return $this->localizacion;
  }

  public function setLocalizacion($localizacion){
    $this->localizacion = $localizacion;
  }
  
  public function getFecha() {
    return $this->fecha;
  }

  public function setFecha($fecha) {
    $this->fecha = $fecha;
  }

  public function isStarted() {
	  return strtotime($this->getFecha()) <= strtotime(date("Y-m-d",time()));
  }

  public function getImagen()
  {
    return $this->imagen;
  }

  public function setImagen($imagen)
  {
    $this->imagen = $imagen;
  }

  public function getCoordenadas()
  {
    return $this->coordenadas;
  }

  public function setCoordenadas($coordenadas)
  {
    $this->coordenadas = $coordenadas;
  }

}
