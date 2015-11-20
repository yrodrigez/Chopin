<?php
// file: model/ConcursoMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/Concurso.php");


class ConcursoMapper {

  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
  
  public function add(Concurso $concurso) {
    $stmt = $this->db->prepare("INSERT INTO concurso(nombre, descripcion, localizacion, fecha) values (?,?,?,?)");
    $stmt->execute(array($concurso->getNombre(), $concurso->getDescripcion(), $concurso->getLocalizacion(), $concurso->getFecha()));    
  }
  
  public function getInfo() {
	 $stmt = $this->db->query("SELECT * FROM concurso");
	 $concurso = $stmt->fetch(PDO::FETCH_ASSOC);
	
	 if($concurso != null) {
		return new Concurso($concurso["nombre"], $concurso["descripcion"], $concurso["localizacion"], $concurso["fecha"]);
	 } else {
		return NULL;
	 }
  }

  public function existeConcurso() {
    $stmt = $this->db->prepare("SELECT * FROM concurso");
    $stmt->execute();
    if($stmt->rowCount()>0)
      return true;
    else
      return false;   
  }

}
