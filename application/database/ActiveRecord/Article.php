<?php

namespace App\DB\ActiveRecord;

use App\DB\MySQLFactory;

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
        $this->category_id  = isset($values['category_id']) ? $values['category_id'] : null;
        $this->author_id    = isset($values['author_id']) ? $values['author_id'] : null;
        $this->name         = isset($values['name']) ? $values['name'] : '';
        $this->url          = isset($values['url']) ? $values['url'] : '';
        $this->text         = isset($values['text']) ? $values['text'] : '';
        $this->image        = isset($values['image']) ? $values['image'] : '';
        $this->created      = isset($values['created']) ? $values['created'] : null;
        $this->views_count  = isset($values['views_count']) ? $values['id'] : 0;
        parent::__construct();
    }

    public static function findById($id) {
        $queryBuilder = MySQLFactory::createQueryBuilder();
        $db           = MySQLFactory::createDatabase();
        $query = $queryBuilder->select([
            'a.id',
            'a.category_id',
            'a.author_id',
            'a.name',
            'a.url',
            'a.text',
            'a.image',
            'a.created',
            'a.views_count',
        ])
            ->from('articles', 'a')
            ->where('a.id='.$id)
            ->limit(1)
            ->getSQL();

        $db->makeQuery($query);
        return $db->resultActiveRecord(self::class);
    }

    public function save()
    {
        // TODO: Implement save() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}