<?php
require_once("helpers.php");
require_once("database.php");
require_once("models.php");
require_once("data.php");
if (!$con) {
    $error = mysqli_connect_error();
} else {    
    $categories = get_categories($con);
    $goods = get_new_lots($con);
}

$page_content = include_template("main.php", [
    "categories"=>$categories,
    "goods"=>$goods
]);

$layout_content = include_template("main-layout.php", [
    "user_name"=> $user_name,
    "is_auth"=> $is_auth,
    "content"=> $page_content,
    "categories"=>$categories,
    "title"=>"Главная"
]);

print($layout_content);
