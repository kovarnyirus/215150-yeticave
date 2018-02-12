<?php
require_once('functions.php');
require_once('templates/data_templates.php');
require_once ('lots_list.php');
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
}

if (!$lot){
    http_response_code(404);
}

$page_content = render_template('lot', ['lot' => $lot ,
    'bets' => $bets]);
$layout_content = render_template('layout', [
    'page_title' => $lot['name'],
    'user_avatar' => $user_avatar,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'page_content' => $page_content,
    'categories' => $categories
]);
print ($layout_content);
