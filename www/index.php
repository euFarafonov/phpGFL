<?php define('MYBOOK', TRUE);
session_start();

require_once 'config.php';
require_once 'classes/ACore.php';

// поиск
if ($_POST['search']) {
    include 'classes/search.php';
    $search = new search();
    $search->get_content();
    exit();
}

$class = ($_GET['view']) ? trim(strip_tags($_GET['view'])) : 'home';

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
}
?>