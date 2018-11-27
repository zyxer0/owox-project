<?php

namespace App\DB\ActiveRecord;

class Category extends BaseActiveRecord
{
    public $id;
    public $name;
    public $articles_count;

    public function __construct($values = [])
    {
        $this->id               = isset($values['id']) ? $values['id'] : null;
        $this->name             = isset($values['name']) ? $values['name'] : '';
        $this->articles_count   = isset($values['articles_count']) ? $values['articles_count'] : 0;
        parent::__construct();
    }

    public function save()
    {
        $sql = self::$queryBuilder->insert('categories_articles')->set($this)->getSQL();
        self::$db->makeQuery($sql);
        $this->id = self::$db->insertId();
    }

    public function update()
    {
        $sql = self::$queryBuilder->update('categories_articles')
            ->set($this)
            ->where('id='.$this->id)
            ->limit(1)
            ->getSQL();
        self::$db->makeQuery($sql);
    }

    public function delete()
    {
        $sql = self::$queryBuilder->delete('categories_articles')
            ->where('id='.$this->id)
            ->limit(1)
            ->getSQL();
        self::$db->makeQuery($sql);
    }
}
