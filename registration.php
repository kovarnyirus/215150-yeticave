<?php
require_once('functions.php');
require_once('data.php');
require_once('db_connect.php');
require_once('mysql_helper.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST;
    $required =
        ['email', 'password', 'name', 'contacts'];
    $dict = ['email' => 'email', 'password' => 'Пароль',
        'name' => 'Имя', 'contacts' => 'Контакты'];
    $errors = check_required_field($required, $user);

//    foreach ($required as $key) {
//        if ($key === 'lot-rate' || $key === 'lot-step') {
//            if ($lot[$key] <= 0) (
//            $errors[$key] = 'Число дожно быть больше нуля.'
//            );
//        } elseif ($key === 'lot-date') {
//            if (strtotime($lot[$key]) <= strtotime(date('Y-m-d'))) {
//                $errors[$key] = 'минимальная длительность торгов 1 день ';
//            };
//        };
//    }

    if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Необходимо ввести корректный email';
    } else {
        $sql = "SELECT email FROM `users`";
        $result = mysqli_query($db_connect, $sql);
        if ($result) {
            $emails = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach ($emails as $email) {
                if ($email === $user['email']) {
                    $errors['email'] = 'данный email занят';
                }
            }
        }
    }

    if ($_FILES ['avatar']){
        switch ($img = check_file($_FILES ['avatar'], ['image/jpeg', 'image/png'], 'img/')) {
            case 'format error':
                $errors['avatar'] = 'Загрузите картинку в формате JPG или PNG';
                break;
            case 'no file':
                $user['avatar'] = null;
                break;
            default:
                $user['avatar'] = $img['img_path'];
        }
    }



    if (count($errors)) {
        $page_content = render_template('registration',
                                        ['errors' => $errors,
                                            'categories' => $categories,
                                            'dict' => $dict,
                                            'user' => $user]);
    } else {
        $sql =
            "INSERT INTO `users` (name, email, password, avatar, contacts) VALUES (?, ?, ?, ?, ?)";
        $stmt = db_get_prepare_stmt($db_connect, $sql, [$user['name'], $user['email'],
            password_hash($user['password'], PASSWORD_BCRYPT), $user['avatar'],
            $user['contacts']]);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            header('Location: login.php');
            exit();
        } else{
            $page_content = render_template('error', ['error' => mysqli_error($db_connect)]);
        }
    }
} else {
    $page_content = render_template('registration', ['categories' => $categories]);
}

$layout_content = render_template('layout', [
    'page_title' => 'Регистрация',
    'user_avatar' => $user_avatar,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'page_content' => $page_content,
    'categories' => $categories
]);
print ($layout_content);
