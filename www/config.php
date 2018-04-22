<?php defined('MYBOOK') or die('Access denied');

// название сайта
define('SITENAME', 'MYBOOK');
// домен
define('PATH', 'http://mybook.com/');
// модель
define('MODEL', 'model/model.php');
// контроллер
define('CONTROLLER', 'controller/controller.php');
// виды
define('VIEW', 'views/');
// активный шаблон
define('TEMPLATE', 'book1');
// путь к активному шаблону
define('PATH_TEMPLATE', PATH.VIEW.TEMPLATE.'/');
// основная папка вида - для подключения вида в конце контроллера
define('MAINFOLDER', VIEW.TEMPLATE);

// папка с картинками контента
define('BOOKIMG', PATH.'userfiles/book_img/baseimg/');
// папка с превьюшками
define('THUMBS', PATH.'userfiles/book_img/thumbs/');

// валюта
define('CURRENCY', 'грн.');

// максимально допустимый вес загружаемых картинок - 2 мегабайта
define('SIZE', 1024*1000*2);

// сервер БД
define('HOST', 'localhost');
// пользователь
define('USER', 'bookadmin');
// пароль
define('PASS', 'bookpass');
// БД
define('DB', 'mybook');
// название магазина
define('TITLE', 'Библиотека книг MYBOOK');

// email администратора сайта
define('ADMIN', 'eu.farafonov@gmail.com');

// папка шаблонов административной части
define('ADMIN_TEMPLATE', 'templates/');

// подключение к БД
$link = mysqli_connect(HOST, USER, PASS, DB) or die ('No connect to server');
// кодировка соединения с БД
mysqli_query($link, "SET NAMES 'UTF8'") or die ('Cann`t set charset');
?>