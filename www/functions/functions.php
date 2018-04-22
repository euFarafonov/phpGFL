<?php defined('MYBOOK') or die('Access denied');

/* ===== Распечатка массива ===== */
function print_arr($arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}
/* ===== Распечатка массива ===== */

/* ===== Фильтрация входящих данных ===== */
function clear($var){
    global $link;
    $var = mysqli_real_escape_string($link, strip_tags($var));
    return $var;
}
/* ===== Фильтрация входящих данных ===== */

/* ===== Редирект ===== */
function redirect($http = false){
    if($http) $redirect = $http;
        else $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    header("Location: $redirect");
    exit;
}
/* ===== Редирект ===== */
?>