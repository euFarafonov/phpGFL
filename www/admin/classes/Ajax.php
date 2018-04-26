<?php

class Ajax extends ACore_admin {
    public function get_content_admin() {
        $item = $_POST['item'];
        $where = "";
        
        if ($_POST['whereName']) {
            $where = "WHERE " . $_POST['whereName'] . " = " . $_POST['whereValue'] . " ";
        }
        
        $query = "SELECT * FROM " . $item . " " . $where . "ORDER BY name ASC";
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