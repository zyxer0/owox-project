<?php

namespace App\DB;

use App\Core\Config;
use App\DB\QueryBuilder\Builder;
use App\DB\QueryBuilder\MySQLBuilder;

class MySQLFactory extends DatabaseFactory
{
    protected function __construct()
    {
        self::$config = Config::getInstance();
        parent::__construct();
    }

    public static function createQueryBuilder(): Builder
    {
        return new MySQLBuilder();
    }

    public static function createDatabase(): Database
    {
        self::$config = Config::getInstance();

        return MySQL::getInstance(
            self::$config->get('dbHost'),
            self::$config->get('dbUser'),
            self::$config->get('dbPass'),
            self::$config->get('dbName'),
            self::$config->get('dbCharset')
        );
    }
}