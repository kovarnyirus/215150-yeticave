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
    $bets_list = sql_get_bets_user($db_connect, [$bet_user_id]);

    $page_content = render_template('my-lots',[
        'categories' => $categories,
        'bets_list' => $bets_list,
        'user_id' => $bet_user_id,
        'db_connect' => $db_connect
        ] );

} else {
    $categories = sql_get_categories_class($db_connect);
    $page_content =
        '<h3>Добавление лотов доступно только зарегистрированным пользователям</h3>';
    http_response_code(403);
}




$layout_content = render_template('layout', [
    'page_title' => 'Список моих ставок',
    'user_avatar' => $user_avatar,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'page_content' => $page_content,
    'categories' => $categories
]);
print ($layout_content);


