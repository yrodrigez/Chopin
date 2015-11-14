<?php
/**
 * @author Yago Rodríguez
 * Date: 11/11/2015
 * Time: 10:42
 */

require_once("../core/PDOConnection.php");
include_once("Usuario.php");
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
    public function modificarUsuario(
        $email,
        $usuario
    ) {
        $stmt= $this->db->prepare(
            "UPDATE usuario SET
                        contraseña = ?,
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
    public function registrarUsuario(
        $usuario
    ) {
        if($this->existeUsuario($usuario) == false) {
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
    public function existeUsuario(
        $usuario
    ) {
        $stmt= $this->db->prepare(
                "SELECT (email) from usuario where email= ?"
            );

        $stmt->execute(array($usuario->getEmail()));
        if($stmt->rowCount()>0){

            return true;
        }

        return false;
    }

    /**
     * @param $email
     * @param $password
     * @return bool
     */
    public function isUsuarioValido(
        $usuario
    ) {
        $stmt= $this->db->prepare(
            "SELECT count(email) FROM usuario where email=? and contraseña=?"
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
    public function borrarUsuario(
        $usuario
    ) {
        if(self::existeUsuario($usuario)) {
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
