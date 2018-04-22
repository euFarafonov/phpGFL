<?php

class add_book extends ACore_admin {
    public function get_content_admin() {
        if ($_POST) {
            if ($this->insert_book()) {
                echo "<script>window.location.href='".PATH."admin/?view=admin'</script>";
            } else {
                //echo "<script>window.location.href='".$_SERVER['HTTP_REFERER']."'</script>";
            }
        }
        
        $authors = $this->authors;
        $genres = $this->genres;
        
        include 'templates/add_book.php';
    }
}
?>