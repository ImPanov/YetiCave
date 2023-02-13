<?php
require_once("data.php");
require_once("helpers.php");
require_once("database.php");
require_once("models.php");
require_once("validators.php");

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
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $required = ['cost'];
    $errors = [];

    $rules = [
        'cost' => function ($value) {
            return validate_number($value);
        },
    ];

    $bet = filter_input_array(INPUT_POST, [
        'cost' => FILTER_DEFAULT,
    ], true);

    foreach($bet as $field => $value) {
        if(isset($rules[$field])) {
            $rule = $rules[$field];
            $errors[$field] = $rule($value);
        }
        if(in_array($field,$required) && empty($value)) {
            $errors[$field] = "Поле $field требуется заполнить";
        }
    }
    $errors = array_filter($errors);
    if(count($errors)) {
        $page_content = include_template("lot.php", [
            'good' => $good[0],
            'title' => $good[0]['title'],
            'is_auth' => $is_auth,
            'errors' => $errors,
        ]);
    } else {
    if($bet['cost']>=$good[0]['step']+$good[0]['start_price']){
        mysqli_begin_transaction($con);
        $add_bet = get_query_add_bet($con,$bet['cost'],$good[0]['id'],$user_id);
        $bet_lot = get_query_update_lot_bet($con,$bet['cost'],$good[0]['id']);
        $winner_lot = get_query_update_lot_winner($con,$good[0]['id'],$user_id);
        if ($add_bet && $bet_lot && $winner_lot) {
            mysqli_commit($con);
          } else {
            mysqli_rollback($con);
          }
          header("Refresh:0");
    } else {
        $errors['cost']='Ставка ниже требуемой';
        $page_content = include_template("lot.php", [
            'good' => $good[0],
            'title' => $good[0]['title'],
            'is_auth' => $is_auth,
            'errors' => $errors,
        ]);
    }
    }
}


$layout_content = include_template("base-layout.php", [
    'categories' => $categories,
    "user_name" => $user_name,
    "is_auth" => $is_auth,
    "content" => $page_content,
    'good' => $good[0],
    'title' => $good[0]['category_name']
]);

print($layout_content);