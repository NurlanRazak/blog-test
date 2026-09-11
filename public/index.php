<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Config\Database;

$tables= Database::connection()
    ->query("SHOW TABLES")
    ->fetchAll(\PDO::FETCH_COLUMN);

echo '<pre>';
print_r($tables);
