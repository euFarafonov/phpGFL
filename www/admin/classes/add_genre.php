<?php

class add_genre extends ACore_admin {
    public function get_content_admin() {
        if ($_POST) {
            if ($this->insert_genre()) {
                echo "<script>window.location.href='".PATH."admin/?view=admin_genres'</script>";
            } else {
                //echo "<script>window.location.href='".$_SERVER['HTTP_REFERER']."'</script>";
            }
        }
        
        include 'templates/add_genre.php';
    }
}
?>