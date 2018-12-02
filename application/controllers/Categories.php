<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Categories as CategoriesModel;

class Categories extends Controller
{
    public function ajaxShowCategories($params = [])
    {
        $this->view->wrapper = false;
        $categoriesInstance = new CategoriesModel();
        $categories = $categoriesInstance->getAllCategories('articles_count');
        $this->view->assign('categories', $categories);
        $this->response->headers->set('Content-type', 'application/json; charset=UTF-8');
        $content = json_encode($this->view->render('categories_sidebar.tpl'));
        $this->response->setContent($content);
    }
}
