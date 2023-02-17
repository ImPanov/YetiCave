<?php
require_once("helpers.php");
require_once("database.php");
require_once("models.php");
require_once("data.php");

if (!$con) {
    $error = mysqli_connect_error();
} else {    
    $categories = get_categories($con);
    
    $goods = isset($_GET['category']) ? get_lots($con,$_GET['category']) : get_lots($con);
}
$page_content = include_template("all-lots.php", [
    "goods"=>$goods
]);

$layout_content = include_template("base-layout.php", [
    "user_name"=> $user_name,
    "is_auth"=> $is_auth,
    "content"=> $page_content,
    "categories"=>$categories,
    "title"=>"Главная"
]);

print($layout_content);
 