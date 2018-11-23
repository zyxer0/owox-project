<?php

namespace App\Models;

use App\Core\Model;
use App\Paginator\Paginator;
use App\DB\ActiveRecord\Article as ArticleActiveRecord;

class Articles extends Model
{

    private $paginator;

    public function getArticleByID(int $id)
    {
        $query = $this->queryBuilder->select([
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

        $this->db->makeQuery($query);
        $article = $this->db->resultActiveRecord(ArticleActiveRecord::class);

        return $article;
    }

    public function getArticlesCategoryId($categoryId)
    {
        $this->queryBuilder->select([
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
            ->where('a.category_id='.$categoryId)
            ->orderBy('a.created DESC');

        // Создадим класс пагинатора, который определит ссылки на пагинацию и утановит лимит на выборку
        $this->paginator = new Paginator($this->db, $this->queryBuilder, $this->request);

        $query = $this->paginator->getQuery();
        $sql = $query->getSQL();
        $query->clear();

        $this->db->makeQuery($sql);

        $articles = [];
        while ($article = $this->db->resultActiveRecord(ArticleActiveRecord::class)) {
            $articles[] = $article;
        }

        $result['items'] = $articles;
        $result['pagination'] = $this->paginator->getLinks();
        return $result;
    }

    public function getArticlesForMainPage(int $limit = 20)
    {
        $query = $this->queryBuilder->select([
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
            ->orderBy('a.created DESC')
            ->limit($limit);

        $sql = $query->getSQL();
        $query->clear();

        $this->db->makeQuery($sql);

        $articles = [];
        while ($article = $this->db->resultActiveRecord(ArticleActiveRecord::class)) {
            $articles[] = $article;
        }

        return $articles;
    }
}
