<?php define('MYBOOK', TRUE);
session_start();

// подключение файла конфигурации
require_once '../config.php';
// подключение файла функций пользовательской части
require_once '../functions/functions.php';
// подключение файла функций административной части
require_once 'functions/functions.php';

// получение динамичной части шаблона
$view = (empty($_GET['view'])) ? 'books' : $_GET['view'];

switch($view) {
/* ==================== РАБОТА С КНИГАМИ ==================== */
    case('books') :
        $books = get_books();
    break;
    
    case('add_book') :
        $authors = get_authors();
        $genres = get_genres();
        
        if ($_POST) {
            if (add_book()) redirect('?view=books');
                else redirect();
        }
    break;
    
    case('edit_book') :
        // удаление картинок товара
        if ($_POST['check'] === 'dell_img') {
            $res = del_img();
            exit($res);
        }
        
        // обычная загрузка страницы
        $id = (int)$_GET['book_id'];
        $book = get_book($id); // данные о книге
        $authors = get_authors(); // массив всех авторов
        $genres = get_genres(); // массив всех жанров
        $authors_id_arr = get_authors_id($id); // массив всех авторов конкретной книги
        $genres_id_arr = get_genres_id($id); // массив всех жанров конкретной книги
        
        if ($_POST) {
            if (edit_book($id, $authors_id_arr, $genres_id_arr)) redirect('?view=books');
                else redirect();
        }
    break;
    
    case('del_book') :
        $id = (int)$_GET['book_id'];
        del_book($id);
        redirect();
    break;

/* ==================== РАБОТА С АВТОРАМИ ==================== */    
    case('authors') :
        $authors = get_authors();
    break;
    
    case('add_author') :
        if ($_POST) {
            if (add_author()) redirect('?view=authors');
                else redirect();
        }
    break;
    
    case('edit_author') :
        $id = (int)$_GET['author_id'];
        $author = get_author($id);
        
        if ($_POST) {
            if (edit_author($id)) redirect('?view=authors');
                else redirect();
        }
    break;
    
    case('del_author') :
        $id = (int)$_GET['author_id'];
        del_author($id);
        redirect();
    break;
    
/* ==================== РАБОТА С ЖАНРАМИ ==================== */
    case('genres') :
        $genres = get_genres();
    break;
    
    case('add_genre') :
        if ($_POST) {
            if (add_genre()) redirect('?view=genres');
                else redirect();
        }
    break;
    
    case('edit_genre') :
        $id = (int)$_GET['genre_id'];
        $genre = get_genre($id);
        
        if ($_POST) {
            if (edit_genre($id)) redirect('?view=genres');
                else redirect();
        }
    break;
    
    case('del_genre') :
        $id = (int)$_GET['genre_id'];
        del_genre($id);
        redirect();
    break;
    
    default :
        $view = 'books';
        $books = get_books();
    break;
}

// HEADER
include ADMIN_TEMPLATE.'header.php';
// LEFTBAR
include ADMIN_TEMPLATE.'leftbar.php';
// CONTENT
include ADMIN_TEMPLATE.$view.'.php';
// FOOTER
include ADMIN_TEMPLATE.'footer.php';
?>