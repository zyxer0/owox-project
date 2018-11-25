<?php

namespace App\Controllers;

use App\Core\Controller;

class Page404 extends Controller
{
    public function index()
    {
        $this->view->assign('title', '404 Page not found');
        $this->view->assign('description', '404 Page not found');
        $this->view->assign('keywords', '404 Page not found');
        $this->response->setContent($this->view->render('404.tpl'));
    }
}