<?php
require_once(__DIR__."/../core/PDOConnection.php");

class ValoracionMapper
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

    public function borrar($email) {
        $stmt = $this->db->prepare("DELETE FROM valoracion WHERE email = ?");
        $stmt->execute(array($email));
        return true;
    }
}
?>