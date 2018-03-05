<?php
require_once('functions.php');
require_once('data.php');
require_once('db_connect.php');
require_once ('sql_functions.php');
require_once('vendor/autoload.php');

$_SESSION =[];
$date_end_list = [];
$categories = sql_get_categories_class($db_connect);
$lots_list = sql_get_active_lots($db_connect);

foreach ($lots_list as $lot){
    array_push($date_end_list, time_end($lot['date_end']));
}

$page_content = render_template('index', [
    'lots_list' => $lots_list,
    'date_end_list' => $date_end_list,
    'categories' => $categories ]);
$layout_content = render_template('layout', [
    'page_title' => 'Добавить лот',
    'user_avatar' => $user_avatar,
    'user_name' => $user_name,
    'is_auth' => false,
    'page_content' => $page_content,
    'categories' => $categories
]);
print ($layout_content);
