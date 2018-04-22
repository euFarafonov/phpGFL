<?php

class del_img extends ACore_admin {
    public function get_content_admin() {
        $id = (int)$_POST['img_id'];
        $query = "UPDATE book SET img = '' WHERE id = $id";
        $res = mysqli_query($this->db, $query) or exit(mysqli_error($this->db));
        
        if (mysqli_affected_rows($this->db) > 0) {
            $answer = array("state" => "OK");
        } else {
            $answer = array("state" => "ERROR");
        }
        echo json_encode($answer);
    }
}
?>