<?php
require_once('functions.php');
require_once('db_connect.php');
require_once ('data.php');

$history_lot = [];
$date_end_list = [];
$category_sql = 'SELECT `id`, `category_name` FROM categories';
$categories = get_sql($db_connect, $category_sql);

if (isset($_COOKIE[$cookie_name_id_lot])){
    $history_lots_id = json_decode($_COOKIE[$cookie_name_id_lot]);
    foreach ($history_lots_id as $key => $value){

        $lot_sql = "SELECT lots.id, lots.name, `description`, `step`, `date_end`, `initial_price`, `lot_img`, users.id as user_id, categories.category_name FROM lots inner join categories on fk_category_id = categories.id LEFT join users on fk_user_id = users.id WHERE lots.id = $value";
        $lot_arr = get_sql($db_connect, $lot_sql);
        $lot = sub_array($lot_arr);
        array_push ($history_lot, $lot);
        array_push($date_end_list, time_end($lot['date_end']));
    }
};


$page_content = render_template('history', ['history_lot' => $history_lot,
    'date_end_list' => $date_end_list]);
$layout_content = render_template('layout', [
    'page_title' => 'История просмотров',
    'user_avatar' => $user_avatar,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'page_content' => $page_content,
    'categories' => $categories
]);
print ($layout_content);
