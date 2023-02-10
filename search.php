<?php
require_once("helpers.php");
require_once("database.php");
require_once("models.php");
require_once("data.php");
if (!$con) {
    $error = mysqli_connect_error();
} else {    
    $categories = get_categories($con);
}
$search = htmlspecialchars($_GET['search']);

if($search) {    
    $count_lots = get_search_counts($con,$search);
    $cur_page = $_GET['page'] ?? 1;
    $page_itmes = 9;
    $page_counts = ceil($count_lots[0][0]/$page_itmes);
    $offset = ($cur_page-1)*$page_counts;
    $pages = range(1,$page_counts);

    $goods = get_search_items($con, $search, $page_itmes, $offset);
} else {
    $page_counts = 0;
    $goods = [];
    $pages = 0;
}

$page_content = include_template("search.php", [
    "page_counts" => $page_counts,
    "pages" => $pages,
    "search" => $search,
    "goods" => $goods
]);

$layout_content = include_template("base-layout.php", [
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "categories" => $categories,
    "content" => $page_content,
    "title" => $search
]);

print($layout_content);
