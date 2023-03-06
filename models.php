<?php
/**
 * Summary of get_lot
 * @param $con
 * @param int $id
 * @return array lot
 */
function get_lot($con,$id): array {
    $sql = "SELECT lots.id, lots.step, lots.id, lots.lot_description, lots.title as title, lots.start_price, lots.img, lots.date_finish, c.category_name
    FROM lots JOIN categories c ON c.id = lots.category_id
    WHERE lots.id = $id and unix_timestamp(lots.date_finish) - unix_timestamp(CURRENT_TIMESTAMP) > 0";
    $result = mysqli_query(mysql: $con, query: $sql);
    return mysqli_fetch_all(result: $result, mode: MYSQLI_ASSOC);
}
function get_lots($con,$category=null): array {
    if (!$category) {
    $sql = "SELECT lots.id, lots.step, lots.id, lots.lot_description, lots.title as title, lots.start_price, lots.img, lots.date_finish, c.category_name
    FROM lots JOIN categories c ON c.id = lots.category_id";
    } else {
    $category = mysqli_real_escape_string(mysql: $con,string: $category);
    $sql = "SELECT lots.id, lots.step, lots.id, lots.lot_description, lots.title as title, lots.start_price, lots.img, lots.date_finish, c.category_name
    FROM lots JOIN categories c ON c.id = lots.category_id and c.character_code = '$category'";
    }
    $sql .= " WHERE unix_timestamp(lots.date_finish) - unix_timestamp(CURRENT_TIMESTAMP) > 0";
    $result = mysqli_query(mysql: $con, query: $sql);
    return mysqli_fetch_all(result: $result, mode: MYSQLI_ASSOC);
}
/**
 * Summary of get_query_news_lots
 * function return lots where date finishing less 3 current 
 * @return array new lots
 */
function get_new_lots($con): array {
    $sql = "SELECT lots.id, lots.title, lots.start_price, lots.img, lots.date_finish, c.category_name
    FROM lots JOIN categories c ON c.id = lots.category_id
    WHERE lots.date_creation > DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -3 DAY) and unix_timestamp(lots.date_finish) - unix_timestamp(CURRENT_TIMESTAMP) > 0";
    $result = mysqli_query(mysql: $con, query: $sql);
    return mysqli_fetch_all(result: $result, mode: MYSQLI_ASSOC);
}
/**
 * Summary of get_categories
 * @param $con
 * @return array categories
 */
function get_categories($con): array {
    $sql = 'SELECT categories.id, categories.category_name, categories.character_code FROM categories';
    $result = mysqli_query(mysql: $con, query: $sql);
    return mysqli_fetch_all(result: $result, mode: MYSQLI_ASSOC);
}
function get_user($con): array {
    $sql = 'SELECT users.id, users.user_name, users.user_password, users.email, users.contacts FROM users';
    $result = mysqli_query(mysql: $con, query: $sql);
    return mysqli_fetch_all(result: $result, mode: MYSQLI_ASSOC);
}

function add_lot($con): string {
    $sql = "INSERT INTO lots (title, category_id, lot_description, start_price, step, date_finish, img, user_id, winner_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
    return $sql;
}
function add_user($con): string {
    $sql = "INSERT INTO users(user_name,user_password,contacts,email) VALUES (?, ?, ?, ?);";
    return $sql;
}
function get_auth_user($con,$email): array {
    $sql = "SELECT users.id, users.user_name, users.user_password, users.email, users.contacts FROM users WHERE email = '$email'";    
    $result = mysqli_query(mysql: $con, query: $sql);
    return mysqli_fetch_all(result: $result, mode: MYSQLI_ASSOC);
}
function get_search_lots($con,$words): array {
    $sql = "SELECT * FROM lots
    WHERE MATCH(title, lot_description) AGAINST('$words') and unix_timestamp(lots.date_finish) - unix_timestamp(CURRENT_TIMESTAMP) > 0";    
    $result = mysqli_query(mysql: $con, query: $sql);
    return mysqli_fetch_all(result: $result, mode: MYSQLI_ASSOC);
}
function get_search_counts($con,$words): array {
    $sql = "SELECT COUNT(id) as count FROM lots
    WHERE MATCH(title, lot_description) AGAINST('$words') and unix_timestamp(lots.date_finish) - unix_timestamp(CURRENT_TIMESTAMP) > 0";    
    $result = mysqli_query(mysql: $con, query: $sql);
    return mysqli_fetch_all(result: $result, mode: MYSQLI_NUM);
}
function get_search_items($con,$words,$page_items,$offset): array {
    $sql = "SELECT lots.id, lots.title, lots.start_price, lots.img, lots.date_finish, c.category_name
    FROM lots JOIN categories c ON c.id = lots.category_id
    WHERE MATCH(title, lot_description) AGAINST('$words') and unix_timestamp(lots.date_finish) - unix_timestamp(CURRENT_TIMESTAMP) > 0
    LIMIT $page_items OFFSET $offset";    
    $result = mysqli_query(mysql: $con, query: $sql);
    return mysqli_fetch_all(result: $result, mode: MYSQLI_ASSOC);
}
function get_query_update_lot_bet($con,$bet,$id_lot): bool|mysqli_result {
    $sql = "UPDATE lots SET start_price = $bet where id = $id_lot";
    return mysqli_query(mysql: $con,query: $sql);
}
function get_query_update_lot_winner($con,$id_lot,$id_user): bool|mysqli_result {
$sql = "UPDATE lots SET winner_id=$id_user where id = $id_lot";
return mysqli_query(mysql: $con,query: $sql);
}

function get_query_add_bet($con,$bet,$id_lot,$id_user): bool|mysqli_result {
    $sql = "INSERT INTO bets(price_bet,user_id,lot_id) VALUES($bet,$id_user,$id_lot)";
    return mysqli_query(mysql: $con,query: $sql);
}
function history_bet($con,$id_user): array {
    $sql = "SELECT lots.winner_id, lots.img,bets.date_bet,bets.price_bet,lots.date_finish,lots.id as lot_id, categories.category_name, lots.title
    FROM bets
    INNER JOIN lots ON bets.lot_id=lots.id
    INNER JOIN categories ON categories.id=lots.category_id
    INNER JOIN users ON bets.user_id=users.id
    WHERE users.id=$id_user
    ORDER BY date_bet DESC;";
    $result = mysqli_query(mysql: $con, query: $sql);
    return mysqli_fetch_all(result: $result, mode: MYSQLI_ASSOC);
}
function history_bet_lot($con,$id_lot): array {
    $sql = "SELECT user_name, bets.date_bet, bets.price_bet
    FROM bets
    INNER JOIN lots ON bets.lot_id=$id_lot
    INNER JOIN users ON bets.user_id=users.id
    ORDER BY date_bet DESC";
    $result = mysqli_query(mysql: $con, query: $sql);
    return mysqli_fetch_all(result: $result, mode: MYSQLI_ASSOC);
}