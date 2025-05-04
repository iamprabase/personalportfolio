<?php

namespace App\Config;
use PDO;

class Database
{
  private static $pdo = null;
  private static $config = null; // Holds the DB configuration

  /**
   * Sets the configuration for the database connection.
   *
   * @param array $config The database configuration (host, dbname, user, pass, charset)
   */
  public static function setConfig(array $config): void
  {
    self::$config = $config;
  }

  /**
   * Get the PDO instance using the stored configuration.
   *
   * @return PDO
   * @throws \Exception If configuration has not been set.
   */
  public static function getConnection(): PDO
  {
    if (self::$pdo === null) {
      if (self::$config === null) {
        throw new \Exception("Database configuration not set");
      }
      $host = self::$config['host'];
      $dbname = self::$config['dbname'];
      $user = self::$config['user'];
      $pass = self::$config['pass'];
      $charset = self::$config['charset'];
      $dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";

      self::$pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]);
    }
    return self::$pdo;
  }
}
