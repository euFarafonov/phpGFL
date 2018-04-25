<?php

class Ajax extends ACore_admin {
    public function get_content_admin() {
        $item = $_POST['item'];
        $query = "SELECT * FROM ".$item." ORDER BY name ASC";
        $res = $this->db->queryAll($query);
        
        if ($res) {
            $answer = array("state" => "OK", "res" => $res);
        } else {
            $answer = array("state" => "ERROR", "res" => null);
        }
        echo json_encode($answer);
    }
}
?>