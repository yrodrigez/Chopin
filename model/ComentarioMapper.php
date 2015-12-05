<?php
require_once(__DIR__."/Comentario.php");
require_once(__DIR__."/UsuarioMapper.php");
require_once(__DIR__."/Usuario.php");
require_once(__DIR__."/../core/PDOConnection.php");


class ComentarioMapper {

	private $db; 

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}


	public function save($comentario) {
		$stmt = $this->db->prepare("INSERT INTO comentario(email,contenido,fecha,idpincho) values (?,?,?,?)");
		$stmt->execute(array($comentario->getEmail(),nl2br($comentario->getContenido()),$comentario->getFecha(), $comentario->getIdPincho()));
	}

	public function getById($id) {
		$stmt = $this->db->prepare("SELECT * FROM comentario WHERE idpincho=?");
		$stmt->execute(array($id));

		$com_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$comments = array();

		foreach ($com_db as $com) {
			$us = new Usuario($com["email"]);
			(new UsuarioMapper())->fill($us);
			$comments += array($com["idcomentario"]."-".$us->getFotoUsuario() => new Comentario($com["email"], $com["contenido"], $com["fecha"], $com["idpincho"]));
		}

		return $comments;
	}

	/*public function modify($comentario){
		$stmt = $this->db->prepare("UPDATE comentario SET contenido=? WHERE idcomentario = ?");
		$stmt->execute(array($comentario->getContenido(),$comentario->getId()));
	}

	public function delete($comentario){
		$stmt = $this->db->prepare("DELETE FROM comentario WHERE idcomentario = ?");
		$stmt->execute(array($comentario->getId()));
	}*/

}
?>
