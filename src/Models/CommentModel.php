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

    public function getPaginatedComments(int $page, int $perPage): array {
      $offset = ($page - 1) * $perPage;
      $query = "SELECT `users`.`username` as publisher, `articles`.`title` as article_title, `comments`.* FROM comments LEFT JOIN users ON comments.user_id = users.id LEFT JOIN articles ON articles.id = comments.article_id ORDER BY comments.comment_date DESC LIMIT :limit OFFSET :offset";
      $stmt = $this->pdo->prepare($query); // Use $this->pdo for consistency
      $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
      $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTotalComments(): int {
      $query = "SELECT COUNT(*) as total FROM comments";
      $stmt = $this->pdo->query($query); // Use $this->pdo for consistency
      return (int)$stmt->fetch(\PDO::FETCH_ASSOC)['total'];
    }
}
