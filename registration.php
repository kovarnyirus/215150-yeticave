<?php
require_once('functions.php');
require_once('data.php');
require_once('db_connect.php');
require_once ('sql_functions.php');

$categories = sql_get_categories($db_connect);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST;
    $required =
        ['email', 'password', 'name', 'contacts'];
    $dict = ['email' => 'email', 'password' => 'Пароль',
        'name' => 'Имя', 'contacts' => 'Контакты'];
    $errors = check_required_field($required, $user);

    if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Необходимо ввести корректный email';
    } else {
        $emails = sql_get_all_emails($db_connect);
        foreach ($emails as $key => $email) {
            if ($email['email'] === $user['email']) {
                $errors['email'] = 'данный email занят';
            }
        }
    }

        $img = check_file($_FILES ['avatar'], ['image/jpeg', 'image/png'], 'img/');
        if ($img ==='format error' ) {
            $errors['avatar'] = 'Загрузите картинку в формате JPG или PNG';
        } elseif ($img === 'no file') {
            $user['avatar'] = 'img/user.jpg';
        } else {
            $user['avatar'] = $img['img_path'];
        }

    if (count($errors)) {
        $page_content = render_template('registration', [
            'errors' => $errors,
            'categories' => $categories,
            'dict' => $dict,
            'user' => $user]);
    } else {
        $add_user = sql_add_user($db_connect,[
            $user['name'],
            $user['email'],
            password_hash($user['password'], PASSWORD_BCRYPT),
            $user['avatar'],
            $user['contacts']]);

        if ($add_user) {
            header('Location: login.php');
            exit();
        } else {
            $page_content =
                render_template('error', ['error' => mysqli_error($db_connect)]);
        }
    };
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
