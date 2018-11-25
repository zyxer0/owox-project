<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Router;
use App\Models\Articles as ArticlesModel;

class Articles extends Controller
{
    public function showArticle($params = [])
    {
        $articlesInstance = new ArticlesModel();
        if (!$article = $articlesInstance->getArticleByID((int)$params['id'])) {
            Router::page404();
        }

        //Увеличим просмотры
        $article->views_count++;
        $article->update(); // todo Не увеличивать когда обновляется страница

        // TODO get author and other
        return $article;
    }
}
