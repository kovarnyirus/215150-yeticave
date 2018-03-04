<?php
require_once('functions.php');
require_once('db_connect.php');
require_once('data.php');
require_once('sql_functions.php');

$categories = sql_get_categories($db_connect);
$bets_history = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lot = $_POST;
    $required = [
        'name',
        'description',
        'category',
        'initial_price',
        'step',
        'date_end'
    ];
    $dict = [
        'name' => 'Название',
        'description' => 'Описание',
        'lot_img' => 'Изображенеи',
        'category' => 'Категория',
        'initial_price' => 'Начальная цена',
        'step' => 'Шаг ставки',
        'date_end' => 'Дата окончания торгов'
    ];

    $errors = check_required_field($required, $lot);
    foreach ($required as $key) {
        if ($key === 'initial_price' || $key === 'step') {
            if ($lot[$key] <= 0) (
            $errors[$key] = 'Число дожно быть больше нуля.'
            );
        } elseif ($key === 'date_end') {
            if (strtotime($lot[$key]) <= strtotime(date('Y-m-d'))) {
                $errors[$key] = 'минимальная длительность торгов 1 день ';
            };
        } elseif ($key === 'category') {
            if ($lot[$key] == 'Выберите категорию') {
                $errors[$key] = 'Пожалуйста выберите категорию';
            };
        };
    };

    if ($_FILES ['lot_img']) {
        $img = check_file($_FILES ['lot_img'], ['image/jpeg', 'image/png'], 'img/');
        if ($img === 'format error') {
            $errors['lot_img'] = 'Загрузите картинку в формате JPG или PNG';
        } elseif ($img === 'no file') {
            $errors['lot_img'] = 'Вы не загрузили файл';
        } else {
            $lot['lot_img'] = $img['img_path'];
        };
    }

    if (count($errors)) {
        $page_content = render_template('add', [
            'lot' => $lot,
            'errors' => $errors,
            'categories' => $categories,
            'dict' => $dict]);
    } else {
        $category_id;
        foreach ($categories as $val => $cat) {
            if ($cat['category_name'] == $lot['category']) {
                $category_id = $cat['id'];
            }
        };
        $user_id = $_SESSION['user']['id'];
        $add_lot = sql_add_lot($db_connect, [
            $lot['name'],
            $lot['description'],
            $lot['lot_img'],
            $lot['initial_price'],
            $lot['date_end'],
            $lot['step'],
            $user_id,
            $category_id
        ]);

        if ($add_lot) {
            $last_lot_user = sql_get_last_lot_user($db_connect, $user_id);
            $lot = sub_array($last_lot_user);
            $bet_made = true;
            $page_content = render_template('lot', [
                'lot' => $lot,
                'bets' => $bets_history,
                'bet_made' => $bet_made,
                'categories' => $categories]);
        } else {
            $page_content =
                render_template('error', ['error' => mysqli_error($db_connect)]);
        };
    };
} else {
    if ($is_auth) {
        $page_content = render_template('add', ['categories' => $categories]);
    } else {
        $page_content =
            '<h3>Добавление лотов доступно только зарегистрированным пользователям</h3>';
        http_response_code(403);
    };
};

$layout_content = render_template('layout', [
    'page_title' => 'Добавить лот',
    'user_avatar' => $user_avatar,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'page_content' => $page_content,
    'categories' => $categories
]);
print ($layout_content);
