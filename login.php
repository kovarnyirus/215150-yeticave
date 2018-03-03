<?php
require_once('functions.php');
require_once('db_connect.php');
require_once('data.php');

$category_sql = 'SELECT `id`, `category_name` FROM categories';
$categories = get_sql($db_connect, $category_sql);


$user = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST;
    $required = ['email', 'password'];
    $errors = check_required_field($required, $form);



    if (!$db_connect) {
        $error = mysqli_connect_error();
        $content = render_template('error', ['error' => $error]);
    } else {

        $result = check_email_users($db_connect, $form['email']);

        if ($result) {
            $user = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            $error = mysqli_error($db_connect);
            $content = render_template('error', ['error' => $error]);
        }
    }


    if (!count($errors)) {
        if ($user = searchUserByEmail($form['email'], $user)) {
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
        $page_content = render_template('login', ['form' => $form, 'errors' => $errors, 'categories' => $categories]);
    } else {
        header("Location: /index.php");
        exit();
    }

} else {
    if (isset($_SESSION['user'])) {
        $page_content = render_template('index', ['lots_list' => $lots_list, 'categories' => $categories]);
    } else {
        $page_content = render_template('login', ['categories' => $categories]);
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
