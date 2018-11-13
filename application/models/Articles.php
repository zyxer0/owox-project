<?php

namespace App\Models;

use App\Core\Config;
use App\Core\Model;
use App\Core\Database;
use App\Paginator\Paginator;
use App\QueryBuilder\Builder;

class Articles extends Model implements ArticlesInterface
{

    private $paginator;

    public function __construct(Database $db, Builder $queryBilder, Config $config)
    {
        parent::__construct($db, $queryBilder, $config);
    }

    public function getArticleByID(int $id)
    {
        $query = $this->queryBilder->select([
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

        echo $query = $this->queryBilder->count('a.id')
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
        $query = $this->queryBilder->select([
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
        $this->paginator = new Paginator($this->db, $this->queryBilder, $this->config->get('articlesPerPage'));

        $query = $this->paginator->getQuery($query);
        $sql = $query->getSQL();
        var_dump($sql);
        // TODO: Implement getArticles() method.
    }
}
