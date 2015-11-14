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
                        tipo = ?
                        WHERE email= ?"
        );

        return $stmt->execute(array(
            $usuario->getEmail(),
            $usuario->getPassword(),
            $usuario->getFotoUsuario(),
            $usuario->getTelefono(),
            $usuario->getTipo(),
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
                "INSERT INTO usuario(email, password, fotoperfil, telefono, tipo) VALUES (?,?,?,?,?)"
            );

            return $stmt->execute(array(
                $usuario->getEmail(),
                $usuario->getPassword(),
                $usuario->getFotoUsuario(),
                $usuario->getTelefono(),
                $usuario->getTipo()
            ));
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $email
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
        if($stmt->fetchColumn() > 0){
            return true;
        }
        return false;
    }

    /**
     * @param $usuario
     * @return bool
     */
    public function remove (
        $usuario
    ) {
        if(self::exists($usuario)) {
            $stmt = $this->db->prepare(
                "DELETE FROM usuario WHERE email= ?"
            );
            return $stmt->execute(array(
                $usuario->getEmail()
            ));
        }else{
            return false;
        }
    }

}
