<?php
require_once('functions.php');
require_once('data.php');
require_once('db_connect.php');

$category_sql = 'SELECT `id`, `category_name` FROM categories';
$categories = get_sql($db_connect, $category_sql);
$bets_sql = '';




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lot = $_POST;
    $required =
        ['lot-name', 'description', 'category', 'initial_price', 'lot-step', 'date_end'];
    $dict = ['lot-name' => 'Название', 'description' => 'Описание',
        'lot_img' => 'Изображенеи', 'category' => 'Категория',
        'initial_price' => 'Начальная цена', 'lot-step' => 'Шаг ставки',
        'date_end' => 'Дата окончания торгов'];
    $errors = check_required_field($required ,$lot);

    foreach ($required as $key ) {
        if($key === 'initial_price' || $key === 'lot-step'){
             if($lot[$key] <= 0) (
             $errors[$key] = 'Число дожно быть больше нуля.'
             );
        } elseif ($key === 'date_end'){
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

        $category_id;

        foreach ($categories as $val => $cat){
            if ($cat['category_name'] == $lot['category']){
                $category_id = $cat['id'];
            }
        }
        $user_id = $_SESSION['user']['id'];


        $sql = "INSERT INTO lots (name, description, lot_img, initial_price, date_end, step, fk_user_id, fk_category_id ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = db_get_prepare_stmt($db_connect, $sql, [$lot['lot-name'], $lot['description'], $lot['lot_img'], $lot['initial_price'], $lot['date_end'], $lot['lot-step'], $user_id , $category_id]);
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
