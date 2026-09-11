<?php

declare(strict_types=1);

namespace App\Repository;

use App\Config\Database;
use PDO;
use Throwable;

final class ArticleRepository
{

    private const ALLOWED_SORTS = [
        'date'  => 'a.published_at DESC',
        'views' => 'a.views DESC',
    ];

    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /**
     * Общее кол-во постов в категории, нужно для пагинации.
     */
    public function countForCategory(int $categoryId): int
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) FROM article_category WHERE category_id = :category_id'
        );
        $stmt->execute(['category_id' => $categoryId]);

        return (int) $stmt->fetchColumn();
    }

    /**
     * посты в одной странице категории
     *
     * @return array<int, array<string, mixed>>
     */
    public function findForCategory(int $categoryId, string $sort, int $limit, int $offset): array
    {
        $orderBy = self::ALLOWED_SORTS[$sort] ?? self::ALLOWED_SORTS['date'];

        $sql = "SELECT a.id, a.title, a.slug, a.image, a.description, a.views, a.published_at
                FROM articles a
                INNER JOIN article_category ac ON ac.article_id = a.id
                WHERE ac.category_id = :category_id
                ORDER BY {$orderBy}
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @param int $categoryId
     * @param int $limit
     * @return array
     */
    public function latestForCategory(int $categoryId, int $limit = 3): array
    {
        $sql = "SELECT a.id, a.title, a.slug, a.image, a.description, a.views, a.published_at
                FROM articles a
                INNER JOIN article_category ac ON ac.article_id = a.id
                WHERE ac.category_id = :category_id
                ORDER BY a.published_at DESC
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
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

        $this->db->beginTransaction();

        try {
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

            $this->db->commit();

            return $articleId;
        } catch (Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}