<?php

class del_book extends ACore_admin {
    public function get_content_admin() {
        $id = (int)$_GET['book_id'];
        $this->del_book($id);
        echo "<script>window.location.href='".PATH."admin/?view=admin'</script>";
    }
}
?>