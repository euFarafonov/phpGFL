<?php

class AdminContent extends ACore_admin {
    public function get_content_admin() {
        $query = "SELECT * FROM book ORDER BY name ASC";
        $books = $this->db->queryAll($query); //Массив всех книг
        
        include 'templates/admin_content.php';
    }
}
?>