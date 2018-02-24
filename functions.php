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

        foreach ($file_format as $value)
            if ($file_type == $value) {
                move_uploaded_file($tmp_name, $move_path . $path);
                return $img_path = [ 'img_path' => $move_path . $path];
            } else {
                return 'format error';
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
