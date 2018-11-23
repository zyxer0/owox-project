<?php

namespace App\Core;

use App\DB\MySQLFactory;
use App\Http\Request;

class Model
{

    protected $db;
    protected $queryBuilder;
    protected $config;
    protected $request;

    public function __construct()
    {
        $this->config       = Config::getInstance();
        $this->request      = Request::getInstance();
        $this->queryBuilder = MySQLFactory::createQueryBuilder();
        $this->db           = MySQLFactory::createDatabase();
    }
}