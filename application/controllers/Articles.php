<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Router;
use App\Models\Articles as ArticlesModel;
use App\Models\Authors;
use App\Models\Categories;

class Articles extends Controller
{
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

        if ($article->author_id > 0) {
            $authorsInstance = new Authors();
            $author = $authorsInstance->getAuthorById($article->author_id);
            $this->view->assign('author', $author);
        }
        if ($article->category_id > 0) {
            $categoriesInstance = new Categories();
            $category = $categoriesInstance->getCategoryBuId($article->category_id);
            $this->view->assign('category', $category);
        }

        // TODO get author and other

        $this->view->assign('title', $article->name);
        $this->view->assign('description', $article->name);
        $this->view->assign('keywords', $article->name);
        $this->view->assign('article', $article);
        $this->response->setContent($this->view->render('article.tpl'));
    }

    public function ajaxDatePublishers($params = [])
    {
        $this->view->wrapper = false;
        $articlesInstance = new ArticlesModel();
        $articlesDates = $articlesInstance->getArticlesDates();
        $this->view->assign('articlesDates', $articlesDates);
        $this->response->headers->set('Content-type', 'application/json; charset=UTF-8');
        $content = json_encode($this->view->render('dates_publishers_sidebar.tpl'));
        $this->response->setContent($content);
    }
}
