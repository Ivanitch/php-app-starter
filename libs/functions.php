<?php

if (!function_exists ('debug')) {
    function debug($arr, $die = false){
        echo '<pre>' . print_r($arr, true) . '</pre>';
        if($die) die;
    }
}

if (!function_exists ('h')) {
    function h($str){
        return htmlspecialchars(trim($str), ENT_QUOTES);
    }
}

// Функция, которая выполняет все нужные действия для получения нужной ссылки
function url_origin($s, $use_forwarded_host = false){
    $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true : false;
    $sp = strtolower($s['SERVER_PROTOCOL']);
    $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
    $port = $s['SERVER_PORT'];
    $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
    $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
    $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
    return $protocol . '://' . $host;
}

// Функция для получения полной ссылки сайта
function full_url($s, $use_forwarded_host=false)
{
    return url_origin($s, $use_forwarded_host) . $s['REQUEST_URI'];
}

// Используем функция full_url() и пускает туда массив $_SERVER, чтобы получить значение текущей ссылки сайта.
//$absolute_url = full_url($_SERVER);
