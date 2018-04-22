<?php

class edit_genre extends ACore_admin {
    public function get_content_admin() {
        $id = (int)$_GET['genre_id'];
        $genre = $this->get_genre_name($id);
        
        if ($_POST) {
            if ($this->change_genre($id)) {
                echo "<script>window.location.href='".PATH."admin/?view=admin_genres'</script>";
            } else {
                //echo "<script>window.location.href='".$_SERVER['HTTP_REFERER']."'</script>";
            }
        }
        
        include 'templates/edit_genre.php';
    }
}
?>