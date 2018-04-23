<?php

class Database {
    private $linkDb;
    
    public function __construct($host, $user, $pass, $db) {
        $this->linkDb = mysqli_connect($host, $user, $pass, $db);
        
        if (!$this->linkDb) {
            exit('No connect to server');
        }
        mysqli_query($this->linkDb, "SET NAMES 'UTF8'") or exit('Cann`t set charset');
    }
    
    public function queryAll($sql) {
        $res = mysqli_query($this->linkDb, $sql) or exit(mysqli_error($this->linkDb));
        $arr = array();
        
        while ($row = mysqli_fetch_assoc($res)) {
            $arr[] = $row;
        }
        
        return $arr;
    }
    
    public function queryOne($sql) {
        $res = mysqli_query($this->linkDb, $sql) or exit(mysqli_error($this->linkDb));
        $str = null;
        $str = mysqli_fetch_assoc($res);
        
        return $str;
    }
    
    public function execute($sql) {
        $res = mysqli_query($this->linkDb, $sql) or exit(mysqli_error($this->linkDb));
        return $res;
    }
    
    public function check($sql) {
        $res = mysqli_query($this->linkDb, $sql) or exit(mysqli_error($this->linkDb));
        return (mysqli_num_rows($res) > 0) ? true : false;
    }
    
    public function insert($sql) {
        $res = mysqli_query($this->linkDb, $sql) or exit(mysqli_error($this->linkDb));
        $id = (mysqli_affected_rows($this->linkDb) > 0) ? mysqli_insert_id($this->linkDb) : 0;
        
        return $id;
    }
}
?>