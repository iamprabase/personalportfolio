<?php
namespace App\Models;

class ArticleModel extends BaseModel {

    public function getAllArticles(): array {
        $stmt = $this->pdo->query("SELECT * FROM articles ORDER BY publication_date DESC");
        return $stmt->fetchAll();
    }

    public function createArticle(string $title, string $content, string $slug, string $featuredImage = null): bool {
        $article_with_slug_exists = $this->getArticleBySlugCount($slug);
        
        if($article_with_slug_exists) {
          $slug = $slug . '-' . $this->getArticleBySlugCount($slug)['cnt'] + 1;
        }

        $sql = "INSERT INTO articles (title, content, slug, featured_image) VALUES (?, ?, ?, ?)";
        return $this->execute($sql, [$title, $content, $slug, $featuredImage]);
    }

    public function getArticleBySlug(string $slug): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    }

    public function getArticleBySlugCount(string $slug): ?array {
        $stmt = $this->pdo->prepare("SELECT Count(*) as cnt FROM articles WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

     public function getArticleById($id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function updateArticle(int $id, string $title, string $content, string $slug, string $featuredImage = null): bool {
        $sql = "UPDATE articles SET title = ?, content = ?, slug = ?, featured_image = ? WHERE id = ?";
        return $this->execute($sql, [$title, $content, $slug, $featuredImage, $id]);
    }

    public function deleteArticle(int $id): bool {
        $sql = "DELETE FROM articles WHERE id = ?";
        return $this->execute($sql, [$id]);
    }
}
