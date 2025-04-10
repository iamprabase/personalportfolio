<?php
namespace App\Models;

class CommentModel extends BaseModel {
        
    public function getCommentsByArticleId(int $articleId): array {
        $stmt = $this->pdo->prepare("SELECT c.*, u.username, u.photo FROM comments c JOIN users u ON c.user_id = u.id WHERE c.article_id = ? ORDER BY c.comment_date ASC");
        $stmt->execute([$articleId]);
        return $stmt->fetchAll();
    }

    public function getAllComments(): array {
        $sql = "SELECT * FROM comments ORDER BY created_at DESC";
        return $this->query($sql);
    }

    public function deleteComment(int $id): bool {
        $sql = "DELETE FROM comments WHERE id = ?";
        return $this->execute($sql, [$id]);
    }
}
