<?php
require_once("data.php");
require_once("helpers.php");
require_once("database.php");
require_once("models.php");
require_once("validators.php");
if($is_auth == 0) {
    header("HTTP/1.1 403 ne ok");
    die();
}
if (!$con) {
    $error = mysqli_connect_error();
} else {
    $categories = get_categories($con);
    $categories_id = array_column($categories, "id");
}
$page_content = include_template("add-lot.php", [
    'categories' => $categories,
]);
if($_SERVER["REQUEST_METHOD"] === 'POST') {
    $required = ["lot-name","category","message","lot-rate","lot-step","lot-date"];
    $errors = [];

    $rules = [
        'category' => function ($value) use ($categories_id) {
            return validate_category($value, $categories_id);
        },
        "lot-rate" => function ($value) {
            return validate_number($value);
        },
        "lot-step" => function ($value) {
            return validate_number($value);
        },
        "lot-date" => function ($value) {
            return validate_date($value);
        }
    ];
    $lot = filter_input_array(INPUT_POST, [
        "lot-name" => FILTER_DEFAULT,
        "category" => FILTER_DEFAULT,
        "message" => FILTER_DEFAULT,
        "lot-rate" => FILTER_DEFAULT,
        "lot-step" => FILTER_DEFAULT,
        "lot-date" => FILTER_DEFAULT
    ], true);
    
    foreach($lot as $field => $value) {
        if(isset($rules[$field])) {
            $rule = $rules[$field];
            $errors[$field] = $rule($value);
        }
        if(in_array($field,$required) && empty($value)) {
            $errors[$field] = "Поле $field требуется заполнить";
        }
    }
    $errors = array_filter($errors);
    if (!empty($_FILES['img-lot']['name'])) {
        $tmp_name = $_FILES['img-lot']['tmp_name'];
        $name = $_FILES['img-lot']['name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type === "image/jpeg") {
            $ext = ".jpg";
        } else if ($file_type === "image/png") {
            $ext = ".png";
        }
        if ($ext) {
            $file_name = uniqid() . $ext;
            $lot["path"] = "uploads/" . $file_name;
            move_uploaded_file($_FILES["img-lot"]["tmp_name"], "uploads/". $file_name);
        } else {
            $errors['lot-img'] = "check format";
        }
    } else { 
        $errors['lot-img'] = "Загрузите файл";
    }
    if(count($errors)) {
        $page_content = include_template("add-lot.php", [
            'categories' => $categories,
            'errors' => $errors,
            "lot" => $lot,
        ]);
    } else {
        $lot[] = $user_id;
        $lot[] = $user_id;
        $sql = add_lot($con);
        $stmt = db_get_prepare_stmt($con, $sql, $lot);
        $res = mysqli_stmt_execute($stmt);   
        if ($res) {
            $lot_id = mysqli_insert_id($con);
            header("Location: /lot.php?id=" . $lot_id);
        } else {
            $error = mysqli_error($con);
        }       
    }  
        
}

$layout_content = include_template("base-layout.php", [
    'categories' => $categories,
    'content'=>$page_content,
    'title' => 'Добавление лота',
    "user_name" => $user_name,
    "is_auth" => $is_auth,
]);
print($layout_content);