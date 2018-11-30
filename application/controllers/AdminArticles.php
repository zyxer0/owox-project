<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Router;
use App\DB\ActiveRecord\Article;
use App\Models\Authors;

class AdminArticles extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->setCompileDir($this->config->get('rootDir') . 'compiled/admin');
        $this->view->setTemplateDir($this->config->get('rootDir') . 'application/view/admin');
    }

    /**
     * Просмотр списка стетей
     * method GET
     */
    public function showArticlesList($params = [])
    {
        $articles = $this->articlesModel->getArticlesList();

        // TODO get author and other

        $this->view->assign('title', 'Admin articles');
        $this->view->assign('description', 'Admin articles');
        $this->view->assign('keywords', 'Admin articles');
        $this->view->assign('articles', $articles['items']);
        $this->view->assign('pagination', $articles['pagination']);
        $this->response->setContent($this->view->render('articles.tpl'));
    }

    public function showArticle($params = [])
    {
        if (!$article = $this->articlesModel->getArticleByID((int)$params['id'])) {
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

    /**
     * Создание пустой формы добавления статьи
     * method GET
     */
    public function prepareAddArticle($params = [])
    {
        // TODO Service Locator
        $authorsInstance = new Authors();
        $authors = $authorsInstance->getAllAuthors();

        $this->view->assign('title', 'New article');
        $this->view->assign('authors', $authors);
        $this->response->setContent($this->view->render('add_article.tpl'));
    }

    /**
     * Добавления статьи
     * method POST
     */
    public function addArticle($params = [])
    {
        $article = new Article($this->request->request->all());
        //Увеличим просмотры
        $article->views_count = 0;
        $article->save();

        $this->response->headers->set('Location', '/admin/article/edit/' . $article->id);
    }

    /**
     * Удаление статьи
     * method POST
     */
    public function removeArticle($params = [])
    {
        $ids = $this->request->request->get('id');
        foreach ($ids as $id) {
            $article = $this->articlesModel->getArticleByID($id);
            $article->delete();
        }

        $this->response->headers->set('Location', '/admin/articles');
    }
}
