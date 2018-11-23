<?php

namespace App\DB\ActiveRecord;

use App\DB\MySQLFactory;

abstract class BaseActiveRecord
{
    protected $table;
    protected static $queryBuilder;
    protected static $db;

    public function __construct()
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