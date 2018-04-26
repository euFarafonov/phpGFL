<?php

class Ajax extends ACore_admin {
    public function get_content_admin() {
        $table = $_POST['item'];
        $what = "*";
        $where = "";
        $order = " ORDER BY name ASC";
        
        if ($_POST['what']) {
            $what = $_POST['what'];
        }
        
        if ($_POST['whereName']) {
            $where = "WHERE " . $_POST['whereName'] . " = " . $_POST['whereValue'];
        }
        
        if ($_POST['order'] === 'no') {
            $order = "";
        }
        
        $query = "SELECT " . $what . " FROM " . $table . " " . $where . $order;
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