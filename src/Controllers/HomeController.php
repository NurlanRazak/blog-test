<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;

final class HomeController extends BaseController
{

    public function index(array $params = []): void
    {
        $categoryRepo = new CategoryRepository();
        $articleRepo  = new ArticleRepository();

        $categories = $categoryRepo->findWithArticles();

        // For each category that actually has posts, attach its 3 latest articles.
        foreach ($categories as &$category) {
            $category['latest_articles'] = $articleRepo->latestForCategory((int) $category['id'], 3);
        }
        unset($category);

        $this->render('home.tpl', [
            'page_title' => 'Блог',
            'categories' => $categories,
        ]);
    }
}