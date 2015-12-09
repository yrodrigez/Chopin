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
        if($up->save($establecimiento) == false) {
            return false;
        }
        $stmt= $this->db->prepare(
            "INSERT INTO establecimiento(direccion, coordenadas, email, nombre, horario) VALUES (?,?,?,?,?)"
        );
        return $stmt->execute(
            array(
                $establecimiento->getDireccion(),
                $establecimiento->getCoordenadas(),
                $establecimiento->getEmail(),
                $establecimiento->getNombre(),
                $establecimiento->getHorario()
            )
        );
    }

    /**
     * @param $email
     * @param $establecimiento Establecimiento
     * @return bool
     */
    public function modificarEstablecimiento(
        $email,
        $establecimiento
    ) {
        $up= new UsuarioMapper();
        $up->edit($email, $establecimiento);

        $stmt= $this->db->prepare(
          "UPDATE usuario, establecimiento
           SET establecimiento.direccion = ?,
           establecimiento.coordenadas = ?,
           usuario.telefono= ?,
           usuario.fotoperfil= ?,
           usuario.password=?,
           establecimiento.nombre=?,
           establecimiento.horario=?
           WHERE usuario.email= establecimiento.email AND establecimiento.email =?"
        );

        return $stmt->execute(array(
            $establecimiento->getDireccion(),
            $establecimiento->getCoordenadas(),
            $establecimiento->getTelefono(),
            $establecimiento->getFotoUsuario(),
            $establecimiento->getPassword(),
            $establecimiento->getNombre(),
            $establecimiento->getHorario(),
            $email
            )
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
            return $up->remove($establecimiento);
        }
        else
        {
            return false;
        }
    }

    public function fill($email){
        $stmt = $this->db->prepare(
            "SELECT * FROM usuario, establecimiento
              where establecimiento.email = usuario.email
              and establecimiento.email=?"
        );
        if($stmt->execute(array($email))){
            $row= $stmt->fetch(PDO::FETCH_ASSOC);

            return (new Establecimiento(
                $row["email"],
                $row["password"],
                "",
                Usuario::ESTABLECIMIENTO,
                $row["telefono"],
                $row["fotoperfil"],
                $row["coordenadas"],
                $row["direccion"],
                $row["nombre"],
                $row["horario"]));
        }else{
            return false;
        }
    }

    /**
     *
     * lista todos los establecmientos en la base de datos
     *
     * @return bool | Establecimiento array
     */
    public function listarEstablecimientos(){
        $stmt = $this->db->prepare(
            "SELECT usuario.email FROM usuario, establecimiento where establecimiento.email = usuario.email"
        );
        if($stmt->execute()){
            $establecimientos= array();
            foreach($stmt as $row){
                array_push($establecimientos, $this->fill($row["email"]));
            }
            return $establecimientos;
        }else{
            return false;
        }

    }

}