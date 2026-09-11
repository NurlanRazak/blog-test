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
     * Похожие посты = посты, относящиеся хотя бы к одной категории, за исключением текущей.
     * article, most recent first.
     *
     * @param int[] $categoryIds
     * @return array<int, array<string, mixed>>
     */
    public function similarTo(int $articleId, array $categoryIds, int $limit = 3): array
    {
        if ($categoryIds === []) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));

        $sql = "SELECT DISTINCT a.id, a.title, a.slug, a.image, a.description, a.views, a.published_at
                FROM articles a
                INNER JOIN article_category ac ON ac.article_id = a.id
                WHERE ac.category_id IN ({$placeholders})
                  AND a.id != ?
                ORDER BY a.published_at DESC
                LIMIT ?";

        $stmt = $this->db->prepare($sql);

        $i = 1;
        foreach ($categoryIds as $categoryId) {
            $stmt->bindValue($i++, $categoryId, PDO::PARAM_INT);
        }
        $stmt->bindValue($i++, $articleId, PDO::PARAM_INT);
        $stmt->bindValue($i, $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }


    /**
     * @param int $articleId
     * @return array
     */
    public function categoriesFor(int $articleId): array
    {
        $sql = "SELECT c.id, c.name, c.slug
                FROM categories c
                INNER JOIN article_category ac ON ac.category_id = c.id
                WHERE ac.article_id = :article_id
                ORDER BY c.name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['article_id' => $articleId]);

        return $stmt->fetchAll();
    }

    /**
     * @param int $articleId
     * @return void
     */
    public function incrementViews(int $articleId): void
    {
        $stmt = $this->db->prepare('UPDATE articles SET views = views + 1 WHERE id = :id');
        $stmt->execute(['id' => $articleId]);
    }


    /**
     * @param string $slug
     * @return array|null
     */
    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT id, title, slug, image, description, content, views, published_at
             FROM articles WHERE slug = :slug LIMIT 1'
        );
        $stmt->execute(['slug' => $slug]);

        $article = $stmt->fetch();

        return $article ?: null;
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