<?php

namespace App\DB;

use App\DB\ActiveRecord\BaseActiveRecord;

abstract class Database
{
    protected static $instance = null;

    /**
     * @return Database
     */
    abstract public static function getInstance($dbHost, $dbUser, $dbPass, $dbName, $dbCharset = 'utf8');

    private function __clone() {}

    /**
     * @param $query
     * @return bool
     */
    abstract public function makeQuery(string $query): bool;

    /**
     * @param string|null $field
     * @return array|bool
     */
    abstract public function results($field = null);

    /**
     * @param null $field
     * @return bool|null|object
     */
    abstract public function result($field = null);

    /**
     * @param $activeRecord
     * @return BaseActiveRecord|boolean
     */
    abstract public function resultActiveRecord($activeRecord);

    /**
     * @return int|string
     */
    abstract public function insertId();
}
