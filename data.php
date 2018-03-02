<?php
$is_auth = isset($_SESSION['user']) ? true: false;
date_default_timezone_set('Europe/Moscow');
$user_name = isset($_SESSION['user']) ? $_SESSION['user']['name'] : ' ';
$user_avatar = 'img/user.jpg';
$page_title = 'Главная';
$cookie_path = '/';
$cookie_live = strtotime("+30 days");
$cookie_name_id_lot = 'history_lots_id';
$categories = [];
$lots_list = [];
