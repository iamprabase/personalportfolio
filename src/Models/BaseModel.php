<?php

namespace App\Models;

use PDO;
use PDOException;

abstract class BaseModel
{
  protected ?PDO $pdo;
  protected ?int $user_id;

  public function __construct()
  {
    try {
      $this->connect();
      $this->user_id = $_SESSION['user']['id'] ?? null;
    } catch (PDOException $e) {
      // Log the error and throw a generic database error
      error_log("Database connection error: " . $e->getMessage());
      throw new \RuntimeException('Database connection failed');
    }
  }

  private function connect(): void
  {
    $this->pdo = \App\Config\Database::getConnection();
  }

  /**
   * Execute a SELECT query and return results
   * @param string $sql
   * @param array $params
   * @return array
   * @throws PDOException
   */
  protected function query(string $sql, array $params = []): array
  {
    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute($params);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Query execution error: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Execute an INSERT/UPDATE/DELETE query
   * @param string $sql
   * @param array $params
   * @return bool
   * @throws PDOException
   */
  protected function execute(string $sql, array $params = []): bool
  {
    try {
      $stmt = $this->pdo->prepare($sql);
      return $stmt->execute($params);
    } catch (PDOException $e) {
      error_log("Execute error: " . $e->getMessage());
      throw $e;
    }
  }
}
