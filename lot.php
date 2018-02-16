<?php
require_once('functions.php');
require_once ('data.php');

$lot = null;


if (isset($_GET['id'])){
    $id = $_GET['id'];
    foreach ($lots_list as $key => $item) {
        if ($key == $id){
            $lot = $item;
            break;
        }
    }
    if (isset($_COOKIE['$history_lots_id'])) {
        if (!in_array($id, json_decode($_COOKIE['$history_lots_id']))) {
            $history_lots_id = json_decode($_COOKIE['$history_lots_id']);
            array_push($history_lots_id, $id);
            setcookie('$history_lots_id', json_encode($history_lots_id), $cookie_live, '/');
        };
    } else{
        setcookie('$history_lots_id', json_encode($history_lots_id), $cookie_live, '/');
    };
};

if (!$lot){
    http_response_code(404);
}

$page_content = render_template('lot', ['lot' => $lot ,
    'bets' => $bets]);
$layout_content = render_template('layout', [
    'page_title' => $lot['lot-name'],
    'user_avatar' => $user_avatar,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'page_content' => $page_content,
    'categories' => $categories
]);
print ($layout_content);
