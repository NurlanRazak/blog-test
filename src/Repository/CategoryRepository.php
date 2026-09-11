<?php

declare(strict_types=1);

namespace App\Repository;

use App\Config\Database;
use PDO;


final class CategoryRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare('SELECT id, name, slug, description FROM categories WHERE slug = :slug LIMIT 1');
        $stmt->execute(['slug' => $slug]);

        $category = $stmt->fetch();

        return $category ?: null;
    }

    /**
     * @return array
     */
    public function findWithArticles(): array
    {
        $sql = "SELECT c.id, c.name, c.slug, c.description
                FROM categories c
                WHERE EXISTS (
                    SELECT 1 FROM article_category ac
                    WHERE ac.category_id = c.id
                )
                ORDER BY c.name ASC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    /**
     * @param string $name
     * @param string $slug
     * @param string|null $description
     * @return int
     */
    public function create(string $name, string $slug, ?string $description): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO categories (name, slug, description) VALUES (:name, :slug, :description)'
        );
        $stmt->execute(['name' => $name, 'slug' => $slug, 'description' => $description]);

        return (int) $this->db->lastInsertId();
    }
}