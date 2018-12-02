<?php

namespace App\Models;

use App\Core\Model;
use App\DB\ActiveRecord\Category as CategoryActiveRecord;

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

    public function getAllCategories()
    {
        $query = $this->queryBuilder->select([
            'c.id',
            'c.name',
            'c.articles_count',
        ])
            ->from('categories_articles', 'c')
            ->orderBy('c.id DESC')
            ->getSQL();

        $this->db->makeQuery($query);
        $categories = [];
        while ($category = $this->db->resultActiveRecord(CategoryActiveRecord::class)) {
            $categories[] = $category;
        }

        return $categories;
    }
}