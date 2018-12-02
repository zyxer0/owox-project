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
        $articlesDates = $this->articlesInstance->getArticlesDates();
        $this->view->assign('articlesDates', $articlesDates);
        $this->view->assign('articles', $articles['items']);
        $this->view->assign('pagination', $articles['pagination']);

        $this->authorsInstance = new AuthorsModel();
        $authors = $this->authorsInstance->getAllAuthors();
        $this->view->assign('authors', $authors);

        $this->categoriesInstance = new CategoriesModel();
        $categories = $this->categoriesInstance->getAllCategories('articles_count');
        $this->view->assign('categories', $categories);

        $this->view->assign('title', 'Main page php school');
        $this->view->assign('description', 'Main page php school');
        $this->view->assign('keywords', 'Main page php school' );

        $this->response->setContent($this->view->render('main.tpl'));
    }
}