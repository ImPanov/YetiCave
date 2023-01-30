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
    $sql = 'SELECT categories.category_name, categories.character_code FROM categories';
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

