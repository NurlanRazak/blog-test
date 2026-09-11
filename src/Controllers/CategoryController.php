<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Support\Paginator;

final class CategoryController extends BaseController
{

    public function show(array $params): void
    {
        $categoryRepo = new CategoryRepository();
        $articleRepo  = new ArticleRepository();

        $category = $categoryRepo->findBySlug($params['slug'] ?? '');

        if ($category === null) {
            (new ErrorController())->notFound();
            return;
        }

        $requestedSort = $_GET['sort'] ?? 'date';
        $sort          = in_array($requestedSort, ['date', 'views'], true) ? $requestedSort : 'date';
        $page    = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = (int) $this->config['ARTICLES_PER_PAGE'];

        $result    = $articleRepo->paginatedForCategory((int) $category['id'], $sort, $perPage, ($page - 1) * $perPage);
        $paginator = new Paginator($page, $perPage, $result['total']);

        $this->render('category.tpl', [
            'page_title' => $category['name'],
            'category'   => $category,
            'articles'   => $result['items'],
            'sort'       => $sort,
            'paginator'  => $paginator,
        ]);
    }
}