<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Router;
use App\Controllers\HomeController;
use App\Controllers\CategoryController;

$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->get('/category/{slug}', CategoryController::class, 'show');

$router->dispatch(
    $_SERVER['REQUEST_METHOD'] ?? 'GET',
    $_SERVER['REQUEST_URI'] ?? '/'
);
