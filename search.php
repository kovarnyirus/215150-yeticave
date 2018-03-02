<?php
require_once('functions.php');
require_once('db_connect.php');
require_once('data.php');


if (!$db_connect) {
    $error = mysqli_connect_error();
    $content = render_template('error', ['error' => $error]);
}
else {
    $category_sql = 'SELECT `id`, `category_name` FROM categories';
    $categories = get_sql($db_connect, $category_sql);

    $date_end_list = [];


    $search = $_GET['search'] ?? '';

    if ($search) {

        $search_lots_sql = "SELECT lots.id, lots.name, `description`, `step`, `date_end`, `initial_price`, `lot_img`, users.id as user_id, categories.category_name FROM lots inner join categories on fk_category_id = categories.id LEFT join users on fk_user_id = users.id WHERE MATCH(lots.name, lots.description) AGAINST('$search');";
        $search_lots = get_sql($db_connect, $search_lots_sql);

        $page_content = render_template('search', ['search_lots' => $search_lots, 'search' => $search, 'categories' => $categories]);
    } else {
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
