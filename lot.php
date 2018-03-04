<?php
require_once('functions.php');
require_once('db_connect.php');
require_once('data.php');
require_once ('sql_functions.php');


$lot = null;
$bets_history;
$lot_cost;
$date_end_lot;
$bet_made = null;
$bet_user_id = null;
$page_title = null;
$categories = sql_get_categories($db_connect);

if (!empty($_SESSION['user'])) {
    $bet_user_id = $_SESSION['user']['id'];
}

if (isset($_GET['id'])) {
    $id = strval($_GET['id']);
    $lots = sql_get_lot($db_connect, [$id]);
    $lot = sub_array($lots);
};


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bet = $_POST;
    $required = ['cost'];
    $dict = ['lot-name' => 'Ставка'];
    $errors = check_required_field($required, $bet);

    //получаем список ставок
    $bets_history = sql_get_bets_list($db_connect, [$id]);

    //текущая цена лота = начальная цена + значения ставок
    $lot_cost = $lot['initial_price'];
    foreach ($bets_history as $val) {
        $lot_cost = $lot_cost + $val['bet'];
    }

    //время до завершения лота
    $date_end_lots = time_end($lot['date_end']);

    //проверка сто последняя ставка сделана не вами
    if ($bets_history) {
        if ($bets_history[0]['user_id'] == $bet_user_id) {
            $bet_made = true;
        }
    }

    $page_title = $lot['name'];

    if (count($errors)) {
        $page_content = render_template('lot', [
            'lot' => $lot,
            'bets' => $bets_history,
            'lot_cost' => $lot_cost,
            'date_end_lots' => $date_end_lots,
            'bet_made' => $bet_made,
            'errors' => $errors]);
    } else {
        if ($bet['cost'] >= ($lot_cost + $lot['step']) and is_int(+$bet['cost'])) {

           $add_bet = sql_add_bet($db_connect, [
               +$bet['cost'],
               $bet_user_id,
               $lot['id']
           ]);
            if ($add_bet) {
                $bets_history = sql_get_bets_list($db_connect, [$id]);
                $bet_made = $add_bet;
                $page_content = render_template('lot', [
                    'lot' => $lot,
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
            $page_content = render_template('lot', [
                'lot' => $lot,
                'bets' => $bets_history,
                'lot_cost' => $lot_cost,
                'bet_made' => $bet_made,
                'errors' => $errors,
                'date_end_lots' => $date_end_lots
            ]);
        }
    }

} else {
    if (!$lot) {
        $error = 'страницы с таким товаром не существует';
        http_response_code(404);
        $page_content = render_template('error', ['error' => $error]);
    } else {
        //получаем список ставок
        $bets_history = sql_get_bets_list($db_connect, [$id]);

//текущая цена лота = начальная цена + значения ставок
        $lot_cost = $lot['initial_price'];
        foreach ($bets_history as $val) {
            $lot_cost = $lot_cost + $val['bet'];
        }

//время до завершения лота
        $date_end_lots = time_end($lot['date_end']);

//проверка сто последняя ставка сделана не вами
        if ($bets_history) {
            if ($bets_history[0]['user_id'] == $bet_user_id) {
                $bet_made = true;
            }
        }

        $page_title = $lot['name'];

        cookies_write($cookie_name_id_lot, $id, $cookie_live, $cookie_path);

        $page_content = render_template('lot', [
            'lot' => $lot,
            'bets' => $bets_history,
            'lot_cost' => $lot_cost,
            'date_end_lots' => $date_end_lots,
            'bet_made' => $bet_made]);
    };
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
