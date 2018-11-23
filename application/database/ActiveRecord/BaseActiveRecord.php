<?php

namespace App\DB\ActiveRecord;

use App\DB\Database;
use App\DB\MySQLFactory;
use App\DB\QueryBuilder\Builder;

abstract class BaseActiveRecord
{
    protected $table;
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

    /**
     * @param $id
     * @return BaseActiveRecord|boolean
     */
    abstract public static function findById($id);

    //abstract public function get();
    abstract public function save();
    abstract public function update();
    abstract public function delete();
}