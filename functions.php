<?php
session_start();

/**
 * функция вывода шаблона
 *
 * @param $name_template - имя шаблона
 * @param $array_data - массив с данными искользуемые в шаблоне
 * @return string
 */
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

/**
 * фушкция форматирования цены
 *
 * @param $price - число которое надо отформатировать
 * @return string
 */
function format_price($price) {
    $ceil_num = ceil($price);
    if ($ceil_num > 1000) {
        $ceil_num = number_format($ceil_num, 0, '', ' ');
    }

    return $ceil_num . '  &#8381';
};

/**
 * возвращает время окончания публикации лота
 *
 * @param $end_date - дата снятия с публикации которую указал пользователь
 * @return string - возвращает отформатированную дату
 */
function time_end($end_date){
    $ts = time();
    $ts_midnight = strtotime($end_date);
    $secs_to_date_end = $ts_midnight - $ts;
    return date ('jд H:i',$secs_to_date_end);
}

/**
 * функция проверки изображения на соответствие оформату.
 *
 * @param $file - обрабатываемый файл
 * @param $file_format - формат которому должен соответсвовать файл
 * @param $move_path - путь куда следует переместить изображение
 * @return string - с сылкой на файл либо строку с текстом ошибки.
 */
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

/**
 * запись в cookies
 *
 * @param $name_cookies -имя cookies
 * @param $value - записываемо значение
 * @param $expire - время жиззни cookies
 * @param $path - путь
 */
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

/**
 * поиск пользователя по email
 *
 * @param $email
 * @param $users
 * @return - массив с данными пользователя
 */
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

/**
 * проверят что обязательные поля заполнены
 *
 * @param $required_arr - массив с полями обязательными для заполнения
 * @param $check_array - проверяемы поля
 * @return array errors
 */
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

/**
 * звозвращает ассоциативный массив с лотом значениями которого являются значения двумерного массива
 *
 * @param $array_in - двумерный массив
 * @return array -ассоциативный массив
 */
function sub_array($array_in) {
    $array_out = [];
    foreach ($array_in as $subArr) {
        foreach ($subArr as $key => $val) {
            if (isset($array_out[$key]) && $array_out[$key] > $val) continue;
            $array_out[$key] = $val;
        }
    }
    return $array_out;
};
