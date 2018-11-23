<?php

//ini_set('display_errors', 'on');
error_reporting(E_ALL);

//echo __FILE__;

require '../vendor/autoload.php';

//use App\QueryBuilder\MySQLBuilder;

//$config = \App\Core\Config::getInstance();
/*
$db = \App\Core\Database::getInstance(
    $config->get('dbHost'),
    $config->get('dbUser'),
    $config->get('dbPass'),
    $config->get('dbName'),
    $config->get('dbCharset')
);
*/

//$request = \App\Http\Request::createFromGlobals();

//print_r($request->getQueryString());
//print_r($request->getBaseUrl());
//print_r($request->query->get('page'));

// TODO replace to factory or abstract factory with DB
//$queryBuilder = new App\QueryBuilder\MySQLBuilder();

$page = new App\Controllers\Main();
print $page->index();
die;

$articlesInstance = new App\Models\Articles();
$articles = $articlesInstance->getArticleByID(1);

$ar = new App\DB\ActiveRecord\Article([
    'name'=>'First from AR'
]);

var_dump($ar);
//$article = $articlesInstance->getArticleByID(1);
/*$articles = $articlesInstance->getArticles();
foreach ($articles['pagination'] as $p) {
    print "<".($p['isLink'] ? "a" : "span")." href='{$p['url']}'>{$p['anchor']}</".($p['isLink'] ? "a" : "span")."><br>";
}*/
//print_r($articles);
//print_r($config);

//$db =


//$articles->getArticleByID(12);

