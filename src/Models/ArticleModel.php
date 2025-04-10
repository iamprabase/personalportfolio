<?php
namespace App\Models;

class ArticleModel extends BaseModel {

    public function getAllArticles(): array {
        $stmt = $this->pdo->query("SELECT * FROM articles ORDER BY publication_date DESC");
        return $stmt->fetchAll();
    }

    public function createArticle(string $title, string $content, string $slug): bool {
        $sql = "INSERT INTO articles (title, content, slug) VALUES (?, ?, ?)";
        return $this->execute($sql, [$title, $content, $slug]);
    }

    public function getArticleBySlug(string $slug): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    }

     public function getArticleById($id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function updateArticle(int $id, string $title, string $content, string $slug): bool {
        $sql = "UPDATE articles SET title = ?, content = ?, slug = ? WHERE id = ?";
        return $this->execute($sql, [$title, $content, $slug, $id]);
    }

    public function deleteArticle(int $id): bool {
        $sql = "DELETE FROM articles WHERE id = ?";
        return $this->execute($sql, [$id]);
    }
}
