<?php
require_once('functions.php');
require_once('data.php');
require_once('db_connect.php');

$lot = null;


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $lot_sql =
        "SELECT lots.id, lots.name, `description`, `initial_price`, `lot_img`, users.id as user_id, categories.category_name FROM lots inner join categories on fk_category_id = categories.id LEFT join users on fk_user_id = users.id WHERE lots.id = '$id'";
    $lots = get_sql($db_connect, $lot_sql);
    $lot = sub_array($lots);
    cookies_write($cookie_name_id_lot, $id, $cookie_live, $cookie_path);
};
if (!$lot) {
    http_response_code(404);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bet = $_POST;
    $required = ['cost'];
    $dict = ['lot-name' => 'Ставка'];
    $errors = check_required_field($required, $bet);

    $id = $_GET['id'];


    if (count($errors)) {

        $bets_sql =
            "SELECT lots.id,`initial_price`, bets. user_price as bet, users.name, bets.bet_date FROM lots inner join users on fk_user_id = users.id LEFT join bets on lots.id = bets.fk_lot_id WHERE lots.id = '$id' ";

        $bets = get_sql($db_connect, $bets_sql);

        $lot_cost = $lot['initial_price'];

        foreach ($bets as $val) {
            $lot_cost = $lot_cost + $val['bet'];
        }

    } else {

    }

}


$page_content = render_template('lot', ['lot' => $lot,
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
