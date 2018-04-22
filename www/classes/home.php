<?php

class home extends ACore {
    public function get_content() {
        $auth_id = 0;
        $genre_id = 0;
        $page_header = 'Каталог книг';
        
        if ($_GET['author']) {
            $auth_id = (int)$_GET['author'];
            $authors = $this->get_authors();
            
            $auth_name = $this->searchEl($authors, $auth_id);
            $page_header = 'Книги автора "' . $auth_name . '"';
        }
        
        if ($_GET['genre']) {
            $genre_id = (int)$_GET['genre'];
            $genres = $this->get_genres();
            
            $genre_name = $this->searchEl($genres, $genre_id);
            $page_header = 'Книги автора "' . $genre_name . '"';
        }
        
        $query = "SELECT id, name, about, price, img FROM book";
        
        if ($auth_id) {
            $query .= " JOIN book_author ON book.id = book_author.book_id WHERE book_author.author_id = $auth_id";
        }
        
        if ($genre_id) {
            $query .= " JOIN book_genre ON book.id = book_genre.book_id WHERE book_genre.genre_id = $genre_id";
        }
        
        $books = $this->db->queryAll($query);
        
        include 'templates/home.php';
    }
    
    private function searchEl($arr, $el) {
        foreach ($arr as $item) {
            if ($item['id'] == $el) {
                $name = $item['name'];
                break;
            }
        }
        
        return $name;
    }
}
?>