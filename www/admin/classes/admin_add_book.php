<?php

class admin_add_book extends ACore_admin {
    public function get_content_admin() {
        $query = "SELECT id, name FROM author ORDER BY name ASC";
        $authors = $this->db->queryAll($query); //Массив всех авторов
        
        include 'templates/admin_authors.php';
    }
}
?>