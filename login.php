<?php
require_once('functions.php');
require_once('data.php');
require_once('db_connect.php');

$users = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST;
    $required = ['email', 'password'];
    $errors = check_required_field($required, $form);

    if (!$db_connect) {
        $error = mysqli_connect_error();
        $content = include_template('error', ['error' => $error]);
    } else {
        $sql = 'SELECT `email`, `name`, `password` FROM users';
        $result = mysqli_query($db_connect, $sql);

        if ($result) {
            $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            $error = mysqli_error($db_connect);
            $content = include_template('error', ['error' => $error]);
        }
    }


    if (!count($errors)) {
        if ($user = searchUserByEmail($form['email'], $users)) {
            if (password_verify($form['password'], $user['password'])) {
                $_SESSION['user'] = $user;
            } else {
                $errors['password'] = 'Неверный пароль';
            }
        } else {
            $errors['email'] = 'Такой пользователь не найден';
        }
    };

    if (count($errors)) {
        $page_content = render_template('login', ['form' => $form, 'errors' => $errors]);
    } else {
        header("Location: /index.php");
        exit();
    }

} else {
    if (isset($_SESSION['user'])) {
        $page_content = render_template('index', ['lots_list' => $lots_list]);
    } else {
        $page_content = render_template('login', []);
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
