<?php
namespace App\Models;

use PDO;
use PDOException;

class ArticleModel extends BaseModel
{
  /**
   * Get article by slug
   * @param string $slug
   * @return array|null
   */
  public function getArticleBySlug(string $slug): ?array
  {
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE slug = :slug");
      $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    } catch (PDOException $e) {
      error_log("Error fetching article by slug: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Create a new article
   */
  public function createArticle(
    string $title,
    string $content,
    string $slug,
    ?string $featuredImage = null,
    ?string $post_type = null
  ): bool {
    try {
      $uniqueSlug = $this->generateUniqueSlug($slug);

      $sql = "INSERT INTO articles (title, content, user_id, slug, featured_image, post_type) 
                   VALUES (:title, :content, :user_id, :slug, :featured_image, :post_type)";

      $stmt = $this->pdo->prepare($sql);
      return $stmt->execute([
        ':title' => $title,
        ':content' => $content,
        ':user_id' => $this->user_id,
        ':slug' => $uniqueSlug,
        ':featured_image' => $featuredImage,
        ':post_type' => $post_type
      ]);
    } catch (PDOException $e) {
      error_log("Error creating article: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Generate unique slug
   */
  private function generateUniqueSlug(string $slug): string
  {
    $originalSlug = $slug;
    $counter = 1;

    while ($this->isSlugExists($slug)) {
      $slug = $originalSlug . '-' . $counter++;
    }

    return $slug;
  }

  /**
   * Check if slug exists
   */
  private function isSlugExists(string $slug): bool
  {
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM articles WHERE slug = :slug");
    $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
    $stmt->execute();
    return (int) $stmt->fetchColumn() > 0;
  }

  /**
   * Get article by ID
   */
  public function getArticleById(int $id): ?array
  {
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE id = :id");
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    } catch (PDOException $e) {
      error_log("Error fetching article by ID: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Update an existing article
   */
  public function updateArticle(
    int $id,
    string $title,
    string $content,
    string $slug,
    ?string $featuredImage = null,
    ?string $post_type = null
  ): bool {
    try {
      $uniqueSlug = $this->generateUniqueSlug($slug);

      $sql = "UPDATE articles 
                   SET title = :title, 
                       content = :content, 
                       slug = :slug, 
                       featured_image = :featured_image, 
                       post_type = :post_type 
                   WHERE id = :id";

      $stmt = $this->pdo->prepare($sql);
      return $stmt->execute([
        ':title' => $title,
        ':content' => $content,
        ':slug' => $uniqueSlug,
        ':featured_image' => $featuredImage,
        ':post_type' => $post_type,
        ':id' => $id
      ]);
    } catch (PDOException $e) {
      error_log("Error updating article: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Delete an article
   */
  public function deleteArticle(int $id): bool
  {
    try {
      $stmt = $this->pdo->prepare("DELETE FROM articles WHERE id = :id");
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      return $stmt->execute();
    } catch (PDOException $e) {
      error_log("Error deleting article: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Get paginated articles with publisher information
   */
  public function getPaginatedArticles(int $page, int $perPage): array
  {
    try {
      $offset = ($page - 1) * $perPage;
      $query = "SELECT u.username as publisher, a.* 
                     FROM articles a 
                     LEFT JOIN users u ON a.user_id = u.id 
                     ORDER BY a.publication_date DESC 
                     LIMIT :limit OFFSET :offset";

      $stmt = $this->pdo->prepare($query);
      $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
      $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Error fetching paginated articles: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Get total number of articles
   */
  public function getTotalArticles(): int
  {
    try {
      return (int) $this->pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
    } catch (PDOException $e) {
      error_log("Error counting articles: " . $e->getMessage());
      throw $e;
    }
  }
}
