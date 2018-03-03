<?php
require_once('functions.php');
require_once('db_connect.php');
require_once('data.php');


$category_sql = 'SELECT `id`, `category_name` FROM categories';
$categories = get_sql($db_connect, $category_sql);

$bets_history = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lot = $_POST;
    $required =
        ['name', 'description', 'category', 'initial_price', 'step', 'date_end'];
    $dict = ['name' => 'Название', 'description' => 'Описание',
        'lot_img' => 'Изображенеи', 'category' => 'Категория',
        'initial_price' => 'Начальная цена', 'step' => 'Шаг ставки',
        'date_end' => 'Дата окончания торгов'];
    $errors = check_required_field($required ,$lot);

    foreach ($required as $key ) {
        if($key === 'initial_price' || $key === 'step'){
             if($lot[$key] <= 0) (
             $errors[$key] = 'Число дожно быть больше нуля.'
             );
        } elseif ($key === 'date_end'){
            if (strtotime( $lot[$key]) <= strtotime(date('Y-m-d'))){
              $errors[$key] = 'минимальная длительность торгов 1 день ';
          };
        } elseif ($key === 'category'){
            if ( $lot[$key] == 'Выберите категорию'){
                $errors[$key] = 'Пожалуйста выберите категорию';
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
        $stmt = db_get_prepare_stmt($db_connect, $sql, [$lot['name'], $lot['description'], $lot['lot_img'], $lot['initial_price'], $lot['date_end'], $lot['step'], $user_id , $category_id]);
        $res = mysqli_stmt_execute($stmt);

        if ($res){

//            получем последний созданный лот пользователем
            $last_lot_user_sql = "SELECT lots.id, lots.name, `description`, `step`, `date_end`, `initial_price`, `lot_img`, users.id as user_id, categories.category_name FROM lots inner join categories on fk_category_id = categories.id LEFT join users on fk_user_id = users.id WHERE users.id = '$user_id' order by id DESC LIMIT 1";
            $last_lot_user = get_sql($db_connect, $last_lot_user_sql);

            $lot = sub_array($last_lot_user);

            $bet_made = true;
            $page_content = render_template('lot', ['lot' => $lot,
                'bets' => $bets_history,
                'bet_made' => $bet_made,
                'categories' => $categories]);
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
