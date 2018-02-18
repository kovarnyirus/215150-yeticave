<?php
require_once('functions.php');
require_once ('data.php');

$history_lot = [];

if (isset($_COOKIE[$cookie_name_id_lot])){
    $history_lots_id = json_decode($_COOKIE[$cookie_name_id_lot]);
    foreach ($history_lots_id as $key => $value){
        array_push ($history_lot, $lots_list[$value]);
    }
};

$page_content = render_template('history', ['history_lot' => $history_lot ,
    'bets' => $bets]);
$layout_content = render_template('layout', [
    'page_title' => 'История просмотров',
    'user_avatar' => $user_avatar,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'page_content' => $page_content,
    'categories' => $categories
]);
print ($layout_content);
