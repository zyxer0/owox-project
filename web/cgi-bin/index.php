<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

$backendName = $_SERVER['BACKEND_NAME'];

/*Проверяем, что корректно подгружается наш класс*/
$template = new \PHPSchool\Template('main');
echo $template->parse(['name' => $backendName]);