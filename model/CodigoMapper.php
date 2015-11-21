

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

    public function retornarCodigosEstablecimiento($id){
        $stmt = $this->db->query("SELECT * FROM codigo, propuesta WHERE propuesta.email=".$id);
        $codigos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $codigos = array();

        foreach ($codigos_db as $codigos) {
            $codigo = new Codigo($codigos_db['idpropuesta'],$codigos_db['idcodigo']);
            array_push($codigos, $codigo);
        }

        return $codigos;
    }

}
?>


