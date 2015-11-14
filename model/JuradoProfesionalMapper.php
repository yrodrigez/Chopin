<?php

/**
 * @author Yago Rodríguez
 * Date: 11/11/2015
 * Time: 14:15
 */
include_once("JuradoProfesional.php");
include_once("UsuarioMapper.php");
class JuradoProfesionalMaper
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
        if($stmt->rowCount() > 0){
            return true;
        }
        return false;
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
        if($up->registrarUsuario($juradoProfesional) == false){
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
            "UPDATE juradoProfesional SET experiencia = ?, email = ? WHERE  email= ?"
        );
        $stmt->execute(array(
            $juradoProfesional->getExperiencia(),
            $juradoProfesional->getEmail(),
            $email
        ));

        $up= new UsuarioMapper();
        return $up->modificarUsuario(
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
            if (
            !($stmt->execute(array($juradoProfesional->getEmail())))
            )
                return false;
        }
        $up= new UsuarioMapper();
        return $up->borrarUsuario($juradoProfesional);
    }
}