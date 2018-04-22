<?php defined('MYBOOK') or die('Access denied');

/* ===== Массив всех книг ===== */
function get_books($auth_id, $genre_id) {
    global $link;
    $query = "SELECT id, name, about, price, img FROM book";
    
    if ($auth_id) {
        $query .= " JOIN book_author ON book.id = book_author.book_id WHERE book_author.author_id = $auth_id";
    }
    
    if ($genre_id) {
        $query .= " JOIN book_genre ON book.id = book_genre.book_id WHERE book_genre.genre_id = $genre_id";
    }
    
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    
    $books = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $books[] = $row;
    }
    return $books;
}
/* ===== Массив всех книг ===== */

/* ===== Массив всех авторов ===== */
function get_authors() {
    global $link;
    $query = "SELECT id, name FROM author";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    
    $authors = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $authors[$row['id']] = $row['name'];
    }
    return $authors;
}
/* ===== Массив всех авторов ===== */

/* ===== Массив всех жанров ===== */
function get_genres() {
    global $link;
    $query = "SELECT id, name FROM genre";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    
    $genres = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $genres[$row['id']] = $row['name'];
    }
    return $genres;
}
/* ===== Массив всех жанров ===== */

/* ===== Информация по конкретной книге ===== */
function get_book_info($book_id) {
    global $link;
    $query = "SELECT id, name, about, price, img FROM book WHERE id = $book_id";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    $book = mysqli_fetch_assoc($res);
    
    return $book;
}
/* ===== Информация по конкретной книге ===== */

/* ===== Оформление заказа ===== */
function order($book_info) {
    $surname = clear(trim($_POST['surname']));
    $name = clear(trim($_POST['name']));
    $secondname = clear(trim($_POST['secondname']));
    $address = clear(trim($_POST['address']));
    $email = clear(trim($_POST['email']));
    $qnt = (int)$_POST['quantity'];
    
    // письмо покупателю
    $subject_user = "Заказ книги в библиотеке MYBOOK";
    $mail_user = "Здравствуйте, " . $name . ".
Благодарим Вас за заказ товара на сайте библиотеки MYBOOK!\r\n
Заказанная книга: " . $book_info['name'] . ".
Цена книги: " . $book_info['price'] . " грн.
Количество экземпляров: " . $qnt . ".\r\n
С уважением,
администрация сайта MYBOOK";
    
    $headers = "MIME-Version: 1.0 \r\n"; 
    $headers .= "Content-type: text/plain; charset=utf-8 \r\n";
	$headers .= "FROM: MYBOOK <". ADMIN .">\r\n";
	$headers .= "Reply-To: MYBOOK <". ADMIN .">\r\n";
    mail($email, $subject_user, $mail_user, $headers);
    
    // письмо администратору
    $subject_admin = "Заказ книги в библиотеке MYBOOK";
    $mail_admin = "Новый заказ на сайте MYBOOK.\r\n
Данные о покупателе и заказанной книге:
- Фамилия: " . $surname . "
- Имя: " . $name . "
- Отчество: " . $secondname . "
- Адрес доставки: " . $address . "
- Email: " . $email . "\r\n
- Заказанная книга: " . $book_info['name'] . "
- Цена книги: " . $book_info['price'] . " грн.
- Количество экземпляров: " . $qnt;
    
    mail(ADMIN, $subject_admin, $mail_admin, $headers);
}
/* ===== Оформление заказа ===== */

/* ===== ПОИСК ===== */
function search(){
    $search = clear($_POST['str']);
    $result_search = array(); // результаты поиска
    
    if(mb_strlen($search, 'UTF-8') < 3){
        $status = "ERROR";
        $msg = "Поисковый запрос должен содержать не менее 3 символов!";
    }else{
        global $link;
        $query = "SELECT id, name FROM book WHERE (name LIKE '%{$search}%') ORDER BY name ASC";
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        
        if(mysqli_num_rows($res) > 0){
            while($row_search = mysqli_fetch_assoc($res)){
                $result_search[] = $row_search;
            }
            $status = "OK";
        }else{
            $status = "ERROR";
            $msg = "По запросу <span>'$search'</span> ничего не найдено.";
        }
    }
    if($status == "OK"){
        $answer = array("state" => $status, "result" => $result_search);
    }else{
        $answer = array("state" => $status, "result" => $msg);
    }
    echo json_encode($answer);
}
/* ===== ПОИСК ===== */
?>