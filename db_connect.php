<?php
$db = [
    'host' => '127.0.0.1',
    'user' => 'root',
    'password' => '',
    'database' => 'yeticave'
];

$db_connect = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($db_connect, "utf8");

if (!$db_connect) {
    exit('Ошибка подлючения к базе данных: '.mysqli_connect_error());
}
