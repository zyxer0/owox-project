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

        $this->view->assign('title', 'Main page php school');
        $this->view->assign('description', 'Main page php school');
        $this->view->assign('keywords', 'Main page php school' );

        $this->response->setContent($this->view->render('main.tpl'));
    }
}