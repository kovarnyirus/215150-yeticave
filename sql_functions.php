<?php
require_once('functions.php');
require_once('vendor/autoload.php');
/**
 * получить список категорий
 *
 * @param $db_connect Ресурс соединения
 * @return array с лотами
 */
function sql_get_categories($db_connect)
{
    $category_sql = 'SELECT `id`, `category_name` FROM categories';
    $stmt = db_get_prepare_stmt($db_connect, $category_sql);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $res = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $page_content =
            render_template('error', ['error' => mysqli_error($db_connect)]);
};

/**
 * получить список категорий с классом
 *
 * @param $db_connect : параметры соединения
 * @return array с лотами
 */
function sql_get_categories_class($db_connect){
    $category_sql = 'SELECT `id`, `category_name`, `html_class` FROM categories';
    $stmt = db_get_prepare_stmt($db_connect, $category_sql);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $res = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $page_content =
            render_template('error', ['error' => mysqli_error($db_connect)]);
};

/**
 * получем последний созданный лот пользователем
 *
 * @param $db_connect hесурс соединения
 * @param $user_id id пользователя
 * @return array с лотом
 */
function sql_get_last_lot_user($db_connect, $user_id)
{
    $last_lot_user_sql =
        "SELECT lots.id, lots.name, `description`, `step`, `date_end`, `initial_price`, `lot_img`, users.id as user_id, categories.category_name FROM lots inner join categories on fk_category_id = categories.id LEFT join users on fk_user_id = users.id WHERE users.id = ? order by id DESC LIMIT 1";
    $stmt = db_get_prepare_stmt($db_connect, $last_lot_user_sql, [$user_id]);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $res = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $page_content =
            render_template('error', ['error' => mysqli_error($db_connect)]);
};

/**
 * получить лот по его id
 *
 * @param $db_connect Ресурс соединения
 * @param $lot_id id лота
 * @return array с лотом
 */
function sql_get_lot($db_connect, $lot_id){
    $lot_sql =
        "SELECT lots.id, lots.name, `description`, `step`, `date_end`, `initial_price`, `lot_img`, users.id as user_id, categories.category_name FROM lots inner join categories on fk_category_id = categories.id LEFT join users on fk_user_id = users.id WHERE lots.id = ?";
    $stmt = db_get_prepare_stmt($db_connect, $lot_sql, $lot_id);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $res = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $page_content =
            render_template('error', ['error' => mysqli_error($db_connect)]);
};

/**
 * получить все лоты с неистекшим сроком публикации отсортированные по дате создания
 *
 * @param $db_connect Ресурс соединения
 * @return array список лотов
 */
function sql_get_active_lots($db_connect){
    $now_date = date( "Y-m-d", strtotime( "now" ) );
    $sql = "select lot.id, lot.name, lot.initial_price, lot.lot_img, lot.date_end, lot.created_date, categories.category_name from lots lot"
        . " inner join categories on lot.fk_category_id = categories.id"
        . " where lot.date_end > ?"
        . " group by lot.id, lot.name, lot.initial_price, lot.lot_img, lot.date_end, lot.created_date, categories.category_name"
        . " ORDER BY lot.created_date DESC";
    $stmt = db_get_prepare_stmt($db_connect, $sql, [$now_date]);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $res = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $page_content = render_template('error', ['error' => mysqli_error($db_connect)]);
};

/**
 * добавление нового  лота
 *
 * @param $db_connect Ресурс соединения
 * @param $data - массив с параметрами: имя лота, описание лота, ссылка на изображение, начальная цена, дата окончания публикации, шаг, id пользователя, id категории.
 * @return array список лотов
 */
function sql_add_lot($db_connect, $data){
    $sql_add = "INSERT INTO lots (name, description, lot_img, initial_price, date_end, step, fk_user_id, fk_category_id ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = db_get_prepare_stmt($db_connect, $sql_add, $data);
    return $res = mysqli_stmt_execute($stmt);
}


/**
 * добавление данных
 *
 * @param $db_connect
 * @param $data массив состоящий из: ставки, id рользователя, id лота.
 * @return bool
 */
function sql_add_bet($db_connect, $data){
    $sql ="INSERT INTO bets (bet_date, user_price, fk_user_id, fk_lot_id) VALUES (NOW(), ?, ?, ?)";
    $stmt = db_get_prepare_stmt($db_connect, $sql, $data);
    return mysqli_stmt_execute($stmt);
}

/**
 * запрос на получение списка ставок по id лота
 *
 * @param $db_connect
 * @param $data id лота
 */
function sql_get_bets_list($db_connect, $data){
    $bets_sql =
        "SELECT lots.id, `initial_price`, bets.user_price as bet, users.name, users.id as user_id, bets.bet_date FROM lots inner join bets on lots.id = bets.fk_lot_id LEFT join users on bets.fk_user_id = users.id WHERE lots.id = ? ORDER BY bet_date DESC";
    $stmt = db_get_prepare_stmt($db_connect, $bets_sql, $data);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $res = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $page_content = render_template('error', ['error' => mysqli_error($db_connect)]);
}

/**
 * получить все email
 *
 * @param $db_connect
 * @return array
 */
function sql_get_all_emails($db_connect){
    $sql = "SELECT email FROM `users`";
    $stmt = db_get_prepare_stmt($db_connect, $sql);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $res = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $page_content = render_template('error', ['error' => mysqli_error($db_connect)]);
}



/**
 * добавление пользователя в базу
 *
 * @param $db_connect
 * @param $data : имя пользователя, email, password, avatar, contacts.
 * @return bool
 */
function sql_add_user($db_connect, $data){
    $sql =
        "INSERT INTO users (name, email, password, avatar, contacts, created_date) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = db_get_prepare_stmt($db_connect, $sql, $data);
    return mysqli_stmt_execute($stmt);
}


/**
 * возвращает пользователя с нужным email
 *
 * @param $connect
 * @param $email - емеил по которому будет происходить поиск
 * @return array
 */
function check_email_users($connect, $email){
    $sql = "SELECT `id`, `email`, `name`, `password`"
        ." FROM users"
        . " WHERE email = ?";
    $stmt = db_get_prepare_stmt($connect, $sql, $email);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $res = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $result;
};
/**
 * возвращает список лотов отвечающие поисковому запросу
 *
 * @param $connect
 * @param $email - емеил по которому будет происходить поиск
 * @return array
 */
function sql_search_lots($connect, $data){
    $search_lots_sql = "SELECT lots.id, lots.name, `description`, `step`, `date_end`, `initial_price`, `lot_img`, users.id as user_id, categories.category_name FROM lots inner join categories on fk_category_id = categories.id LEFT join users on fk_user_id = users.id WHERE MATCH(lots.name, lots.description) AGAINST(?);";
    $stmt = db_get_prepare_stmt($connect, $search_lots_sql, $data);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $res = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $result;
};


/**
 * получение списка лотов с истекшим сроком публикации и без победителя.
 *
 * @param $db_connect
 * @return array|null|string
 */
function sql_get_lots_end($db_connect){
    $now_date = date( "Y-m-d", strtotime( "now" ) );
    $sql = "select lot.id, lot.name, users.name, lot.fk_winner_id, lot.initial_price, lot.lot_img, lot.date_end, lot.created_date, categories.category_name from lots lot inner join categories on lot.fk_category_id = categories.id LEFT join users on lot.fk_user_id = users.id where lot.date_end <= ?  and !lot.fk_winner_id is null group by lot.id, lot.name, users.name, lot.fk_winner_id, lot.initial_price, lot.lot_img, lot.date_end, lot.created_date, categories.category_name ORDER BY lot.created_date DESC";
    $stmt = db_get_prepare_stmt($db_connect, $sql, [$now_date]);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $res = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $page_content = render_template('error', ['error' => mysqli_error($db_connect)]);
};

/**
 * запрос на получение последней ставки по id лота
 *
 * @param $db_connect
 * @param $data id лота
 */
function sql_get_last_bet($db_connect, $data){
    $bet_sql =
        "SELECT lots.id, `initial_price`, bets.user_price as bet, users.name, users.id as user_id, bets.bet_date FROM lots inner join bets on lots.id = bets.fk_lot_id LEFT join users on bets.fk_user_id = users.id WHERE lots.id = ? ORDER BY bet_date DESC LIMIT 1";
    $stmt = db_get_prepare_stmt($db_connect, $bet_sql, $data);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $res = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $page_content = render_template('error', ['error' => mysqli_error($db_connect)]);
}

/**
 * обновление значение победителя на id user совершившего последнию ставку
 *
 * @param $db_connect
 * @param $data
 * @return bool
 */
function sql_update_winner($db_connect, $data){
  $update_sql = "UPDATE lots SET fk_winner_id = ? WHERE lots.id = ?";
    $stmt = db_get_prepare_stmt($db_connect, $update_sql, $data);
    return mysqli_stmt_execute($stmt);
}
