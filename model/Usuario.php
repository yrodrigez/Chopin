<?php

class Usuario {
    const ORGANIZADOR = 0;
    const JURADO_POPULAR = 1;
    const JURADO_PROFESIONAL = 2;
    const ESTABLECIMIENTO = 3;

    private $email;
    private $password;
    private $nombre;
    private $tipo;
    private $telefono;
    private $fotoUsuario;
	
    public function __construct(
        $email=NULL,
        $password=NULL,
        $nombre=NULL,
        $tipo=NULL,
        $telefono=NULL,
        $fotoUsuario=NULL
    ) {
        $this->setEmail($email);
        $this->setFotoUsuario($fotoUsuario);
        $this->setNombre($nombre);
        $this->setPassword($password);
        $this->setTelefono($telefono);
        $this->setTipo($tipo);
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

	public function isValidForRegister() {
		$errors = array();
		
		if (strlen($this->email) < 5) {
			$errors["username"] = "El usuario debe tener al menos cinco caracteres.";
		}
      
		if (strlen($this->password) < 5) {  // TODO: implementar verificacion de contraseña segura
			$errors["passwd"] = "La contraseña debe tener al menos cinco caracteres.";	
		}
      
		if (sizeof($errors)>0){
			throw new ValidationException($errors, "user is not valid");
		}
	}
}