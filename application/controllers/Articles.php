<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Articles as ArticlesModel;

class Articles extends Controller
{
    public function showArticles()
    {
        $articlesInstance = new ArticlesModel();
        $articles = $articlesInstance->getArticles();
    }
}
