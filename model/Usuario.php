<?php

class Usuario {
    const ORGANIZADOR = 0;
    const JURADO_POPULAR = 1;
    const JURADO_PROFESIONAL = 2;
    const ESTABLECIMIENTO = 3;

    const SALT = "&B|;kH=AQr#vaZ*3*bOHauSx";

    private $email;
    private $password;
    private $tipo;
    private $telefono;
    private $fotoUsuario;
    private $preferencias;
	
    public function __construct(
        $email=NULL,
        $password=NULL,
        $tipo=NULL,
        $telefono=NULL,
        $fotoUsuario=NULL,
        $preferencias=NULL
    ) {
        $this->setEmail($email);
        $this->setFotoUsuario($fotoUsuario);
        $this->setPassword($password);
        $this->setTelefono($telefono);
        $this->setTipo($tipo);
        $this->setPreferencias($preferencias);
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFotoUsuario()
    {
        return $this->fotoUsuario;
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

    public function getPreferencias()
    {
        return $this->preferencias;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setFotoUsuario($fotoUsuario)
    {
        $this->fotoUsuario = $fotoUsuario;
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

    public function setPreferencias($preferencias)
    {
        $this->preferencias = $preferencias;
    }

	public function isValidForRegister() {
		$errors = array();
		
		if (strlen($this->email) < 5) {
            array_push($errors, array("error", "El usuario debe tener al menos cinco caracteres."));
		}
      
		if (strlen($this->password) < 5) {  // TODO: implementar verificacion de contraseña segura
            array_push($errors, array("error", "La contraseña debe tener al menos cinco caracteres"));
		}
      
		if (sizeof($errors)>0){
			throw new ValidationException($errors, "user is not valid");
		}
	}
}