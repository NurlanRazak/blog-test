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

        // Сначала подсчитываем количество, чтобы пагинатор знал реальный диапазон страниц
        $total     = $articleRepo->countForCategory((int) $category['id']);
        $paginator = new Paginator($page, $perPage, $total);

        // ...затем выполняем выборку, используя смещение, которое пагинатор уже ограничил допустимым диапазоном.
        $articles = $articleRepo->findForCategory(
            (int) $category['id'],
            $sort,
            $perPage,
            $paginator->offset()
        );

        $this->render('category.tpl', [
            'page_title' => $category['name'],
            'category'   => $category,
            'articles'   => $articles,
            'sort'       => $sort,
            'paginator'  => $paginator,
        ]);
    }
}