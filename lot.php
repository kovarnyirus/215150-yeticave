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
    if (isset($_COOKIE['history_lots'])) {
        if (!in_array($id, json_decode($_COOKIE['history_lots']))) {
            $history_lots = json_decode($_COOKIE['history_lots']);
            array_push($history_lots, $id);
            setcookie('history_lots', json_encode($history_lots), $cookie_live, '/');
        };
    } else{
        setcookie('history_lots', json_encode($history_lots), $cookie_live, '/');
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
