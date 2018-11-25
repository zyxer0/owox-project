<?php

namespace App\Core;

use App\Http\Response;

class Controller
{
    /**
     * @var View
     */
    protected $view;

    /**
     * @var Response
     */
    protected $response;

    public function __construct()
    {
        $this->view = new View();
        $this->response = Response::getInstance();
    }
}