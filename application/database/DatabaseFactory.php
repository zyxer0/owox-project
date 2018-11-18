<?php

namespace App\DB;

use App\DB\QueryBuilder\Builder;

abstract class DatabaseFactory
{
    static $config;

    protected function __construct(){}

    protected function __clone(){}

    /**
     * @return Builder
     */
    abstract public static function createQueryBuilder(): Builder;

    /**
     * @return Database
     */
    abstract public static function createDatabase(): Database;
}