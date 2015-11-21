

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
            echo uniqid();
            $stmt->execute(array(uniqid(), $codigo->getIdPropuesta(), 0, 0));
            $i=$i+1;
        }
    }


}
?>
