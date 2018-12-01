<?php

namespace App\DB\ActiveRecord;

use App\DB\Database;
use App\DB\MySQLFactory;
use App\DB\QueryBuilder\Builder;

abstract class BaseActiveRecord
{
    /**
     * @var Builder
     */
    protected static $queryBuilder;
    /**
     * @var Database
     */
    protected static $db;

    public function __construct()
    {
        self::initialize();
    }

    protected static function initialize()
    {
        self::$queryBuilder = MySQLFactory::createQueryBuilder();
        self::$db           = MySQLFactory::createDatabase();
    }

    // todo Может реализацию перенести сюда
    abstract public function save();
    abstract public function update();
    abstract public function delete();
}