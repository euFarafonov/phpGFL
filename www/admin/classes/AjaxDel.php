<?php

class AjaxDel extends ACore_admin {
    public function get_content_admin() {
        $table = $_POST['item'];
        $id = (int)$_POST['id'];
        
        $query = "DELETE FROM " . $table . " WHERE id = " . $id;
        $res = $this->db->execute($query);
        
        if ($res) {
            $answer = array("state" => "OK", "res" => $res);
        } else {
            $answer = array("state" => "ERROR", "res" => $res);
        }
        echo json_encode($answer);
    }
}
?>