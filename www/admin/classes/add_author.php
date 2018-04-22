<?php

class add_author extends ACore_admin {
    public function get_content_admin() {
        if ($_POST) {
            if ($this->insert_author()) {
                echo "<script>window.location.href='".PATH."admin/?view=admin_authors'</script>";
            } else {
                //echo "<script>window.location.href='".$_SERVER['HTTP_REFERER']."'</script>";
            }
        }
        
        include 'templates/add_author.php';
    }
}
?>