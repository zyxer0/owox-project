<?php

namespace App\Models;

use App\Core\Model;
use App\Paginator\Paginator;

class Articles extends Model implements ArticlesInterface
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

        echo $query = $this->queryBuilder->count('a.id')
            ->from('articles', 'a')
            ->where('a.id='.$id)
            ->limit(1)
            ->getSQL();

        $this->db->makeQuery($query);
        if (!$article = $this->db->result()) {
            return false;
        }

        return $article;
    }

    public function getArticles()
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
            ->from('articles', 'a');

        // Создадим класс пагинатора, который определит ссылки на пагинацию и утановит лимит на выборку
        $this->paginator = new Paginator($this->db, $this->queryBuilder, $this->request);

        $query = $this->paginator->getQuery($query);
        $sql = $query->getSQL();
        $query->clear();

        $this->db->makeQuery($sql);
        if (!$articles = $this->db->results()) {
            return false;
        }

        $result['items'] = $articles;
        $result['pagination'] = $this->paginator->getLinks();
        return $result;
    }
}
