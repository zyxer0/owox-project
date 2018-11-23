<?php

namespace App\Core;


class Controller
{
    /**
     * @var View
     */
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }
}