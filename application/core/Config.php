<?php

namespace App\Core;

class Config
{
    private static $instance = null;
    private $vars;

    /**
     * @return Config
     */
    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get($var)
    {
        return $this->vars[$var];
    }

    private function __clone() {}
    private function __construct() {
        // Определяем корневую директорию приложения
        $this->vars['rootDir'] =  dirname(dirname(__DIR__)).'/';

        $ini = parse_ini_file($this->vars['rootDir'].'config/config.ini');
        foreach($ini as $var=>$value) {
            $this->vars[$var] = $value;
        }


    }
}