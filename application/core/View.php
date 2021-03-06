<?php

namespace App\Core;

use Smarty;
use App\Http\Request;

class View
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Smarty
     */
    private $smarty;

    /**
     * @var Request
     */
    public $request;

    public $wrapper = 'index.tpl';

    public function __construct()
    {
        $this->config = Config::getInstance();
        $this->request = Request::getInstance();
        $this->smarty = new Smarty();
        $this->smarty->compile_check = true;
        $this->smarty->error_reporting = E_ALL & ~E_NOTICE;
        $this->smarty->setCompileDir($this->config->get('rootDir') . 'compiled');
        $this->smarty->setTemplateDir($this->config->get('rootDir') . 'application/view');

        // Создаем папку для скомпилированных шаблонов
        if(!is_dir($this->smarty->getCompileDir())) {
            mkdir($this->smarty->getCompileDir(), 0777);
        }
        $this->assign('request', $this->request);
        $this->assign('config',  $this->config);
    }

    /**
     * @param string $dir
     */
    public function setCompileDir(string $dir)
    {
        $this->smarty->setCompileDir($dir);
    }

    /**
     * @param string $dir
     */
    public function setTemplateDir(string $dir)
    {
        $this->smarty->setTemplateDir($dir);
    }

    /**
     * @param $template
     * @return string
     * @throws \SmartyException
     */
    public function render($template)
    {
        if ($this->wrapper !== null && $this->wrapper !== false) {
            $this->assign('content', $this->smarty->fetch($template));
            return $this->smarty->fetch('index.tpl');
        } else {
            return $this->smarty->fetch($template);
        }

    }

    /**
     * @param $var variable name
     * @param $value
     * @return \Smarty_Internal_Data
     */
    public function assign($var, $value) {
        return $this->smarty->assign($var, $value);
    }
}