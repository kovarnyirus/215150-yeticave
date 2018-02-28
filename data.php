<?php
$is_auth = isset($_SESSION['user']) ? true: false;
date_default_timezone_set('Europe/Moscow');
$user_name = isset($_SESSION['user']) ? $_SESSION['user']['name'] : ' ';
$user_avatar = 'img/user.jpg';
$page_title = 'Главная';
$cookie_path = '/';
$cookie_live = strtotime("+30 days");
$cookie_name_id_lot = 'history_lots_id';
$categories = [];
$lots_list = [];


$bets = [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) . ' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) . ' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) . ' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];
