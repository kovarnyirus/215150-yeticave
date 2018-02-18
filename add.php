<?php
require_once('functions.php');
require_once('data.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lot = $_POST;
    $required =
        ['lot-name', 'description', 'category', 'lot-rate', 'lot-step', 'lot-date'];
    $dict = ['lot-name' => 'Название', 'description' => 'Описание',
        'lot_img' => 'Изображенеи', 'category' => 'Категория',
        'lot-rate' => 'Начальная цена', 'lot-step' => 'Шаг ставки',
        'lot-date' => 'Дата окончания торгов'];
    $errors = [];

    foreach ($required as $key ) {
        if (empty($lot[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        };
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
        $page_content = render_template('lot', ['lot' => $lot, 'bets' => $bets]);
    }
} else {
    $page_content = render_template('add', ['categories' => $categories]);
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
