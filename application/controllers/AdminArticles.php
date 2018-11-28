<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Router;
use App\Models\Articles as ArticlesModel;

class AdminArticles extends Controller
{
    public function showArticlesList($params = [])
    {
        $articlesInstance = new ArticlesModel();
        $articles = $articlesInstance->getArticlesList();

        // TODO get author and other

        $this->view->assign('title', 'Admin articles');
        $this->view->assign('description', 'Admin articles');
        $this->view->assign('keywords', 'Admin articles');
        $this->view->assign('articles', $articles['items']);
        $this->view->assign('pagination', $articles['pagination']);
        $this->response->setContent($this->view->render('admin.articles.tpl'));
    }

    public function showArticle($params = [])
    {
        $articlesInstance = new ArticlesModel();
        if (!$article = $articlesInstance->getArticleByID((int)$params['id'])) {
            Router::page404();
            exit;
        }

        //Увеличим просмотры
        $article->views_count++;
        $article->update(); // todo Не увеличивать когда обновляется страница

        // TODO get author and other

        $this->view->assign('title', $article->name);
        $this->view->assign('description', $article->name);
        $this->view->assign('keywords', $article->name);
        $this->view->assign('article', $article);
        $this->response->setContent($this->view->render('article.tpl'));
    }
}
