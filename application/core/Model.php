<?php

namespace App\Core;

use App\QueryBuilder\Builder;

class Model
{

    protected $db;
    protected $queryBilder;
    protected $config;

    public function __construct(Database $db, Builder $queryBilder, Config $config)
    {
        $this->db = $db;
        $this->queryBilder = $queryBilder;
        $this->config = $config;
    }
}