<?php

namespace App\Models;

use App\Core\Model;
use App\DB\ActiveRecord\Category as CategoryActiveRecord;
use function Couchbase\defaultDecoder;

class Categories extends Model
{
    public function getCategoryBuId(int $id)
    {
        $query = $this->queryBuilder->select([
            'c.id',
            'c.name',
            'c.articles_count',
        ])
            ->from('categories_articles', 'c')
            ->orderBy('c.id DESC')
            ->where('c.id='.$id)
            ->getSQL();

        $this->db->makeQuery($query);
        return $this->db->resultActiveRecord(CategoryActiveRecord::class);
    }

    public function getAllCategories($order = null)
    {
        $query = $this->queryBuilder->select([
            'c.id',
            'c.name',
            'c.articles_count',
        ])
            ->from('categories_articles', 'c');

        if (null !== $order) {
            switch ($order) {
                case 'articles_count':
                    $query->orderBy('c.articles_count DESC');
                    break;
                default:
                    $query->orderBy('c.id DESC');
                    break;
            }
        }

        $this->db->makeQuery($query->getSQL());
        $categories = [];
        while ($category = $this->db->resultActiveRecord(CategoryActiveRecord::class)) {
            $categories[] = $category;
        }

        return $categories;
    }
}