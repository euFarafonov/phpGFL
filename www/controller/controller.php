<?php defined('MYBOOK') or die('Access denied');
session_start();

// подключение модели
require_once MODEL;

// подключение библиотеки функций
require_once 'functions/functions.php';

// получение динамичной части шаблона
$view = (empty($_GET['view'])) ? 'home' : $_GET['view'];

// поиск
if($_POST['search']){
    search();
    exit();
}

$authors = get_authors();
$genres = get_genres();

switch($view) {
    case('home') :
        $auth_id = 0;
        $genre_id = 0;
        $page_header = 'Каталог книг';
        
        if ($_GET['author']) {
            $auth_id = (int)$_GET['author'];
            $page_header = 'Книги автора "' . $authors[$auth_id] . '"';
        }
        
        if ($_GET['genre']) {
            $genre_id = (int)$_GET['genre'];
            $page_header = 'Книги в жанре "' . $genres[$genre_id] . '"';
        }
        
        $books = get_books($auth_id, $genre_id);
    break;
    
    case('book') :
        $book_id = (int)$_GET['book_id'];
        $book_info = get_book_info($book_id);
        
        if(isset($_POST['surname'])) {
            order($book_info);
        }
    break;
    
    default:
        $view = 'home';
        
    break;
}

// подключение вида
require_once $_SERVER['DOCUMENT_ROOT'].'/'.MAINFOLDER.'/index.php';
?>