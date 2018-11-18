<?php

namespace App\Models;

use App\Core\Database;
use App\QueryBuilder\Builder;

interface ArticlesInterface
{
    public function getArticleByID(int $id);

    // TODO оформить интерфейс
    //public function getArticles(int $page, int $limit);
}