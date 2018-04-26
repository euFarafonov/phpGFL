<?php define('MYBOOK', TRUE);
session_start();

require_once '../config.php';
require_once '../classes/Database.php';
require_once 'classes/ACore_admin.php';

// удаление картинок товара
if ($_POST['check'] === 'dell_img') {
    include 'classes/del_img.php';
    $del_img = new del_img();
    $del_img->get_content_admin();
    exit();
}

// получение всех книг при запросе ajax
if ($_POST['check'] === 'ajax') {
    include 'classes/Ajax.php';
    $ajax = new Ajax();
    $ajax->get_content_admin();
    exit();
}
/*
$class = ($_GET['view']) ? trim(strip_tags($_GET['view'])) : 'admin';

if (file_exists('classes/'.$class.'.php')) {
    include 'classes/'.$class.'.php';
    
    if (class_exists($class)) {
        $obj = new $class;
        $obj->get_body();
    } else {
        exit("<p class='error'>Нет нужного класса!</p>");
    }
} else {
    exit("<p class='error'>Нет нужного файла!</p>");
}*/
include 'classes/AdminContent.php';
$obj = new AdminContent();
$obj->get_body();
?>