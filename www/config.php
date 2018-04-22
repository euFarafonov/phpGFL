<?php defined('MYBOOK') or exit('Access denied');

// название сайта
define('SITENAME', 'MYBOOK');
// название магазина
define('TITLE', 'Библиотека книг MYBOOK');
// домен
define('PATH', 'http://mybook.com/');
// директория щаблонов пользовательской части
define('TEMPLATE', PATH.'templates/');
// директория шаблонов административной части
define('ADMIN_TEMPLATE', PATH.'admin/');
// директория с картинками контента
define('BOOKIMG', PATH.'userfiles/book_img/baseimg/');
// директория с файлами css, js, картинок для шаблона
define('LIB', PATH.'lib/');

// сервер БД
define('HOST', 'localhost');
// пользователь
define('USER', 'bookadmin');
// пароль
define('PASS', 'bookpass');
// БД
define('DB', 'mybook');

// валюта
define('CURRENCY', 'грн.');
// максимально допустимый вес загружаемых картинок - 2 мегабайта
define('SIZE', 1024*1000*2);
// email администратора сайта
define('ADMIN', 'eu.farafonov@gmail.com');
?>