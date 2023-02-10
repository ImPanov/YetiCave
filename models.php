<?php
/**
 * Summary of get_lot
 * @param $con
 * @param int $id
 * @return array lot
 */
function get_lot($con,$id) {
    $sql = "SELECT lots.step, lots.id, lots.lot_description, lots.title as title, lots.start_price, lots.img, lots.date_finish, c.category_name
    FROM lots JOIN categories c ON c.id = lots.category_id
    WHERE lots.id = $id";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
/**
 * Summary of get_query_news_lots
 * function return lots where date finishing less 3 current 
 * @return array new lots
 */
function get_new_lots($con) {
    $sql = "SELECT lots.id, lots.title, lots.start_price, lots.img, lots.date_finish, c.category_name
    FROM lots JOIN categories c ON c.id = lots.category_id
    WHERE lots.date_creation > DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -3 DAY)";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
/**
 * Summary of get_categories
 * @param $con
 * @return array categories
 */
function get_categories($con) {
    $sql = 'SELECT categories.id, categories.category_name, categories.character_code FROM categories';
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function get_user($con) {
    $sql = 'SELECT users.id, users.user_name, users.user_password, users.email, users.contacts FROM users';
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function add_lot($con) {
    $sql = "INSERT INTO lots (title, category_id, lot_description, start_price, step, date_finish, img, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
    return $sql;
}
function add_user($con) {
    $sql = "INSERT INTO users(user_name,user_password,contacts,email) VALUES (?, ?, ?, ?);";
    return $sql;
}
function get_auth_user($con,$email) {
    $sql = "SELECT users.id, users.user_name, users.user_password, users.email, users.contacts FROM users WHERE email = '$email'";    
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function get_search_lots($con,$words) {
    $sql = "SELECT * FROM lots
    WHERE MATCH(title, lot_description) AGAINST('$words')";    
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function get_search_counts($con,$words) {
    $sql = "SELECT COUNT(id) as count FROM lots
    WHERE MATCH(title, lot_description) AGAINST('$words')";    
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_NUM);
}
function get_search_items($con,$words,$page_items,$offset) {
    $sql = "SELECT lots.id, lots.title, lots.start_price, lots.img, lots.date_finish, c.category_name
    FROM lots JOIN categories c ON c.id = lots.category_id
    WHERE MATCH(title, lot_description) AGAINST('$words')
    LIMIT $page_items OFFSET $offset";    
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}