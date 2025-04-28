<?php
namespace App\Models;

use PDO;
use PDOException;

class CommentModel extends BaseModel
{
  /**
   * Create a new comment
   * @throws \Exception if user is not logged in
   */
  public function createComment(int $articleId, string $content): bool
  {
    if (!$this->user_id) {
      throw new \Exception("User not logged in");
    }

    try {
      $sql = "INSERT INTO comments (article_id, user_id, comment_text) 
                   VALUES (:article_id, :user_id, :content)";

      $stmt = $this->pdo->prepare($sql);
      return $stmt->execute([
        ':article_id' => $articleId,
        ':user_id' => $this->user_id,
        ':content' => trim($content)
      ]);
    } catch (PDOException $e) {
      error_log("Error creating comment: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Update an existing comment
   */
  public function updateComment(int $id, string $content): bool
  {
    try {
      $sql = "UPDATE comments 
                   SET comment_text = :content, 
                       updated_at = CURRENT_TIMESTAMP 
                   WHERE id = :id";

      $stmt = $this->pdo->prepare($sql);
      return $stmt->execute([
        ':content' => trim($content),
        ':id' => $id
      ]);
    } catch (PDOException $e) {
      error_log("Error updating comment: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Get comments for an article with user information
   * @return array Comments with user details
   */
  public function getCommentsByArticleId(int $articleId): array
  {
    try {
      $sql = "SELECT c.id, 
                           c.comment_text, 
                           c.comment_date,
                           u.username, 
                           u.profile_picture,
                           c.user_id
                    FROM comments c 
                    JOIN users u ON c.user_id = u.id 
                    WHERE c.article_id = :article_id 
                    ORDER BY c.comment_date ASC";

      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([':article_id' => $articleId]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Error fetching comments: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Get a single comment by ID
   */
  public function getCommentById(int $id): ?array
  {
    try {
      $sql = "SELECT c.*, u.username 
                   FROM comments c
                   JOIN users u ON c.user_id = u.id 
                   WHERE c.id = :id";

      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([':id' => $id]);
      return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    } catch (PDOException $e) {
      error_log("Error fetching comment: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Delete a comment
   */
  public function deleteComment(int $id): bool
  {
    try {
      $sql = "DELETE FROM comments WHERE id = :id";
      $stmt = $this->pdo->prepare($sql);
      return $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
      error_log("Error deleting comment: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Get paginated comments with user and article information
   */
  public function getPaginatedComments(int $page, int $perPage): array
  {
    try {
      $offset = ($page - 1) * $perPage;
      $query = "SELECT u.username as publisher, 
                            a.title as article_title, 
                            c.id,
                            c.comment_text,
                            c.comment_date,
                            c.user_id,
                            c.article_id
                     FROM comments c
                     LEFT JOIN users u ON c.user_id = u.id 
                     LEFT JOIN articles a ON a.id = c.article_id 
                     ORDER BY c.comment_date DESC 
                     LIMIT :limit OFFSET :offset";

      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
      $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Error fetching paginated comments: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Get total number of comments
   */
  public function getTotalComments(): int
  {
    try {
      return (int) $this->pdo->query("SELECT COUNT(*) FROM comments")
        ->fetchColumn();
    } catch (PDOException $e) {
      error_log("Error counting comments: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Get comment count for an article
   */
  public function getCommentCountForArticle(int $articleId): int
  {
    try {
      $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM comments WHERE article_id = :article_id");
      $stmt->execute([':article_id' => $articleId]);
      return (int) $stmt->fetchColumn();
    } catch (PDOException $e) {
      error_log("Error counting article comments: " . $e->getMessage());
      throw $e;
    }
  }
}
