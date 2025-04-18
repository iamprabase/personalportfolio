<?php
namespace App\Models;

class UserModel extends BaseModel
{

  public function getUserByUsername(string $username): ?array
  {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetch() ?: null;
  }

  public function registerUser(string $username, string $email, string $full_name, string $hashedPassword, $profilePicture = null, string $city = null, string $country = null): ?int
  {
    $stmt = $this->pdo->prepare("INSERT INTO users (username, email, full_name, password, profile_picture, city, country) VALUES (?, ?, ?, ?, ? , ?, ?)");
    if ($stmt->execute([$username, $email, $full_name, $hashedPassword, $profilePicture, $city, $country])) {
      return (int) $this->pdo->lastInsertId();
    }
    return null;
  }

  public function updateProfile(int $id, string $profilePicture, string $hashedPassword = null): ?int
  {
    $params = [$profilePicture];
    $sql = "UPDATE users SET profile_picture = ? ";

    if (!empty($hashedPassword)) {
      $sql .= ", password = ? ";
      $params[] = $hashedPassword;
    }

    $sql .= "WHERE id = ?";
    $params[] = $id;

    return $this->execute($sql, $params);
  }

  public function getPaginatedUsers(int $page, int $perPage): array
  {
    $offset = ($page - 1) * $perPage;
    $query = "SELECT * FROM users ORDER BY registration_date DESC LIMIT :limit OFFSET :offset";
    $stmt = $this->pdo->prepare($query); // Use $this->pdo for consistency
    $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function getTotalUsers(): int {
    $query = "SELECT COUNT(*) as total FROM users";
    $stmt = $this->pdo->query($query); // Use $this->pdo for consistency
    return (int)$stmt->fetch(\PDO::FETCH_ASSOC)['total'];
  }
}
