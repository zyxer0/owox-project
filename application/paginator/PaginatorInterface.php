<?php

namespace App\Paginator;

use App\DB\QueryBuilder\Builder;
use App\DB\Database;
use App\Http\Request;

interface PaginatorInterface
{
    public function __construct(Database $db, Builder $queryBuilder, Request $request);

    public function getQuery(): Builder;

    public function getLinks(): array;
}