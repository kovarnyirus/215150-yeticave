<?php
require_once('functions.php');
require_once('data.php');
require_once('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lot = $_POST;
    $required =
        ['lot-name', 'description', 'category', 'lot-rate', 'lot-step', 'lot-date'];
    $dict = ['lot-name' => 'Название', 'description' => 'Описание',
        'lot_img' => 'Изображенеи', 'category' => 'Категория',
        'lot-rate' => 'Начальная цена', 'lot-step' => 'Шаг ставки',
        'lot-date' => 'Дата окончания торгов'];
    $errors = check_required_field($required ,$lot);;

    foreach ($required as $key ) {
        if($key === 'lot-rate' || $key === 'lot-step'){
             if($lot[$key] <= 0) (
             $errors[$key] = 'Число дожно быть больше нуля.'
             );
        } elseif ($key === 'lot-date'){
            if (strtotime( $lot[$key]) <= strtotime(date('Y-m-d'))){
              $errors[$key] = 'минимальная длительность торгов 1 день ';
          };
        };
    }

    switch ($img = check_file($_FILES ['lot_img'], ['image/jpeg', 'image/png'],'img/')) {
        case 'format error':
            $errors['lot_img'] = 'Загрузите картинку в формате JPG или PNG';
            break;
        case 'no file':
            $errors['lot_img'] = 'Вы не загрузили файл';
            break;
        default:
            $lot['lot_img'] = $img['img_path'];
    }

    if (count($errors)) {
        $page_content = render_template('add',
            ['lot' => $lot, 'errors' => $errors, 'categories' => $categories,
                'dict' => $dict]);
    } else {



        $sql =
            "INSERT INTO lost (name, description, lot_img, initial_price, date_end, step) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = db_get_prepare_stmt($db_connect, $sql, [$lot['name'], $lot['description'], $lot['lot_img'],
            $lot['initial_price'], $lot['date_end'], $lot['step']]);
        $res = mysqli_stmt_execute($stmt);

        if ($res){
            $page_content = render_template('lot', ['lot' => $lot, 'bets' => $bets]);
        } else {
            $page_content =
                render_template('error', ['error' => mysqli_error($db_connect)]);
        }
    }
} else {
    if ($is_auth) {
        $category_sql = 'SELECT `id`, `category_name` FROM categories';
        $categories = get_sql($db_connect, $category_sql);
        $page_content = render_template('add', ['categories' => $categories]);
    } else {
        $page_content = '<h3>Добавление лотов доступно только зарегистрированным пользователям</h3>';
        http_response_code(403);
    }

}

$layout_content = render_template('layout', [
    'page_title' => 'Добавить лот',
    'user_avatar' => $user_avatar,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'page_content' => $page_content,
    'categories' => $categories
]);
print ($layout_content);
