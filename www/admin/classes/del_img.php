<?php

class del_img extends ACore_admin {
    public function get_content_admin() {
        $id = (int)$_POST['img_id'];
        $query = "UPDATE book SET img = '' WHERE id = $id";
        
        if ($this->db->execute($query)) {
            $answer = array("state" => "OK");
        } else {
            $answer = array("state" => "ERROR");
        }
        echo json_encode($answer);
    }
}
?>