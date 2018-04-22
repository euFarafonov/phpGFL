<?php

class del_genre extends ACore_admin {
    public function get_content_admin() {
        $id = (int)$_GET['genre_id'];
        $this->del_genre($id);
        echo "<script>window.location.href='".PATH."admin/?view=admin_genres'</script>";
    }
}
?>