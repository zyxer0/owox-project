<?php

namespace App\DB;

class MySQL extends Database
{
    private $dbc;
    private $queryResult;

    /**
     * @return Database
     */
    public static function getInstance($dbHost, $dbUser, $dbPass, $dbName, $dbCharset = 'utf8')
    {
        if (null === self::$instance)
        {
            self::$instance = new self($dbHost, $dbUser, $dbPass, $dbName, $dbCharset);
        }
        return self::$instance;
    }

    private function __construct($dbHost, $dbUser, $dbPass, $dbName, $dbCharset)
    {
        $this->dbc = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
        if (!$this->dbc) {
            die();
        }
        mysqli_set_charset($this->dbc, $dbCharset);
    }
    function __destruct(){
        mysqli_close($this->dbc);
    }

    public function makeQuery(string $query): bool
    {
        $this->queryResult = mysqli_query($this->dbc, $query);
        if ($this->queryResult) {
            return true;
        }
        return false;
    }

    public function results($field = null)
    {

        if(!$this->queryResult){
            return false;
        }

        $results = array();
        while($row = mysqli_fetch_object($this->queryResult)){
            if($field){
                $results[] = $row->$field;
            } else {
                $results[] = $row;
            }

        }
        return $results;
    }

    public function result($field = null)
    {

        if(!$this->queryResult){
            return false;
        }

        $row = mysqli_fetch_object($this->queryResult);
        if($row){
            if($field){
                return $row->$field;
            }

            return $row;
        }
        return false;
    }

    public function insert_id()
    {
        return mysqli_insert_id($this->dbc);
    }
}
