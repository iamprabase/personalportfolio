<?php

namespace App\Models;

class PageModel extends BaseModel {

    // Get all pages
    public function getAllPages(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM pages ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get a single page by its slug
    public function getPageBySlug(string $slug): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM pages WHERE slug = :slug LIMIT 1");
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    }
    // Get a single page by its slug
    public function getPageById(string $id): ?array
    {
      $stmt = $this->pdo->prepare("SELECT * FROM pages WHERE id = :id LIMIT 1");
      $stmt->execute([$id]);
      return $stmt->fetch() ?: null;
    }

    // Create a new page
    public function createPage(string $title, string $content, string $slug, string $page_parent = null): bool
    {
      $page_with_slug_exists = $this->getPageBySlug($slug);

      if($page_with_slug_exists) {
        $slug = $slug . '-' . time();
      }

      $sql = "INSERT INTO pages (title, content, slug, page_parent_id) VALUES (?, ?, ?, ?)";

      return $this->execute($sql, [$title, $content, $slug, $page_parent]);
    }

  public function updatePage(int $id, string $title, string $content, string $slug, string $page_parent = null): bool {
    $page_with_slug_exists = $this->getPageBySlug($slug);

    if($page_with_slug_exists) {
      $slug = $slug . '-' . time();
    }

    $sql = "UPDATE pages SET title = ?, content = ?, slug = ?, page_parent = ? WHERE id = ?";
    return $this->execute($sql, [$title, $content, $slug, $page_parent, $id]);
  }

    // Update an existing page
//    public function updatePage(int $id, array $data): bool
//    {
//        $stmt = $this->pdo->prepare(
//            "UPDATE pages
//             SET identifier = :identifier, title = :title, subtitle = :subtitle, content = :content,
//                 slug = :slug, meta_title = :meta_title, meta_description = :meta_description,
//                 canonical_url = :canonical_url, language = :language
//             WHERE id = :id"
//        );
//
//        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
//        $stmt->bindParam(':identifier', $data['identifier'], PDO::PARAM_STR);
//        $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
//        $stmt->bindParam(':subtitle', $data['subtitle'], PDO::PARAM_STR);
//        $stmt->bindParam(':content', $data['content'], PDO::PARAM_STR);
//        $stmt->bindParam(':slug', $data['slug'], PDO::PARAM_STR);
//        $stmt->bindParam(':meta_title', $data['meta_title'], PDO::PARAM_STR);
//        $stmt->bindParam(':meta_description', $data['meta_description'], PDO::PARAM_STR);
//        $stmt->bindParam(':canonical_url', $data['canonical_url'], PDO::PARAM_STR);
//        $stmt->bindParam(':language', $data['language'], PDO::PARAM_STR);
//
//        return $stmt->execute();
//    }

    // Delete a page
    public function deletePage(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM pages WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getPaginatedPages(int $page, int $perPage): array {
      $offset = ($page - 1) * $perPage;
      $query = "SELECT * FROM pages ORDER BY id DESC LIMIT :limit OFFSET :offset";
      $stmt = $this->pdo->prepare($query); // Use $this->pdo for consistency
      $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
      $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTotalPages(): int {
      $query = "SELECT COUNT(*) as total FROM pages";
      $stmt = $this->pdo->query($query); // Use $this->pdo for consistency
      return (int)$stmt->fetch(\PDO::FETCH_ASSOC)['total'];
    }
}
