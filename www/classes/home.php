<?php

class home extends ACore {
    public function get_content() {
        $auth_id = 0;
        $genre_id = 0;
        $page_header = 'Каталог книг';
        
        if ($_GET['author']) {
            $auth_id = (int)$_GET['author'];
            $authors = $this->get_authors();
            $page_header = 'Книги автора "' . $authors[$auth_id] . '"';
        }
        
        if ($_GET['genre']) {
            $genre_id = (int)$_GET['genre'];
            $genres = $this->get_genres();
            $page_header = 'Книги в жанре "' . $genres[$genre_id] . '"';
        }
        
        $query = "SELECT id, name, about, price, img FROM book";
        
        if ($auth_id) {
            $query .= " JOIN book_author ON book.id = book_author.book_id WHERE book_author.author_id = $auth_id";
        }
        
        if ($genre_id) {
            $query .= " JOIN book_genre ON book.id = book_genre.book_id WHERE book_genre.genre_id = $genre_id";
        }
        
        $res = mysqli_query($this->db, $query) or die(mysqli_error($this->db));
        
        $books = array();
        while ($row = mysqli_fetch_assoc($res)) {
            $books[] = $row;
        }
        
        include 'templates/home.php';
    }
}
?>