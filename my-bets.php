<?php
require_once("helpers.php");
require_once("database.php");
require_once("models.php");
require_once("data.php");
if (!$con) {
    $error = mysqli_connect_error();
} else {    
    $categories = get_categories($con);
    $goods = history_bet($con,$user_id);
}

$page_content = include_template("my-bets.php", [
    "goods"=>$goods,
    "user_id"=>$user_id
]);

$layout_content = include_template("base-layout.php", [
    "user_name"=> $user_name,
    "is_auth"=> $is_auth,
    "content"=> $page_content,
    "categories"=>$categories,
    "title"=>"Главная"
]);

print($layout_content);
