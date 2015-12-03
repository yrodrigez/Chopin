<?php
require_once(__DIR__."/../core/PDOConnection.php");

class IngredienteMapper
{
    /**
     * Reference to the PDO connection
     * @var PDO
     */
    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    public function borrar($idpincho) {
        $stmt = $this->db->prepare("DELETE FROM ingredientes WHERE idpincho = ?");
        return $stmt->execute(array($idpincho));
    }
}
?>