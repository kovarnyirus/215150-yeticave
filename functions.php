<?php
session_start();
function render_template ($name_template, $array_data) {
    $PATH = 'templates/';
    $EXTENSION ='.php';
    $address_template = $PATH . $name_template . $EXTENSION;
    if (!file_exists($address_template)){
        return '';
    };
    extract($array_data);
    ob_start();
    require_once ($address_template);

    return ob_get_clean();

};

function format_price($price) {
    $ceil_num = ceil($price);
    if ($ceil_num > 1000) {
        $ceil_num = number_format($ceil_num, 0, '', ' ');
    }

    return $ceil_num . '  &#8381';
};

function time_tomorrow(){
    $ts = time();
    $ts_midnight = strtotime('tomorrow');
    $secs_to_midnight = $ts_midnight - $ts;
    return date('H:i ', $secs_to_midnight);
}

function check_file($file, $file_format, $move_path) {
    if ($file['name']) {
        $tmp_name = $file['tmp_name'];
        $path = $file['name'];
        $info = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($info, $tmp_name);

        foreach ($file_format as $key => $value){
            if ($file_type == $value ) {
                move_uploaded_file($tmp_name, $move_path . $path);
                return $img_path = [ 'img_path' => $move_path . $path];
            } else if (count($file_format) <= --$key) {
                return 'format error';
            }
        }
    }
    return 'no file';
};

function cookies_write($name_cookies, $value, $expire, $path) {
    $history_lot = [];
    if (isset($_COOKIE[$name_cookies])) {
        $history_lot = json_decode($_COOKIE[$name_cookies]);
        if (!in_array($value, $history_lot)) {
            array_push($history_lot, $value);
        };
    }
    setcookie($name_cookies, json_encode($history_lot), $expire, $path);
};

function searchUserByEmail($email, $users) {
    $result = null;
    foreach ($users as $user) {
        if ($user['email'] == $email) {
            $result = $user;
            break;
        }
    }
    return $result;
};

function check_required_field($required_arr, $check_array){
    $errors=[];
    foreach ($required_arr as $key){
        if (empty($check_array[$key])){
            $errors[$key] = 'Это поле надо заполнить';
        }
    }
    return $errors;
};

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}


function searchInSqlTable($connect, $table_name, $search_value, $table_fields){
    $fields = implode(', ', $table_fields);
    $value = mysqli_real_escape_string($connect, $search_value);
    $sql = "SELECT $fields"
        . " FROM $table_name";
    $result = mysqli_query($connect, $sql);
    return $result;
};

function check_email_users($connect, $email){
    $email = mysqli_real_escape_string($connect, $email);
    $sql = "SELECT `id`, `email`, `name`, `password`"
        ." FROM users"
        . " WHERE email = '$email'";
    $result = mysqli_query($connect, $sql);
    return $result;
};


function get_sql($connect, $sql ){
    $result = mysqli_query($connect, $sql);
    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }else {
        $error = mysqli_error($connect);
        return $content = render_template('error', ['error' => $error]);
    }
}
