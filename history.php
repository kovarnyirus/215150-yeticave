<?php
require_once('functions.php');
require_once('db_connect.php');
require_once('data.php');
require_once('sql_functions.php');
require_once('vendor/autoload.php');

$history_lot = [];
$date_end_list = [];

$categories = sql_get_categories($db_connect);

if (isset($_COOKIE[$cookie_name_id_lot])){
    $history_lots_id = json_decode($_COOKIE[$cookie_name_id_lot]);
    foreach ($history_lots_id as $key => $value){
        $lot_arr = sql_get_lot($db_connect, [$value]);
        $lot = sub_array($lot_arr);
        array_push ($history_lot, $lot);
        array_push($date_end_list, time_end($lot['date_end']));
    }
};


$page_content = render_template('history', [
    'history_lot' => $history_lot,
    'date_end_list' => $date_end_list,
    'categories' => $categories
]);
$layout_content = render_template('layout', [
    'page_title' => 'История просмотров',
    'user_avatar' => $user_avatar,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'page_content' => $page_content,
    'categories' => $categories
]);
print ($layout_content);
