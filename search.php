<?php
require_once('functions.php');
require_once('db_connect.php');
require_once('data.php');
require_once ('sql_functions.php');

if (!$db_connect) {
    $error = mysqli_connect_error();
    $content = render_template('error', ['error' => $error]);
}
else {
    $categories = sql_get_categories($db_connect);
    $date_end_list = [];
    $search = $_GET['search'] ?? '';

    if ($search) {
        $search_lots = sql_search_lots($db_connect, [$search]);
        $page_content = render_template('search', ['search_lots' => $search_lots, 'search' => $search, 'categories' => $categories]);
    } else {
        $search_lots =[];
        $page_content = render_template('search', ['search_lots' => $search_lots, 'search' => $search, 'categories' => $categories]);
    }
}

$layout_content = render_template('layout', [
    'page_title' => 'Результаты поиска',
    'user_avatar' => $user_avatar,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'page_content' => $page_content,
    'categories' => $categories,
    'search' => $search
]);
print ($layout_content);
