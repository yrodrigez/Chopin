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
  private $fechaInicio;
  private $fechaFinalistas;
  private $fechaFin;
  private $imagen;
  private $coordenadas;
  
  
  public function __construct($nombre=NULL, $descripcion=NULL, $localizacion=NULL, $fechaInicio=NULL, $imagen=NULL, $coordenadas = NULL, $fechaFinalistas=NULL, $fechaFin=NULL) {
    $this->nombre = $nombre;
	$this->descripcion = $descripcion;
    $this->localizacion = $localizacion;
    $this->fechaInicio = $fechaInicio;
    $this->fechaFinalistas = $fechaFinalistas;
    $this->fechaFin = $fechaFin;
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
  
  public function getFechaInicio() {
    return $this->fechaInicio;
  }

  public function setFechaInicio($fecha) {
    $this->fechaInicio = $fecha;
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

  public function getFechaFinalistas()
  {
    return $this->fechaFinalistas;
  }

  public function setFechaFinalistas($fechaFinalistas)
  {
    $this->fechaFinalistas = $fechaFinalistas;
  }

  public function getFechaFin()
  {
    return $this->fechaFin;
  }

  public function setFechaFin($fechaFin)
  {
    $this->fechaFin = $fechaFin;
  }

  public function isStarted() {
    return strtotime($this->getFechaInicio()) <= strtotime(date("Y-m-d",time()));
  }

  public function isStarted2Iter() {
    return strtotime($this->getFechaFinalistas()) <= strtotime(date("Y-m-d",time()));
  }

  public function isFinished() {
    return strtotime($this->getFechaFin()) <= strtotime(date("Y-m-d",time()));
  }

}
