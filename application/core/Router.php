<?php

namespace App\Core;

use App\Http\Request;

class Router
{
    /**
     * @var Request
     */
    private static $request;
    private static $routes;
    private static $currentRoute;
    private static $httpMethod;

    public static function run()
    {
        self::$request = Request::getInstance();
        self::$httpMethod = strtoupper(self::$request->server->get('REQUEST_METHOD', 'GET'));
        self::$routes = ['GET' => [
            '' => [
                'controller' => \App\Controllers\Main::class,
                'method'     => 'index',
            ],
            'article\/([0-9]+)' => [
                'controller' => \App\Controllers\Articles::class,
                'method'     => 'showArticle',
                'params'     => [
                    'id',
                ]
            ],
        ],
        'POST' => [

        ]];

        $path = self::$request->getPathInfo();
        $path = trim($path, '/');

        self::$currentRoute = null;

        // Проверяем роуты для текущего HTTP метода запроса
        foreach (self::$routes[self::$httpMethod] as $route=>$routeParams) {
            if (preg_match('/^'.$route.'$/i', $path, $matches)) {
                if (!empty($matches) && isset($routeParams['params'])) {
                    unset($matches[0]);
                    $matches = array_values($matches);
                    foreach ($matches as $k=>$varValue) {
                        if (isset($routeParams['params'][$k])) {
                            $varName = $routeParams['params'][$k];
                            $routeParams['variables'][$varName] = $varValue;
                        }
                    }
                }
                if (!isset($routeParams['variables'])) {
                    $routeParams['variables'] = [];
                }
                self::$currentRoute = $routeParams;
                break;
            }
        }

        if (null === self::$currentRoute) {
            self::page404();
        } else {
            $class  = self::$currentRoute['controller'];
            $method = self::$currentRoute['method'];
            // Проверяем есть ли такой контроллер
            if (!class_exists($class)) {
                self::page404();
            }
            // Создаем экземпляр скасса контроллера
            $controller = new $class();
            // Проверяем есть ли такой метод
            if (!method_exists($controller, $method)) {
                self::page404();
            }
            // Вызываем метод контроллера с передачей параметров
            $controller->{$method}(self::$currentRoute['variables']);
        }
    }

    public static function page404()
    {
        echo 404;// TODO 404 page
        exit;
    }
}
