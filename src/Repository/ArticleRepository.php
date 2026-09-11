<?php

declare(strict_types=1);

namespace App\Repository;

use App\Config\Database;
use PDO;

final class ArticleRepository
{

    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /**
     * @param string $title
     * @param string $slug
     * @param string|null $image
     * @param string|null $description
     * @param string $content
     * @param string $publishedAt
     * @param array $categoryIds
     * @param int $views
     * @return int
     */
    public function create(
        string $title,
        string $slug,
        ?string $image,
        ?string $description,
        string $content,
        string $publishedAt,
        array $categoryIds,
        int $views = 0
    ): int {

        $stmt = $this->db->prepare(
            'INSERT INTO articles (title, slug, image, description, content, views, published_at)
             VALUES (:title, :slug, :image, :description, :content, :views, :published_at)'
        );

        $stmt->execute([
            'title'        => $title,
            'slug'         => $slug,
            'image'        => $image,
            'description'  => $description,
            'content'      => $content,
            'views'        => $views,
            'published_at' => $publishedAt,
        ]);

        $articleId = (int) $this->db->lastInsertId();

        $linkStmt = $this->db->prepare(
            'INSERT INTO article_category (article_id, category_id) VALUES (:article_id, :category_id)'
        );
        foreach ($categoryIds as $categoryId) {
            $linkStmt->execute(['article_id' => $articleId, 'category_id' => $categoryId]);
        }

        return $articleId;
    }
}