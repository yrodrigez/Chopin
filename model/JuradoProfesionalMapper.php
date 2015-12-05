<?php

/**
 * @author Yago Rodríguez
 * Date: 11/11/2015
 * Time: 14:15
 */
require_once("JuradoProfesional.php");
require_once("UsuarioMapper.php");

class JuradoProfesionalMapper
{
    private $db;

    /**
     * JuradoProfesionalMaper constructor.
     */
    public function  __construct()
    {
        $this->db= PDOConnection::getInstance();
    }

    public function existeJuradoProfesional($juradoProfesional){
        $stmt= $this->db->prepare(
            "SELECT count(email) from establecimiento where email=?"
        );
        $stmt->execute(array($juradoProfesional->getEmail()));
        return $stmt->rowCount() > 0;
    }

    /**
     * @param $email
     * @param $password
     * @param $nombre
     * @param $tipo
     * @param $telefono
     * @param $fotoUsuario
     * @param $experiencia
     * @return bool
     * retorna false si al momento de insertar el usuario se produce un error
     * o si al momento de insertar el juradoprofesional se produce un error
     */

    public function resgitrarJuradoProfesional(
        $juradoProfesional
    ) {
        $up= new UsuarioMapper();
        if($up->save($juradoProfesional) == false){
            return false;
        }
        $stmt= $this->db->prepare(
            "INSERT INTO juradoprofesional(experiencia, email) values (?,?)"
        );
        $stmt->execute(array(
            $juradoProfesional->getExperiencia(),
            $juradoProfesional->getEmail()
        ));
        return $stmt;
    }

    /**
     * @param $email
     * @param $juradoProfesional
     * @return bool
     * Modifica el usuario correspondiente al email
     * que se pasa por parámetro con los datos del
     * nuevo juradoProfesional que se pasa por parámetro
     */
    public function modificarJuradoProfesional(
        $email,
        $juradoProfesional
    ) {

        $stmt = $this->db->prepare(
            "UPDATE juradoProfesional SET experiencia = ? WHERE email= ?"
        );
        $stmt->execute(array(
            $juradoProfesional->getExperiencia(),
            $email
        ));

        $up= new UsuarioMapper();
        return $up->edit(
            $email,
            $juradoProfesional
        );
    }

    /**
     * @param $juradoProfesional
     * @return bool
     */
    public function borrarJuradoProfesional(
        $juradoProfesional
    ) {
        if(self::existeJuradoProfesional($juradoProfesional)) {
            $stmt = $this->db->prepare(
                "DELETE FROM juradoprofesional WHERE email= ?"
            );
            if (!($stmt->execute(array($juradoProfesional->getEmail())))
            )
                return false;
        }
        $up= new UsuarioMapper();
        return $up->remove($juradoProfesional);
    }

	public function findAll() {   
		$stmt = $this->db->query("SELECT * FROM juradoprofesional, usuario WHERE juradoprofesional.email=usuario.email");    
		$jp_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
	   
		$jurado = array();
		
		foreach ($jp_db as $jp) {
			array_push($jurado, new JuradoProfesional($jp["email"], $jp["password"], "", $jp["telefono"], $jp["fotoperfil"], ""));
		}

		return $jurado;
    }

    public function getNumeroJurado(){
        $stmt = $this->db->query("SELECT count(*) FROM juradoprofesional;");
        if($stmt->execute()){
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $res["count(*)"];
        } else {
            return -1;
        }
    }
  
    public function fill($jurado) {
		(new UsuarioMapper())->fill($jurado);
		$stmt = $this->db->prepare(
			"SELECT * FROM juradoprofesional WHERE email= ?"
		);
		$stmt->execute(array($jurado->getEmail()));
		$fillData = $stmt->fetch(PDO::FETCH_ASSOC);
		if($fillData != null) {
			$jurado->setExperiencia($fillData["experiencia"]);
		}
	}
}