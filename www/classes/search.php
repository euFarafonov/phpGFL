<?php

class search extends ACore {
    public function get_content() {
        $str = trim(strip_tags($_POST['str']));
        $result_search = array(); // результаты поиска
        
        if (mb_strlen($str, 'UTF-8') < 3) {
            $status = "ERROR";
            $msg = "Поисковый запрос должен содержать не менее 3 символов!";
        } else {
            $query = "SELECT id, name FROM book WHERE (name LIKE '%{$str}%') ORDER BY name ASC";
            $arr = $this->db->queryAll($query);
            
            if (count($arr) > 0) {
                $status = "OK";
            } else {
                $status = "ERROR";
                $msg = "По запросу <span>'$str'</span> ничего не найдено.";
            }
        }
        if ($status == "OK") {
            $answer = array("state" => $status, "result" => $arr);
        } else {
            $answer = array("state" => $status, "result" => $msg);
        }
        echo json_encode($answer);
    }
}
?>