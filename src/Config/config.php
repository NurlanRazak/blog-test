<?php

declare(strict_types=1);

return (function (): array {
    $defaults = [
        'DB_HOST' => '127.0.0.1',
        'DB_PORT' => '3306',
        'DB_NAME' => 'simple_blog',
        'DB_USER' => 'root',
        'DB_PASS' => '',
        'APP_URL' => 'http://localhost:8080',
        'ARTICLES_PER_PAGE' => '6',
    ];

    $envFile = dirname(__DIR__, 2) . '/.env';

    if (is_readable($envFile)) {
        foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }
            [$key, $value] = array_map('trim', explode('=', $line, 2));
            $defaults[$key] = trim($value, "\"'");
        }
    }


    foreach (array_keys($defaults) as $key) {
        $envValue = getenv($key);
        if ($envValue !== false) {
            $defaults[$key] = $envValue;
        }
    }

    return $defaults;
})();