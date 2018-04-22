<?php

class admin extends ACore_admin {
    public function get_content_admin() {
        $query = "SELECT id, name, img FROM book ORDER BY name ASC";
        $res = mysqli_query($this->db, $query) or exit(mysqli_error($this->db));
        $books = array(); //Массив всех книг
        
        while ($row = mysqli_fetch_assoc($res)) {
            $books[] = $row;
        }
        
        include 'templates/admin_books.php';
    }
}
?>