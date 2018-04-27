<?php

class AjaxAdd extends ACore_admin {
    public function get_content_admin() {
        $table = $_POST['item'];
        $name = $_POST['name'];
        
        //$what = "*";
        //$where = "";
        //$order = " ORDER BY name ASC";
        /*
        if ($_POST['what']) {
            $what = $_POST['what'];
        }
        
        if ($_POST['whereName']) {
            $where = "WHERE " . $_POST['whereName'] . " = " . $_POST['whereValue'];
        }
        
        if ($_POST['order'] === 'no') {
            $order = "";
        }
        */
        $query = "INSERT INTO " . $table . " (name) VALUES ('$name')";
        $res = $this->db->insert($query);
        
        if ($res) {
            $answer = array("state" => "OK", "res" => $res);
        } else {
            $answer = array("state" => "ERROR", "res" => $res);
        }
        echo json_encode($answer);
    }
}
?>