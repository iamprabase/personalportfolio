<?php
namespace App\Models;

use PDO;
use PDOException;

class PageModel extends BaseModel
{
  /**
   * Get all pages with optional caching
   * @return array
   */
  public function getAllPages(): array
  {
    try {
      $sql = "SELECT id, title, slug, content, created_at, page_parent_id 
                   FROM pages 
                   ORDER BY created_at DESC";

      $stmt = $this->pdo->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Error fetching all pages: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Get a single page by its slug
   * @param string $slug
   * @return array|null
   */
  public function getPageBySlug(string $slug): ?array
  {
    try {
      $sql = "SELECT id, title, slug, content, created_at, page_parent_id 
                   FROM pages 
                   WHERE slug = :slug 
                   LIMIT 1";

      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([':slug' => $slug]);
      return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    } catch (PDOException $e) {
      error_log("Error fetching page by slug: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Get a single page by its ID
   * @param int $id
   * @return array|null
   */
  public function getPageById(int $id): ?array
  {
    try {
      $sql = "SELECT id, title, slug, content, created_at, page_parent_id 
                   FROM pages 
                   WHERE id = :id 
                   LIMIT 1";

      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([':id' => $id]);
      return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    } catch (PDOException $e) {
      error_log("Error fetching page by ID: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Create a new page with unique slug
   * @return bool
   */
  public function createPage(
    string $title,
    string $content,
    string $slug,
    ?string $pageParent = null
  ): bool {
    try {
      $uniqueSlug = $this->generateUniqueSlug($slug);

      $sql = "INSERT INTO pages (title, content, slug, page_parent_id, created_at) 
                   VALUES (:title, :content, :slug, :page_parent_id, NOW())";

      $params = [
        ':title' => trim($title),
        ':content' => trim($content),
        ':slug' => $uniqueSlug,
        ':page_parent_id' => $pageParent ?: null
      ];

      $stmt = $this->pdo->prepare($sql);
      return $stmt->execute($params);
    } catch (PDOException $e) {
      error_log("Error creating page: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Update an existing page
   * @return bool
   */
  public function updatePage(
    int $id,
    string $title,
    string $content,
    string $slug,
    ?string $pageParent = null
  ): bool {
    try {
      $currentPage = $this->getPageById($id);
      if (!$currentPage) {
        return false;
      }

      $uniqueSlug = $slug !== $currentPage['slug']
        ? $this->generateUniqueSlug($slug)
        : $slug;

      $sql = "UPDATE pages 
                   SET title = :title, 
                       content = :content, 
                       slug = :slug, 
                       page_parent_id = :page_parent_id,
                       updated_at = NOW()
                   WHERE id = :id";

      $params = [
        ':title' => trim($title),
        ':content' => trim($content),
        ':slug' => $uniqueSlug,
        ':page_parent_id' => $pageParent ?: null,
        ':id' => $id
      ];

      $stmt = $this->pdo->prepare($sql);
      return $stmt->execute($params);
    } catch (PDOException $e) {
      error_log("Error updating page: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Delete a page
   * @return bool
   */
  public function deletePage(int $id): bool
  {
    try {
      $sql = "DELETE FROM pages WHERE id = :id";
      $stmt = $this->pdo->prepare($sql);
      return $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
      error_log("Error deleting page: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Get paginated pages
   * @return array
   */
  public function getPaginatedPages(int $page, int $perPage): array
  {
    try {
      $offset = ($page - 1) * $perPage;
      $sql = "SELECT id, title, slug, created_at, page_parent_id 
                   FROM pages 
                   ORDER BY created_at DESC 
                   LIMIT :limit OFFSET :offset";

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
      $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Error fetching paginated pages: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Get total number of pages
   * @return int
   */
  public function getTotalPages(): int
  {
    try {
      return (int) $this->pdo->query("SELECT COUNT(*) FROM pages")
        ->fetchColumn();
    } catch (PDOException $e) {
      error_log("Error counting pages: " . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Generate a unique slug
   * @return string
   */
  private function generateUniqueSlug(string $slug): string
  {
    $baseSlug = $this->sanitizeSlug($slug);
    $uniqueSlug = $baseSlug;
    $counter = 1;

    while ($this->isSlugExists($uniqueSlug)) {
      $uniqueSlug = $baseSlug . '-' . $counter++;
    }

    return $uniqueSlug;
  }

  /**
   * Check if slug exists
   * @return bool
   */
  private function isSlugExists(string $slug): bool
  {
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM pages WHERE slug = :slug");
    $stmt->execute([':slug' => $slug]);
    return (int) $stmt->fetchColumn() > 0;
  }

  /**
   * Sanitize slug
   * @return string
   */
  private function sanitizeSlug(string $slug): string
  {
    return strtolower(preg_replace(
      '/[^a-zA-Z0-9-]/',
      '-',
      trim($slug)
    ));
  }
}
