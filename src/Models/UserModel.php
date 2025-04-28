<?php
namespace App\Models;

use PDO;
use PDOException;

class UserModel extends BaseModel
{
  private const CACHE_TTL = 3600; // 1 hour cache

  /**
   * Get user by username with caching
   * @param string $username
   * @return array|null
   */
  public function getUserByUsername(string $username, int $is_admin = 0): ?array
  {
    try {
      // Check cache first
      $cacheKey = "user_" . md5($username);
      if ($cached = $this->getCache($cacheKey)) {
        return $cached;
      }

      $sql = "SELECT id, is_admin, username, password, email, full_name, profile_picture, 
                          city, country, registration_date 
                   FROM users 
                   WHERE username = :username AND 
                   is_admin = :is_admin
                   LIMIT 1";

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':username', $username, PDO::PARAM_STR);
      $stmt->bindParam(':is_admin', $is_admin, PDO::PARAM_STR);
      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;

      if ($result) {
        $this->setCache($cacheKey, $result, self::CACHE_TTL);
      }

      return $result;
    } catch (PDOException $e) {
      error_log("Error fetching user by username: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Register new user with validation
   * @throws \InvalidArgumentException
   */
  public function registerUser(
    string $username,
    string $email,
    string $full_name,
    string $hashedPassword,
    ?string $profilePicture = null,
    ?string $city = null,
    ?string $country = null
  ): ?int {
    try {
      // Validate input
      $this->validateUserInput($username, $email, $full_name);

      // Begin transaction
      $this->pdo->beginTransaction();

      $sql = "INSERT INTO users (
                        username, email, full_name, password, 
                        profile_picture, city, country, 
                        registration_date
                    ) VALUES (
                        :username, :email, :full_name, :password,
                        :profile_picture, :city, :country,
                        NOW()
                    )";

      $stmt = $this->pdo->prepare($sql);

      $success = $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':full_name' => $full_name,
        ':password' => $hashedPassword,
        ':profile_picture' => $profilePicture,
        ':city' => $city,
        ':country' => $country
      ]);

      if ($success) {
        $userId = (int) $this->pdo->lastInsertId();
        $this->pdo->commit();
        return $userId;
      }

      $this->pdo->rollBack();
      return null;
    } catch (PDOException $e) {
      $this->pdo->rollBack();
      error_log("Error registering user: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Update user profile with validation
   */
  public function updateProfile(
    int $id,
    string $profilePicture,
    ?string $hashedPassword = null
  ): bool {
    try {
      $params = [':profile_picture' => $profilePicture];
      $sql = "UPDATE users SET profile_picture = :profile_picture";

      if ($hashedPassword) {
        $sql .= ", password = :password";
        $params[':password'] = $hashedPassword;
      }

      $sql .= ", updated_at = NOW() WHERE id = :id";
      $params[':id'] = $id;

      $stmt = $this->pdo->prepare($sql);
      $success = $stmt->execute($params);

      if ($success) {
        $this->clearUserCache($id);
      }

      return $success;
    } catch (PDOException $e) {
      error_log("Error updating profile: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Get paginated users with optimized query
   */
  public function getPaginatedUsers(int $page, int $perPage): array
  {
    try {
      $offset = ($page - 1) * $perPage;

      $sql = "SELECT id, username, email, full_name, 
                          profile_picture, city, country, 
                          registration_date 
                   FROM users 
                   ORDER BY registration_date DESC 
                   LIMIT :limit OFFSET :offset";

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
      $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Error fetching paginated users: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Get total users count with caching
   */
  public function getTotalUsers(): int
  {
    try {
      $cacheKey = 'total_users_count';
      if ($cached = $this->getCache($cacheKey)) {
        return $cached;
      }

      $count = (int) $this->pdo->query("SELECT COUNT(*) FROM users")
        ->fetchColumn();

      $this->setCache($cacheKey, $count, 300); // Cache for 5 minutes
      return $count;
    } catch (PDOException $e) {
      error_log("Error counting users: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Validate user input
   * @throws \InvalidArgumentException
   */
  private function validateUserInput(
    string $username,
    string $email,
    string $full_name
  ): void {
    if (strlen($username) < 3 || strlen($username) > 50) {
      throw new \InvalidArgumentException('Invalid username length');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new \InvalidArgumentException('Invalid email format');
    }

    if (strlen($full_name) < 2 || strlen($full_name) > 100) {
      throw new \InvalidArgumentException('Invalid full name length');
    }
  }

  /**
   * Clear user cache
   */
  private function clearUserCache(int $userId): void
  {
    // Implement cache clearing logic
    // Example: $cache->delete("user_" . $userId);
  }

  /**
   * Get cached data
   */
  private function getCache(string $key): ?array
  {
    // Implement your caching logic here
    return null;
  }

  /**
   * Set cache data
   */
  private function setCache(string $key, $data, int $ttl): void
  {
    // Implement your caching logic here
  }
}
