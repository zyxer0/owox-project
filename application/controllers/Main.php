<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Articles as ArticlesModel;
use App\Models\Authors as AuthorsModel;

class Main extends Controller
{
    private $articlesInstance;
    private $authorsInstance;

    public function index()
    {
        $this->articlesInstance = new ArticlesModel();
        $articles = $this->articlesInstance->getArticlesForMainPage(12);
        $this->view->assign('articles', $articles);

        $this->authorsInstance = new AuthorsModel();
        $authors = $this->authorsInstance->getAllAuthors();
        $this->view->assign('authors', $authors);

        $this->view->assign('title', 'Main page php school');
        $this->view->assign('description', 'Main page php school');
        $this->view->assign('keywords', 'Main page php school' );

        $this->response->setContent($this->view->render('main.tpl'));
    }
}