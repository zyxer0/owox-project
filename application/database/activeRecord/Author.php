<?php

namespace App\DB\ActiveRecord;

class Author extends BaseActiveRecord
{
    public $id;
    public $first_name;
    public $last_name;

    public function __construct($values = [])
    {
        $this->id           = isset($values['id']) ? $values['id'] : null;
        $this->first_name   = isset($values['first_name']) ? $values['first_name'] : '';
        $this->last_name    = isset($values['last_name']) ? $values['last_name'] : '';
        parent::__construct();
    }

    public function save()
    {
        $sql = self::$queryBuilder->insert('authors')->set($this)->getSQL();
        self::$db->makeQuery($sql);
        $this->id = self::$db->insertId();
    }

    public function update()
    {
        $sql = self::$queryBuilder->update('authors')
            ->set($this)
            ->where('id='.$this->id)
            ->limit(1)
            ->getSQL();
        self::$db->makeQuery($sql);
    }

    public function delete()
    {
        $sql = self::$queryBuilder->delete('authors')
            ->where('id='.$this->id)
            ->limit(1)
            ->getSQL();
        self::$db->makeQuery($sql);
    }
}
