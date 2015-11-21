

<?php
require_once(__DIR__."/Codigo.php");
require_once(__DIR__."/../core/PDOConnection.php");

class CodigoMapper {

    private $idCodigo;
    private $idPropuesta;
    private $email;
    private $utilizado;
    private $elegido;
    private $fechaVotacion;
    private $db;

    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }

    public function generar($codigo, $num) {
        $stmt = $this->db->prepare("INSERT INTO codigo(idcodigo, idpropuesta, utilizado, elegido) values (?,?,?,?)");

        $i=0;
        while($i<$num) {
            $stmt->execute(array(uniqid(), $codigo->getIdPropuesta(), 0, 0));
            $i=$i+1;
        }
    }

    public function getCodigosEstablecimiento($email){
        $stmt = $this->db->prepare("SELECT * FROM codigo, propuesta WHERE codigo.idpropuesta=propuesta.idpropuesta and propuesta.email=?");
        $stmt->execute(array($email));
        $codigos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $codigos = array();

        foreach ($codigos_db as $codigo) {
            $codigo = new Codigo($codigo['idcodigo'], $codigo['idpropuesta'], $codigo['email'], $codigo['utilizado'], $codigo['elegido'], $codigo['fechaVotacion']);
            array_push($codigos, $codigo);
        }

        return $codigos;
    }

    public function existe($codigo) {
        $stmt = $this->db->prepare("SELECT * FROM codigo where idcodigo=?");
        $stmt->execute(array($codigo));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row != NULL;
    }

    public function usado($codigo) {  // Asume que existe
        $stmt = $this->db->prepare("SELECT * FROM codigo where idcodigo=? and utilizado=1");
        $stmt->execute(array($codigo));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row != NULL;
    }

    public function asociarUsuario($codigo, $email) {
        $stmt = $this->db->prepare("UPDATE codigo SET utilizado=1, email=? WHERE idcodigo=?");
        $stmt->execute(array($email, $codigo));
    }

}
?>


