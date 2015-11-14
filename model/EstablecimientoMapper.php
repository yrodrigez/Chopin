<?php

/**
 * @author Yago Rodríguez
 * Date: 11/11/2015
 * Time: 13:44
 */
include_once("Establecimiento.php");
include_once("UsuarioMapper.php");
class EstablecimientoMapper
{

    private $db;

    /**
     * EstablecimientoMapper constructor.
     */
    public function  __construct()
    {
        $this->db= PDOConnection::getInstance();
    }

    /**
     * @param $email
     * @return bool
     */
    public function existeEstablecimiento(
        $establecimiento
    ) {
        $stmt= $this->db->prepare(
                "SELECT count(email) from establecimiento where email=?"
            );
        $stmt->execute(array($establecimiento->getEmail()));
        if($stmt->rowCount() > 0){
            return true;
        }
        return false;
    }

    /**
     * @param $establecimiento
     * @return bool
     */
    public function registrarEstablecimiento(
        $establecimiento
    ) {
        $up= new UsuarioMapper();
        if($up->registrarUsuario($establecimiento) == false) {
            return false;
        }
        $stmt= $this->db->prepare(
            "INSERT INTO establecimiento(direccion, coordenadas, email) VALUES (?,?,?)"
        );
        return $stmt->execute(
            array(
                $establecimiento->getDireccion(),
                $establecimiento->getCoordenadas(),
                $establecimiento->getEmail()
            )
        );
    }

    /**
     * @param $email
     * @param $establecimiento
     * @return bool
     */
    public function modificarEstablecimiento(
        $email,
        $establecimiento
    ) {
        $up= new UsuarioMapper();
        $up->modificarUsuario($email, $establecimiento);
        $stmt= $this->db->prepare(
          "UPDATE establecimiento SET direccion = ?, coordenadas = ?, email = ? WHERE email= ?"
        );
        return $stmt->execute(
            $establecimiento->getDireccion(),
            $establecimiento->getCoordenadas(),
            $establecimiento->getEmail(),
            $email
        );
    }

    /**
     * @param $establecimiento
     * @return bool
     */
    public function borrarEstablecimiento(
        $establecimiento
    ) {
        if(self::existeEstablecimiento($establecimiento)) {
            $stmt = $this->db->prepare(
                "DELETE FROM establecimiento WHERE email= ?"
            );
            if (
                !$stmt->execute(array($establecimiento->getEmail()))
            ) {
                return false;
            }
            $up = new UsuarioMapper();
            return $up->borrarUsuario($establecimiento);
        }
        else
        {
            return false;
        }
    }
}