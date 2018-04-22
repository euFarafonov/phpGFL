<?php

class del_author extends ACore_admin {
    public function get_content_admin() {
        $id = (int)$_GET['author_id'];
        $this->del_author($id);
        echo "<script>window.location.href='".PATH."admin/?view=admin_authors'</script>";
    }
}
?>