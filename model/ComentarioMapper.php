<?php
require_once(__DIR__."/Comentario.php");
require_once(__DIR__."/PDOConnection.php");


class ComentarioMapper {

	private $db; 

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}


	public function save($comentario) {
		$stmt = $this->db->prepare("INSERT INTO comentario(email,contenido,fecha) values (?,?,?)");
		$stmt->execute(array($comentario->getEmail(),$comentario->getContenido(),$comentario->getFecha()));
		echo "Save ok";
	}

	public function modify($comentario){
		$stmt = $this->db->prepare("UPDATE comentario SET contenido=? WHERE idcomentario = ?");
		$stmt->execute(array($comentario->getContenido(),$comentario->getId()));
		echo "Update ok";
	}

	public function delete($comentario){
		$stmt = $this->db->prepare("DELETE FROM comentario WHERE idcomentario = ?");
		$stmt->execute(array($comentario->getId()));
		echo "Delete ok";
	}

}
?>
