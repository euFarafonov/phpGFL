<?php

class edit_book extends ACore_admin {
    public function get_content_admin() {
        $id = (int)$_GET['book_id'];
        $book = $this->get_book_info($id); // данные о книге
        
        $authors_id_arr = $this->get_authors_id($id); // массив всех авторов конкретной книги
        $genres_id_arr = $this->get_genres_id($id); // массив всех жанров конкретной книги
        $authors = $this->authors;
        $genres = $this->genres;
        
        if ($_POST) {
            if ($this->change_book($id, $authors_id_arr, $genres_id_arr)) {
                echo "<script>window.location.href='".PATH."admin/?view=admin'</script>";
            } else {
                //echo "<script>window.location.href='".$_SERVER['HTTP_REFERER']."'</script>";
            }
        }
        
        include 'templates/edit_book.php';
    }
}
?>