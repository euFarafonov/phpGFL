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
            $res = mysqli_query($this->db, $query) or exit(mysqli_error($this->db));
            
            if (mysqli_num_rows($res) > 0) {
                while ($row_search = mysqli_fetch_assoc($res)) {
                    $result_search[] = $row_search;
                }
                $status = "OK";
            } else {
                $status = "ERROR";
                $msg = "По запросу <span>'$str'</span> ничего не найдено.";
            }
        }
        if ($status == "OK") {
            $answer = array("state" => $status, "result" => $result_search);
        } else {
            $answer = array("state" => $status, "result" => $msg);
        }
        echo json_encode($answer);
    }
}
?>