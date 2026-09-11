<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repository\ArticleRepository;

final class ArticleController extends BaseController
{
    public function show(array $params): void
    {
        $articleRepo = new ArticleRepository();

        $article = $articleRepo->findBySlug($params['slug'] ?? '');

        if ($article === null) {
            (new ErrorController())->notFound();
            return;
        }

        $articleRepo->incrementViews((int) $article['id']);
        // reflect the increment immediately without a second SELECT
        $article['views'] = (int) $article['views'] + 1;

        $categories   = $articleRepo->categoriesFor((int) $article['id']);
        $categoryIds  = array_column($categories, 'id');
        $similar      = $articleRepo->similarTo((int) $article['id'], $categoryIds, 3);

        $this->render('article.tpl', [
            'page_title' => $article['title'],
            'article'    => $article,
            'categories' => $categories,
            'similar'    => $similar,
        ]);
    }
}