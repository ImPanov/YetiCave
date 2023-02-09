<?php
require_once("data.php");
require_once("helpers.php");
require_once("database.php");
require_once("models.php");
require_once("validators.php");
if (!$con) {
    $error = mysqli_connect_error();
} else {
    $categories = get_categories($con);
}
$page_content = include_template("login.php", []);

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $required = ['email', 'password'];
    $errors = [];

    $rules = [
        'email' => function ($value) {
            return validate_email($value);
        },
        'password' => function ($value) {
            return validate_length($value, 4, 64);
        }
    ];

    $user = filter_input_array(INPUT_POST, [
        'password' => FILTER_DEFAULT,
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
            $page_content = include_template("login.php", [
                'errors' => $errors,
                "user" => $user,
            ]);        
    } else {
        $users_data = get_auth_user($con,$user['email']);
        if($users_data) {
            if (password_verify($user['password'],$users_data[0]['user_password'])) {
                $issession = session_start();
                    $_SESSION['name'] = $users_data[0]['user_name'];
                    $_SESSION['id'] = $users_data[0]['id'];
                    header('Location: /index.php');
            } else {
            $errors['fail'] = 'Неверный пароль';
            $page_content = include_template("login.php", [
                'errors' => $errors,
                "user" => $user,
            ]);  
            }
        } else {
            $errors['fail'] = 'Неверный логин';
            $page_content = include_template("login.php", [
                'errors' => $errors,
                "user" => $user,
            ]);
        }
    }
}

$layout_content = include_template("base-layout.php", [
    'categories' => $categories,
    'content'=>$page_content,
    'title' => 'Вход',
    "user_name"=> $user_name,
    "is_auth"=> $is_auth,
]);
print($layout_content);