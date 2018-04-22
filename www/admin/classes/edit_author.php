<?php

class edit_author extends ACore_admin {
    public function get_content_admin() {
        $id = (int)$_GET['author_id'];
        $author = $this->get_author_name($id);
        
        if ($_POST['name']) {
            if ($this->change_author($id)) {
                echo "<script>window.location.href='".PATH."admin/?view=admin_authors'</script>";
            } else {
                //echo "<script>window.location.href='".$_SERVER['HTTP_REFERER']."'</script>";
            }
        }
        
        include 'templates/edit_author.php';
    }
}
?>