<?php
require_once __DIR__ . '/../config/Database.php';

class User {
    private $conn; // Este es un objeto PDO
    private $table_name = "usuarios";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function findByUsername($username) {
        $query = "SELECT id, usuario, password, saldo FROM " . $this->table_name . " WHERE usuario = :username LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        
        // Vincular parámetro
        $stmt->bindParam(':username', $username);
        
        $stmt->execute();
        
        // Obtener el resultado
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($username, $password) {
  
        $query = "INSERT INTO " . $this->table_name . " (usuario, password) VALUES (:username, :password)";
        
        $stmt = $this->conn->prepare($query);

        // Vincular parámetros
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        return $stmt->execute();
    }
    
    public function updateBalance($userId, $newBalance) {
        $query = "UPDATE " . $this->table_name . " SET saldo = :saldo WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        // Vincular parámetros
        $stmt->bindParam(':saldo', $newBalance);
        $stmt->bindParam(':id', $userId);

        return $stmt->execute();
    }
}
?>