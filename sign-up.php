<?php
require_once("data.php");
require_once("helpers.php");
require_once("database.php");
require_once("models.php");
require_once("validators.php");
if($is_auth == 1) {
    header("HTTP/1.1 403 ne ok");
    die();
}
if (!$con) {
    $error = mysqli_connect_error();
} else {
    $categories = get_categories($con);
}
$page_content = include_template("sign-up.php", []);

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $required = ['email', 'password', 'name', 'message'];
    $errors = [];

    $rules = [
        'name' => function ($value) {
            return validate_length($value, 4, 32);
        },
        'email' => function ($value) {
            return validate_email($value);
        },
        'message' => function ($value) {
            return validate_length($value, 4, 255);
        },
        'password' => function ($value) {
            return validate_length($value, 4, 64);
        }
    ];

    $user = filter_input_array(INPUT_POST, [
        'name' => FILTER_DEFAULT,
        'password' => FILTER_DEFAULT,
        'message' => FILTER_DEFAULT,
        'email' => FILTER_DEFAULT,
    ], true);

    foreach($user as $field => $value) {
        if(isset($rules[$field])) {
            $rule = $rules[$field];
            $errors[$field] = $rule($value);
        }
        if(in_array($field,$required) && empty($value)) {
            $errors[$field] = "Поле $field требуется заполнить";
        }
    }

    $errors = array_filter($errors);

    if (count($errors)) {
        if (count($errors)) {
            $page_content = include_template("sign-up.php", [
                'errors' => $errors,
                "user" => $user,
            ]);
        }
    } else {
        $users_data = get_user($con);
        $emails = array_column($users_data, 'email');
        $names = array_column($users_data, 'user_name');
        if(in_array($user['name'],$names)) {
            $errors['name'] = 'Такое имя уже существует';
        }
        if(in_array($user['email'],$emails)) {
            $errors['email'] = 'Такой email уже существует';
        }
        if (count($errors)) {
            $page_content = include_template("sign-up.php", [
                'errors' => $errors,
                "user" => $user,
            ]);
        } else {
            $sql = add_user($con);
            $user['password'] = password_hash($user["password"], PASSWORD_DEFAULT);
            $stmt = db_get_prepare_stmt($con, $sql, $user);
            $res = mysqli_stmt_execute($stmt);

            if($res) {
                header('Location: /login.php');
            } else {
                $error = mysqli_error($con);
            }
        }
    }
}

$layout_content = include_template("base-layout.php", [
    'categories' => $categories,
    'content'=>$page_content,
    'title' => 'Регистрация',
    "is_auth" => 0,
]);
print($layout_content);