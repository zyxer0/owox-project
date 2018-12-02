<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Articles as ArticlesModel;
use App\Models\Authors as AuthorsModel;
use App\Models\Categories as CategoriesModel;

class Main extends Controller
{
    private $articlesInstance;
    private $authorsInstance;
    private $categoriesInstance;

    public function index()
    {
        $this->articlesInstance = new ArticlesModel();
        $articles = $this->articlesInstance->getArticlesList();
        $this->view->assign('articles', $articles['items']);
        $this->view->assign('pagination', $articles['pagination']);

        $this->view->assign('title', 'Main page php school');
        $this->view->assign('description', 'Main page php school');
        $this->view->assign('keywords', 'Main page php school' );

        $this->response->setContent($this->view->render('main.tpl'));
    }
}