<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Articles as ArticlesModel;

class Main extends Controller
{
    private $articlesInstance;

    public function index()
    {
        $this->articlesInstance = new ArticlesModel();
        $articles = $this->articlesInstance->getArticlesForMainPage(20);
        $this->view->assign('articles', $articles);
        return $this->view->render('main.tpl');
    }
}