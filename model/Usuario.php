<?php
/**
 * @author Yago Rodríguez
 * Date: 11/11/2015
 * Time: 10:40
 * Usuario será tanto Organizador
 * como jurado popular
 *
 */

class Usuario {
    private $email;
    private $password;
    private $nombre;
    private $tipo;
    private $telefono;
    private $fotoUsuario;

    public function __construct(
        $email,
        $password,
        $nombre,
        $tipo,
        $telefono,
        $fotoUsuario
    ) {
        self::setEmail($email);
        self::setFotoUsuario($fotoUsuario);
        self::setNombre($nombre);
        self::setPassword($password);
        self::setTelefono($telefono);
        self::setTipo($tipo);
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFotoUsuario()
    {
        return $this->fotoUsuario;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setFotoUsuario($fotoUsuario)
    {
        $this->fotoUsuario = $fotoUsuario;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

}