<?php

//ini_set('display_errors', 'on');
error_reporting(E_ALL);

//echo __FILE__;

require '../vendor/autoload.php';

use App\QueryBuilder\MySQLBuilder;

$config = \App\Core\Config::getInstance();

$db = \App\Core\Database::getInstance(
    $config->get('dbHost'),
    $config->get('dbUser'),
    $config->get('dbPass'),
    $config->get('dbName'),
    $config->get('dbCharset')
);

// TODO replace to factory or abstract factory with DB
//$queryBilder = new App\QueryBuilder\MySQLBuilder();

$articlesInstance = new App\Models\Articles($db, new MySQLBuilder(), $config);

//$article = $articlesInstance->getArticleByID(1);
$articles = $articlesInstance->getArticles();
print_r($articles);
//print_r($config);

//$db =


//$articles->getArticleByID(12);

