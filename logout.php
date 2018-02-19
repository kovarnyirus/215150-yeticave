<?php
require_once('functions.php');
require_once('data.php');

$_SESSION =[];

$page_content = render_template('index', ['lots_list' => $lots_list ]);
$layout_content = render_template('layout', [
    'page_title' => 'Добавить лот',
    'user_avatar' => $user_avatar,
    'user_name' => $user_name,
    'is_auth' => false,
    'page_content' => $page_content,
    'categories' => $categories
]);
print ($layout_content);
