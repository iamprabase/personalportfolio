<?php
namespace App\Models;

class CommentModel extends BaseModel {

    public function createComment(int $articleId, $content): bool {
      $sql = "INSERT INTO comments (article_id, user_id, comment_text) VALUES (?, ?, ?)";
      $userId = $_SESSION['user']['id'] ?? null; // Assuming user ID is stored in session
      if (!$userId) {
          throw new \Exception("User not logged in");
      }
      return $this->execute($sql, [$articleId, $userId, $content]);
    }

    public function updateComment(int $id, $content): bool {
      $sql = "UPDATE comments SET comment_text = ? WHERE id = ?";
      
      return $this->execute($sql, [$content, $id]);
    }
        
    public function getCommentsByArticleId(int $articleId): array {
        $stmt = $this->pdo->prepare("SELECT c.*, u.username, u.profile_picture FROM comments c JOIN users u ON c.user_id = u.id WHERE c.article_id = ? ORDER BY c.comment_date ASC");
        $stmt->execute([$articleId]);
        return $stmt->fetchAll();
    }

     public function getCommentById($id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM comments WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function getAllComments(): array {
        $stmt = $this->pdo->query("SELECT * FROM comments ORDER BY creation_date DESC");
        return $stmt->fetchAll();
    }

    public function deleteComment(int $id): bool {
        $sql = "DELETE FROM comments WHERE id = ?";
        return $this->execute($sql, [$id]);
    }
}
