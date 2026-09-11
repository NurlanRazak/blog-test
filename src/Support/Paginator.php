<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Чистый пагинатор, базовые методы для пагинации
 */
final class Paginator
{
    public readonly int $totalPages;

    public function __construct(
        public readonly int $currentPage,
        public readonly int $perPage,
        public readonly int $totalItems
    ) {
        $this->totalPages = max(1, (int) ceil($totalItems / max(1, $perPage)));
    }

    public function offset(): int
    {
        return ($this->currentPage - 1) * $this->perPage;
    }

    public function hasPrev(): bool
    {
        return $this->currentPage > 1;
    }

    public function hasNext(): bool
    {
        return $this->currentPage < $this->totalPages;
    }

    /** @return int[] */
    public function pageRange(): array
    {
        return range(1, $this->totalPages);
    }
}