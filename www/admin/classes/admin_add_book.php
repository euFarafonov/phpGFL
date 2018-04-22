<?php

class admin_add_book extends ACore_admin {
    public function get_content_admin() {
        $query = "SELECT id, name FROM author ORDER BY name ASC";
        $res = mysqli_query($this->db, $query) or exit(mysqli_error($this->db));
        $authors = array(); //Массив всех авторов
        
        while($row = mysqli_fetch_assoc($res)){
            $authors[] = $row;
        }
        
        include 'templates/admin_authors.php';
    }
}
?>