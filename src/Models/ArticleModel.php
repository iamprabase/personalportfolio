<?php
namespace App\Models;

class ArticleModel extends BaseModel {

    public function getAllArticles(): array {
        $stmt = $this->pdo->query("SELECT * FROM articles ORDER BY publication_date DESC");
        return $stmt->fetchAll();
    }

    public function createArticle(string $title, string $content, string $slug, string $featuredImage = null, string $post_type = null): bool {
        $article_with_slug_exists = $this->getArticleBySlugCount($slug);

        if($article_with_slug_exists) {
          $slug = $slug . '-' . $this->getArticleBySlugCount($slug)['cnt'] + 1;
        }

        $user_id = $_SESSION['user']['id'];
        $sql = "INSERT INTO articles (title, content, user_id, slug, featured_image, post_type) VALUES (?, ?, ?, ?, ?, ?)";

        return $this->execute($sql, [$title, $content, $user_id, $slug, $featuredImage, $post_type]);
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


     public function getArticleByCommentId($id): ?array {
        $stmt = $this->pdo->prepare("SELECT articles.* FROM articles a INNER JOIN comments c ON c.article_id = a.id AND c.id = \'?'\ WHERE c.article_id = ?");
        $stmt->execute([$id, $id]);
        return $stmt->fetch() ?: null;
    }

    public function updateArticle(int $id, string $title, string $content, string $slug, string $featuredImage = null, string $post_type = null): bool {
        $article_with_slug_exists = $this->getArticleBySlugCount($slug);

        if($article_with_slug_exists) {
          $slug = $slug . '-' . time();
        }

        $sql = "UPDATE articles SET title = ?, content = ?, slug = ?, featured_image = ?, post_type = ? WHERE id = ?";
        return $this->execute($sql, [$title, $content, $slug, $featuredImage, $post_type, $id]);
    }

    public function deleteArticle(int $id): bool {
        $sql = "DELETE FROM articles WHERE id = ?";
        return $this->execute($sql, [$id]);
    }

    public function getPaginatedArticles(int $page, int $perPage): array {
        $offset = ($page - 1) * $perPage;
        $query = "SELECT `users`.`username` as publisher, `articles`.* FROM articles LEFT JOIN users ON articles.user_id = users.id ORDER BY publication_date DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($query); // Use $this->pdo for consistency
        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTotalArticles(): int {
        $query = "SELECT COUNT(*) as total FROM articles";
        $stmt = $this->pdo->query($query); // Use $this->pdo for consistency
        return (int)$stmt->fetch(\PDO::FETCH_ASSOC)['total'];
    }
}
