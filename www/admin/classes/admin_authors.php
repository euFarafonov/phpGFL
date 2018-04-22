<?php

class admin_authors extends ACore_admin {
    public function get_content_admin() {
        $authors = $this->authors;
        
        include 'templates/admin_authors.php';
    }
}
?>