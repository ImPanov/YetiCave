<?php
function validate_length($value,$min_size,$max_size) {
    if ($value) {
        $len = strlen($value);
        if ($len < $min_size or $len > $max_size) {
            return "значение должно быть от $min_size до $max_size";
        }
    }
    return null;
}
function validate_category($id, $allowed_list) {
    if ($id) {
        if(!in_array($id,$allowed_list)) {
            return "this catergory haven't got categories";
        }
    }
    return null;
}

function validate_number($num) {
    if (!filter_var($num, FILTER_SANITIZE_NUMBER_INT)) {
        return "NO NUMBER";
    }
    if($num<0) {
        return "less zero";
    }
    return null;
}
function validate_img($img) {
    if($img) {
        if(!(mime_content_type($img)=='image/jpeg'|'image/png')) {
            return "this format not support!";
        }
    }
    return null;
}

function validate_date($date) {
    if (is_date_valid($date)) {
        $now = date_create("now");
        $d = date_create($date);
        $diff = date_diff($d, $now);
        $interval = $diff->format("%d");

        if ($interval < 1) {
            return "Дата должна быть больше текущей не менее чем на один день";
        };
    } else {
        return "Содержимое поля «дата завершения» должно быть датой в формате «ГГГГ-ММ-ДД»";
    }
    return null;
    
}
function validate_email($email) {
    if ($email) {
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            return "Введите корректный email";
        }
    }
    return null;
}