<?php

class admin_genres extends ACore_admin {
    public function get_content_admin() {
        $genres = $this->genres;
        
        include 'templates/admin_genres.php';
    }
}
?>