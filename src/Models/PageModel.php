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

    public function getPageById(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM pages WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    // Create a new page
    public function createPage(array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO pages (identifier, title, subtitle, content, slug, meta_title, meta_description, canonical_url, language) 
             VALUES (:identifier, :title, :subtitle, :content, :slug, :meta_title, :meta_description, :canonical_url, :language)"
        );

        $stmt->bindParam(':identifier', $data['identifier'], PDO::PARAM_STR);
        $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
        $stmt->bindParam(':subtitle', $data['subtitle'], PDO::PARAM_STR);
        $stmt->bindParam(':content', $data['content'], PDO::PARAM_STR);
        $stmt->bindParam(':slug', $data['slug'], PDO::PARAM_STR);
        $stmt->bindParam(':meta_title', $data['meta_title'], PDO::PARAM_STR);
        $stmt->bindParam(':meta_description', $data['meta_description'], PDO::PARAM_STR);
        $stmt->bindParam(':canonical_url', $data['canonical_url'], PDO::PARAM_STR);
        $stmt->bindParam(':language', $data['language'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Update an existing page
    public function updatePage(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE pages 
             SET identifier = :identifier, title = :title, subtitle = :subtitle, content = :content, 
                 slug = :slug, meta_title = :meta_title, meta_description = :meta_description, 
                 canonical_url = :canonical_url, language = :language 
             WHERE id = :id"
        );

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':identifier', $data['identifier'], PDO::PARAM_STR);
        $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
        $stmt->bindParam(':subtitle', $data['subtitle'], PDO::PARAM_STR);
        $stmt->bindParam(':content', $data['content'], PDO::PARAM_STR);
        $stmt->bindParam(':slug', $data['slug'], PDO::PARAM_STR);
        $stmt->bindParam(':meta_title', $data['meta_title'], PDO::PARAM_STR);
        $stmt->bindParam(':meta_description', $data['meta_description'], PDO::PARAM_STR);
        $stmt->bindParam(':canonical_url', $data['canonical_url'], PDO::PARAM_STR);
        $stmt->bindParam(':language', $data['language'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Delete a page
    public function deletePage(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM pages WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
