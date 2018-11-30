<?php

namespace App\Core;

use App\Http\Request;
use App\Http\Response;
use App\Models\Articles as ArticlesModel;

class Controller
{
    /**
     * @var View
     */
    protected $view;
    /**
     * @var ArticlesModel
     */
    protected $articlesModel;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Config
     */
    protected $config;

    public function __construct()
    {
        $this->view = new View();
        $this->request = Request::getInstance();
        $this->response = Response::getInstance();
        $this->config = Config::getInstance();
        $this->articlesModel = new ArticlesModel();
    }
}