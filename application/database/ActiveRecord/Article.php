<?php

namespace App\DB\ActiveRecord;

class Article extends BaseActiveRecord
{
    public $id;
    public $category_id;
    public $author_id;
    public $name;
    public $url;
    public $text;
    public $image;
    public $created;
    public $views_count;

    public function __construct($values = [])
    {
        $this->id           = isset($values['id']) ? $values['id'] : null;
        $this->category_id  = isset($values['category_id']) ? $values['category_id'] : 0;
        $this->author_id    = isset($values['author_id']) ? $values['author_id'] : 0;
        $this->name         = isset($values['name']) ? $values['name'] : '';
        $this->url          = isset($values['url']) ? $values['url'] : '';
        $this->text         = isset($values['text']) ? $values['text'] : '';
        $this->image        = isset($values['image']) ? $values['image'] : '';
        $this->created      = isset($values['created']) ? $values['created'] : null;
        $this->views_count  = isset($values['views_count']) ? $values['views_count'] : 0;
        parent::__construct();
    }

    public function save()
    {
        $sql = self::$queryBuilder->insert('articles')->set($this)->getSQL();
        self::$db->makeQuery($sql);
        $this->id = self::$db->insertId();
    }

    public function update()
    {
        $sql = self::$queryBuilder->update('articles')
            ->set($this)
            ->where('id='.$this->id)
            ->limit(1)
            ->getSQL();
        self::$db->makeQuery($sql);
    }

    public function delete()
    {
        $sql = self::$queryBuilder->delete('articles')
            ->where('id='.$this->id)
            ->limit(1)
            ->getSQL();
        self::$db->makeQuery($sql);
    }
}