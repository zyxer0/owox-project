<?php

namespace App\Paginator;

use App\QueryBuilder\Builder;
use App\Core\Database;

class Paginator implements PaginatorInterface
{

    private $currentPage;
    private $db;
    private $perPage;
    private $queryBuilder;
    private $entitiesCount;

    public function __construct(Database $db, Builder $queryBuilder, int $perPage)
    {
        $this->currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $this->perPage = $perPage;
        $this->db = $db;
        $this->queryBuilder = $queryBuilder;

        $query = $this->queryBuilder->count()->getSQL();
        $this->db->makeQuery($query);
        $this->entitiesCount = $this->db->result('count');
    }

    public function getQuery(): Builder
    {
        $start = ($this->currentPage-1)*$this->perPage;
        $this->queryBuilder->limit($start, $this->perPage);
        return $this->queryBuilder;
    }

    public function getLinks(): array
    {
        // TODO: Implement getLinks() method.
    }
}
