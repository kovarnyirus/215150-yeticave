<?php
require_once('functions.php');
require_once('db_connect.php');
require_once('data.php');


$lot = null;
$bets_history;
$lot_cost;
$date_end_lot;
$bet_made = null;
$bet_user_id = null;

if(!empty($_SESSION['user'])){
    $bet_user_id = $_SESSION['user']['id'];
}

$category_sql = 'SELECT `id`, `category_name` FROM categories';
$categories = get_sql($db_connect, $category_sql);

if (isset($_GET['id'])) {
    $id = $_GET['id'];



//получаем лот
    $lot_sql =
        "SELECT lots.id, lots.name, `description`, `step`, `date_end`, `initial_price`, `lot_img`, users.id as user_id, categories.category_name FROM lots inner join categories on fk_category_id = categories.id LEFT join users on fk_user_id = users.id WHERE lots.id = '$id'";
    $lots = get_sql($db_connect, $lot_sql);
    $lot = sub_array($lots);

//получаем список ставок
    $bets_sql =
        "SELECT lots.id, `initial_price`, bets.user_price as bet, users.name, users.id as user_id, bets.bet_date FROM lots inner join bets on lots.id = bets.fk_lot_id LEFT join users on bets.fk_user_id = users.id WHERE lots.id = '$id' ORDER BY bet_date DESC";
    $bets_history = get_sql($db_connect, $bets_sql);


//текущая цена лота = начальная цена + значения ставок
    $lot_cost = $lot['initial_price'];
    foreach ($bets_history as $val) {
        $lot_cost = $lot_cost + $val['bet'];
    }

//время до завершения лота
    $date_end_lots = time_end($lot['date_end']);

//проверка сто последняя ставка сделана не вами
    if ($bets_history){
        if ($bets_history[0]['user_id'] == $bet_user_id) {
            $bet_made = true;
        }
    }

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

    if (count($errors)) {
        $page_content = render_template('lot', ['lot' => $lot,
            'bets' => $bets_history,
            'lot_cost' => $lot_cost,
            'date_end_lots' => $date_end_lots,
            'bet_made' => $bet_made,
            'errors' => $errors]);
    } else {
        if ($bet['cost'] >= ($lot_cost + $lot['step']) and is_int(+$bet['cost'])) {
            $sql =
                "INSERT INTO bets (bet_date, user_price, fk_user_id, fk_lot_id) VALUES (NOW(), ?, ?, ?)";
            $stmt = db_get_prepare_stmt($db_connect, $sql,
                [+$bet['cost'], $bet_user_id, $lot['id']]);
            $res = mysqli_stmt_execute($stmt);

            if ($res) {
                $bet_made = $res;
                $bets_sql =
                    "SELECT lots.id, `initial_price`, bets.user_price as bet, users.name, users.id as user_id, bets.bet_date FROM lots inner join bets on lots.id = bets.fk_lot_id LEFT join users on bets.fk_user_id = users.id WHERE lots.id = '$id' ORDER BY bet_date DESC";
                $bets_history = get_sql($db_connect, $bets_sql);
                $page_content = render_template('lot', ['lot' => $lot,
                    'bets' => $bets_history,
                    'lot_cost' => $lot_cost,
                    'date_end_lots' => $date_end_lots,
                    'bet_made' => $bet_made]);
            } else {
                $page_content =
                    render_template('error', ['error' => mysqli_error($db_connect)]);
            }
        } else {
            $errors['cost'] =
                "ставка должна быть целой и не может быть меньше текущей цены + Мин. ставка";
            $page_content = render_template('lot', ['lot' => $lot,
                'bets' => $bets_history,
                'lot_cost' => $lot_cost,
                'bet_made' => $bet_made,
                'date_end_lots' => $date_end_lots]);
        }
    }

} else {
    $page_content = render_template('lot', ['lot' => $lot,
        'bets' => $bets_history,
        'lot_cost' => $lot_cost,
        'date_end_lots' => $date_end_lots,
        'bet_made' => $bet_made]);
}

$layout_content = render_template('layout', [
    'page_title' => $lot['name'],
    'user_avatar' => $user_avatar,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'page_content' => $page_content,
    'categories' => $categories
]);
print ($layout_content);
