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