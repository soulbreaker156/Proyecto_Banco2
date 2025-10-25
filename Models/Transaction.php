<?php
require_once __DIR__ . '/../config/Database.php';

class Transaction {
    private $conn; 
    private $table_name = "transacciones";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create($userId, $type, $amount) {
        $query = "INSERT INTO " . $this->table_name . " (usuario_id, tipo, monto) VALUES (:user_id, :type, :amount)";
        
        $stmt = $this->conn->prepare($query);

        // Vincular parámetros
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':amount', $amount);

        return $stmt->execute();
    }

    public function findByUserId($userId) {
        $query = "SELECT tipo, monto, fecha FROM " . $this->table_name . " WHERE usuario_id = :user_id ORDER BY fecha DESC";
        
        $stmt = $this->conn->prepare($query);

        // Vincular parámetro
        $stmt->bindParam(':user_id', $userId);

        $stmt->execute();
        
        return $stmt;
    }
}
?>