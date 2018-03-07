<?php
require_once('functions.php');
require_once('db_connect.php');
require_once('data.php');
require_once('sql_functions.php');
require_once('vendor/autoload.php');

$categories = sql_get_categories($db_connect);
$date_end_list = [];
$lots_list = [];

if (!$db_connect) {
    $error = mysqli_connect_error();
    $content = render_template('error', ['error' => $error]);
} else {
    $categories = sql_get_categories_class($db_connect);
    $lots_list = sql_get_active_lots($db_connect);
    foreach ($lots_list as $lot){
        array_push($date_end_list, time_end($lot['date_end']));
    }
}

$page_content = render_template('my-lots', [
    'lots_list' => $lots_list,
    'date_end_list' =>$date_end_list,
    'categories' => $categories
]);

$layout_content = render_template('layout', [
    'page_title' => $page_title,
    'user_avatar' => $user_avatar,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'page_content' => $page_content,
    'categories' => $categories
]);
print ($layout_content);
