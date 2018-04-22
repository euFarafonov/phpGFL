<?php
abstract class ACore {
    protected $db;
    
    public function __construct() {
        $this->db = mysqli_connect(HOST, USER, PASS, DB);
        
        if (!$this->db) {
            exit('No connect to server');
        }
        mysqli_query($this->db, "SET NAMES 'UTF8'") or exit('Cann`t set charset');
    }
    
    /* ===== HEADER ===== */
    protected function get_header() {
        include 'templates/header.php';
    }
    
    /* ===== Массив всех авторов ===== */
    protected function get_authors() {
        $query = "SELECT id, name FROM author ORDER BY name ASC";
        $res = mysqli_query($this->db, $query) or exit(mysqli_error($this->db));
        
        $authors = array();
        while ($row = mysqli_fetch_assoc($res)) {
            $authors[$row['id']] = $row['name'];
        }
        
        return $authors;
    }
    
    /* ===== Массив всех жанров ===== */
    protected function get_genres() {
        $query = "SELECT id, name FROM genre ORDER BY name ASC";
        $res = mysqli_query($this->db, $query) or exit(mysqli_error($this->db));
        
        $genres = array();
        while ($row = mysqli_fetch_assoc($res)) {
            $genres[$row['id']] = $row['name'];
        }
        
        return $genres;
    }
    
    /* ===== LEFTBAR ===== */
    protected function get_aside() {
        $authors = $this->get_authors();
        $genres = $this->get_genres();
        
        include 'templates/aside.php';
    }
    
    /* ===== FOOTER ===== */
    protected function get_footer() {
        include 'templates/footer.php';
    }
    
    /* ===== MAIN CONTENT ===== */
    public function get_body() {
        $this->get_header();
        $this->get_aside();
        $this->get_content();
        $this->get_footer();
    }
    
    abstract function get_content();
}
?>