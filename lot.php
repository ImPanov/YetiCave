<?php
require_once("data.php");
require_once("helpers.php");
require_once("database.php");
require_once("models.php");

if (!$con) {
    $error = mysqli_connect_error();
} else {
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    if ($id) {
        $categories = get_categories($con);
        $good = get_lot($con, $id);
    } else {
        http_response_code(404);
        die();
    }
}

$page_content = include_template("lot.php", [
    'good' => $good[0],
    'title' => $good[0]['title'],
    'is_auth' => $is_auth,
]);

$layout_content = include_template("base-layout.php", [
    'categories' => $categories,
    "user_name" => $user_name,
    "is_auth" => $is_auth,
    "content" => $page_content,
    'good' => $good[0],
    'title' => $good[0]['category_name']
]);

print($layout_content);