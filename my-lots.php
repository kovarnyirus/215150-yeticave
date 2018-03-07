<?php
require_once('functions.php');
require_once('db_connect.php');
require_once('data.php');
require_once('sql_functions.php');
require_once('vendor/autoload.php');

$categories;
$date_end_list = [];

if (!$db_connect) {
    $error = mysqli_connect_error();
    $content = render_template('error', ['error' => $error]);
} elseif (!empty($_SESSION['user'])) {
    $bet_user_id = $_SESSION['user']['id'];
    $categories = sql_get_categories_class($db_connect);
    $lots_list = sql_get_active_lots($db_connect);

    foreach ($lots_list as $lot) {
        array_push($date_end_list, time_end($lot['date_end']));
    }

    $page_content = render_template('my-lots',['categories' => $categories] );

} else {
    $categories = sql_get_categories_class($db_connect);
    $page_content =
        '<h3>Добавление лотов доступно только зарегистрированным пользователям</h3>';
    http_response_code(403);
}




$layout_content = render_template('layout', [
    'page_title' => $page_title,
    'user_avatar' => $user_avatar,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'page_content' => $page_content,
    'categories' => $categories
]);
print ($layout_content);

SELECT
lots.id, lots.name, lots.lot_img, users.contacts as user_contacts, categories.category_name, `initial_price`, bets.user_price as bet, users.name as user_name, users.id as user_id, bets.bet_date
FROM lots inner
join bets on lots.id = bets.fk_lot_id
LEFT join users on bets.fk_user_id = users.id
right join categories on lots.fk_category_id = categories.id
WHERE users.id = 4
ORDER BY bet_date DESC
