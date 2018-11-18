<?php

namespace App\DB;

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
     * @return int|string
     */
    public function insert_id()
    {
        return mysqli_insert_id($this->dbc);
    }
}
