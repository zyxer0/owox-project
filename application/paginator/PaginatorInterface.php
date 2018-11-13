<?php

namespace App\Paginator;

use App\QueryBuilder\Builder;
use App\Core\Database;

interface PaginatorInterface
{
    public function __construct(Database $db, Builder $queryBilder, int $perPage);

    public function getQuery(): Builder;

    public function getLinks(): array;
}