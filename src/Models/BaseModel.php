<?php

namespace App\Models;

use PDO;

abstract class BaseModel {
    protected $pdo;

    public function __construct() {
        $this->connect();
    }

    // Use \App\Config\Database::getConnection to establish the connection
    private function connect(): void {
        $this->pdo = \App\Config\Database::getConnection();
    }

    // Reusable query method
    protected function query(string $sql, array $params = []): array {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Reusable execute method
    protected function execute(string $sql, array $params = []): bool {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
}
