<?php

use App\Benchmark\Timer;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

Timer::start();
$memory = memory_get_usage();
// === Start app code

/**=================
 * MySQLConnection
 ==================*/
//use Framework\MySQLConnection;
//use Framework\Query;
//
//$connector = new Query(new MySQLConnection());
//==== Страны Азии
//$continent = 'Asia';
//$query = "SELECT `code`, `name`, `continent` FROM `country` WHERE `continent` = ?";
//$data = $connector->getRowsAsArray($query, [$continent]);
//debug($data);

// ==== Страна по её коду
//$code = 'AFG';
//$query = "SELECT * FROM `country` WHERE `code` = ? LIMIT 1";
//$data = $connector->getRowAsArray($query, [$code]);
//debug($data);
//echo '<hr>';
//
//// === Страны Азии с численностью населения более 1000000000 человек
//$continent = 'Asia';
//$population = 100000000;
//$query = "SELECT `code`, `name`, `continent` FROM `country` WHERE `continent` = ? AND `population` > ?";
//$data = $connector->getRowsAsObject($query, \App\Country::class, [$continent, $population]);
//
//foreach ($data as $item):
//    /* @var $item \App\Country */
//    echo $item->getName().'<br>';
//endforeach;


/**==================
 * SQLiteConnection
 ==================*/
use Framework\MySQLConnection;
use Framework\Query;

$connector = new Query(new \Framework\SQLiteConnection());



//$query = 'SELECT * FROM `category`';
//$categories = $connector->getRowsAsObject($query, \App\Category::class);

$query = 'SELECT * FROM `post`';
//$posts = $connector->getRowsAsObject($query, \App\Post::class);
$posts = $connector->getRowsAsArray($query);


debug($posts);


// === End app code
echo '<div style="border: 1px solid #DDD;padding: 5px;margin-top: 50px">';
$memory = memory_get_usage() - $memory;
$name = array('байт', 'КБ', 'МБ');
$i = 0;
while (floor($memory / 1024) > 0) {
    $i++;
    $memory /= 1024;
}
echo 'Время выполнения скрипта: ' . Timer::finish() . ' sec.<br>';
echo 'Скушано памяти: ' . round($memory, 2) . ' ' . $name[$i]. '<br>';
echo 'Запросов к БД: ' . Query::$countQuery;
echo '</div>';