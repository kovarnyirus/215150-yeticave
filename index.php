<?php
require_once('functions.php');
require_once ('templates/data_templates.php');

$page_content = render_template('index', ['ads_list' => $ads_list ]);
$layout_content = render_template('layout', [
    'page_title' => $page_title,
    'user_avatar' => $user_avatar,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'page_content' => $page_content,
    'categories' => $categories
]);
print ($layout_content);
