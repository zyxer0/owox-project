<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Authors as AuthorsModel;

class Authors extends Controller
{
    public function ajaxListArticles($params = [])
    {
        $this->view->wrapper = false;
        $authorsInstance = new AuthorsModel();
        $authors = $authorsInstance->getAllAuthors();
        $this->view->assign('authors', $authors);
        $this->response->headers->set('Content-type', 'application/json; charset=UTF-8');
        $content = json_encode($this->view->render('authors_sidebar.tpl'));
        $this->response->setContent($content);
    }
}
