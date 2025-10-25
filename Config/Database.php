<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'banco';
    private $username = 'postgres';
    private $password = 'Admin123';
    private $port = '5432';
    public $conn;

    public function getConnection() {
        $this->conn = null;
        
        
        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}";

        try {
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>