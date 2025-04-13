<?php
namespace App\Models;

class UserModel extends BaseModel {
    
    public function getUserByUsername(string $username): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch() ?: null;
    }

    public function registerUser(string $username, string $email, string $hashedPassword, $profilePicture = null): ?int {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, profile_picture) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$username, $email, $hashedPassword, $profilePicture])) {
            return (int)$this->pdo->lastInsertId();
        }
        return null;
    }
}
