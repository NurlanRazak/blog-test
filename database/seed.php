<?php

/**
 * Test-data seeder. Run with:
 *   docker compose exec app php database/seed.php
 *
 * Safe to re-run: it clears the tables first, so counts stay stable.
 */

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Config\Database;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Support\Str;

$db           = Database::connection();
$categoryRepo = new CategoryRepository();
$articleRepo  = new ArticleRepository();

// --- 1. Clear -------------------------------------------------------------
// TRUNCATE is rejected on a table referenced by a foreign key, so we DELETE
// in dependency order instead: links first, then the rows they point at.
echo "Clearing existing data...\n";
$db->exec('DELETE FROM article_category');
$db->exec('DELETE FROM articles');
$db->exec('DELETE FROM categories');

// DELETE keeps the old AUTO_INCREMENT counter; reset it so re-running the
// seeder produces the same ids every time (much easier to debug against).
$db->exec('ALTER TABLE articles AUTO_INCREMENT = 1');
$db->exec('ALTER TABLE categories AUTO_INCREMENT = 1');

// --- 2. Categories --------------------------------------------------------
echo "Seeding categories...\n";

$categories = [
    ['PHP',          'Язык, экосистема и инструменты.'],
    ['JavaScript',   'Фронтенд, Node.js и всё вокруг.'],
    ['Базы данных',  'MySQL, проектирование схем и запросы.'],
    ['DevOps',       'Docker, CI/CD, серверы и автоматизация.'],
    ['Карьера',      'Собеседования, рост и софт-скиллы.'],
];

$categoryIds = [];
foreach ($categories as [$name, $description]) {
    $categoryIds[] = $categoryRepo->create($name, Str::slugify($name), $description);
}

// --- 3. Articles ----------------------------------------------------------
echo "Seeding articles...\n";

$titles = [
    'Топ-10 ошибок начинающих разработчиков',
    'Как устроен автозагрузчик Composer',
    'PSR-4 на практике',
    'Подготовленные запросы в PDO',
    'Почему EMULATE_PREPARES стоит выключить',
    'Индексы в MySQL: когда они не работают',
    'Нормализация против денормализации',
    'Связь многие-ко-многим на практике',
    'Docker для локальной разработки',
    'Многоступенчатая сборка образов',
    'Healthcheck и порядок запуска контейнеров',
    'Что такое фронт-контроллер',
    'Пишем простой маршрутизатор на регулярных выражениях',
    'Шаблонизатор Smarty: за и против',
    'Экранирование вывода и XSS',
    'Пагинация без боли',
    'Сортировка по произвольному полю без SQL-инъекций',
    'Как готовиться к техническому собеседованию',
    'Код-ревью: как давать обратную связь',
    'Чистая архитектура в маленьких проектах',
];

$paragraphs = [
    'На практике эта тема всплывает почти в каждом проекте, но разбирают её редко и обычно поверхностно.',
    'Начнём с простого примера и постепенно доберёмся до случаев, где очевидное решение перестаёт работать.',
    'Главная ошибка здесь — считать, что поведение по умолчанию подходит всем. Оно подходит ровно до первого нагруженного запроса.',
    'Обратите внимание на порядок операций: именно он чаще всего объясняет странные результаты, которые сложно воспроизвести локально.',
    'В продакшене такие вещи лучше закрывать тестами, а не комментариями в коде — комментарий устаревает молча.',
    'Если коротко: сначала измеряем, потом оптимизируем. Обратный порядок почти всегда приводит к лишней сложности.',
];

// Two different titles can slugify to the same string, and `slug` is UNIQUE —
// so keep a set of what we've handed out and suffix duplicates.
$usedSlugs = [];
$uniqueSlug = static function (string $title) use (&$usedSlugs): string {
    $base = Str::slugify($title);
    $slug = $base;
    $n    = 2;

    while (isset($usedSlugs[$slug])) {
        $slug = $base . '-' . $n++;
    }

    $usedSlugs[$slug] = true;

    return $slug;
};

foreach ($titles as $i => $title) {
    $lead = 'Разбираем тему «' . $title . '» на конкретных примерах и без лишней теории.';

    shuffle($paragraphs);
    $body = '<p>' . $paragraphs[0] . '</p>' . "\n"
          . '<h2>Как это работает</h2>' . "\n"
          . '<p>' . $paragraphs[1] . '</p>' . "\n"
          . '<p>' . $paragraphs[2] . '</p>' . "\n"
          . '<h2>Что запомнить</h2>' . "\n"
          . '<p>' . $paragraphs[3] . '</p>';

    // Spread publication dates over the last ~6 months. If everything were
    // NOW(), sorting by date would be indistinguishable from insertion order.
    $publishedAt = (new DateTimeImmutable())
        ->modify('-' . random_int(0, 180) . ' days')
        ->modify('-' . random_int(0, 23) . ' hours')
        ->format('Y-m-d H:i:s');

    // Deliberately uncorrelated with the date, so "по просмотрам" and
    // "по дате" produce visibly different orderings on the category page.
    $views = random_int(0, 5000);

    // 1-2 random categories per article: enough overlap for "похожие статьи"
    // to have something to find.
    $pool = $categoryIds;
    shuffle($pool);
    $assigned = array_slice($pool, 0, random_int(1, 2));

    $articleRepo->create(
        $title,
        $uniqueSlug($title),
        'https://picsum.photos/seed/blog' . ($i + 1) . '/640/360',
        $lead,
        $body,
        $publishedAt,
        $assigned,
        $views
    );
}

$linkCount = (int) $db->query('SELECT COUNT(*) FROM article_category')->fetchColumn();

printf(
    "Done: %d categories, %d articles, %d links.\n",
    count($categoryIds),
    count($titles),
    $linkCount
);
