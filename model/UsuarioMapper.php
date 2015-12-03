<?php
/**
 * @author Yago Rodríguez
 * Date: 11/11/2015
 * Time: 10:42
 */

require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/Usuario.php");

class UsuarioMapper {

    private $db;

    /**
     * UsuarioMapper constructor.
     */
    public function  __construct()
    {
        $this->db= PDOConnection::getInstance();
    }

    /**
     * @param $email
     * @param $usuario
     * @return bool
     */
    public function edit (
        $email,
        $usuario
    ) {
        $stmt= $this->db->prepare(
            "UPDATE usuario SET
                        password = ?,
                        fotoperfil = ?,
                        telefono = ?,
                        preferencias = ?
                        WHERE email= ?;"
        );

        return $stmt->execute(array(
            $usuario->getPassword(),
            $usuario->getFotoUsuario(),
            $usuario->getTelefono(),
            $usuario->getPreferencias(),
            $email
        ));
    }

    /**
     * @param $usuario
     * @return mixed
     */
    public function save (
        $usuario
    ) {
        if($this->exists($usuario) == false) {
            $stmt = $this->db->prepare(
                "INSERT INTO usuario(email, password, fotoperfil, telefono, tipo, preferencias) VALUES (?,?,?,?,?,?)"
            );

            return $stmt->execute(array(
                $usuario->getEmail(),
                $usuario->getPassword(),
                $usuario->getFotoUsuario(),
                $usuario->getTelefono(),
                $usuario->getTipo(),
                $usuario->getPreferencias()
            ));
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $usuario
     * @return bool
     */
    public function exists ($usuario) {
        $stmt= $this->db->prepare("SELECT (email) from usuario where email= ?");
        $stmt->execute(array($usuario->getEmail()));
        return $stmt->rowCount() > 0;
    }

    /**
     * @param $email
     * @param $password
     * @return bool
     */
    public function isValid (
        $usuario
    ) {
        $stmt= $this->db->prepare(
            "SELECT count(email) FROM usuario where email=? and password=?"
        );
        $stmt->execute(array($usuario->getEmail(), $usuario->getPassword()));
        return $stmt->fetchColumn() > 0;
    }

    /**
     * @param $usuario
     * @return bool
     */
    public function remove (
        $usuario
    ) {
        if($this->exists($usuario)) {
            $stmt = $this->db->prepare("DELETE FROM usuario WHERE email= ?;");
            return $stmt->execute(array($usuario->getEmail()));
        }else{
            return false;
        }
    }
	
	public function fill(
        $usuario
    ) {
		$stmt= $this->db->prepare(
            "SELECT * FROM usuario where email=?"
        );
        $stmt->execute(array($usuario->getEmail()));
		$fillData = $stmt->fetch(PDO::FETCH_ASSOC);
		
        if($fillData != null) {
			$usuario->setFotoUsuario($fillData["fotoperfil"]);
			$usuario->setPassword($fillData["password"]);
			$usuario->setTelefono($fillData["telefono"]);
			$usuario->setTipo($fillData["tipo"]);
            $usuario->setPreferencias($fillData["preferencias"]);
        }
        /*switch ($usuario->getTipo()) {
            case JURADO_PROFESIONAL:
                $stmt = $this->db->prepare(
                    "SELECT * FROM juradoprofesional WHERE email= ?"
                );
                $stmt->execute(array($usuario->getEmail()));
                $fillData = $stmt->fetch(PDO::FETCH_ASSOC);
                if($fillData != null) {
                    $usuario->setExperiencia(
                        $fillData["experiencia"]
                    );
                }
                break;
            case ESTABLECIMIENTO:
                $stmt = $this->db->prepare(
                    "SELECT * FROM establecimiento WHERE email= ?"
                );
                $stmt->execute(array($usuario->getEmail()));
                $fillData = $stmt->fetch(PDO::FETCH_ASSOC);
                if($fillData != null) {
                    $usuario->setDireccion(
                        $fillData["direccion"]
                    );
                    $usuario->setCoordenadas(
                        $fillData["coordenadas"]
                    );
                }
                break;
            default:
                break;
        }*/
	}

    /**
     *
     * Lista todos los jurados popular de la BD
     *
     * @return Array of Jpops, else NULL
     */
    public function listarJuradoPopular(){
        $stmt = $this->db->prepare(
            "SELECT * FROM usuario where tipo = 1;"
        );
        if($stmt->execute()){
            $jpops= array();
            foreach($stmt as $row){
                array_push($jpops, new Usuario($row["email"],
                                               $row["password"],
                                               $row["tipo"],
                                               $row["telefono"],
                                               $row["fotoperfil"],
                                               $row["preferencias"]));
            }
            return $jpops;
        }else{
            return NULL;
        }

    }

}
