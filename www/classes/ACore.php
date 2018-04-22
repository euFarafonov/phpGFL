<?php
abstract class ACore {
    protected $db;
    
    public function __construct() {
        $this->db = new Database(HOST, USER, PASS, DB);
    }
    
    /* ===== MAIN CONTENT ===== */
    public function get_body() {
        $this->get_header();
        $this->get_aside();
        $this->get_content();
        $this->get_footer();
    }
    
    /* ===== HEADER ===== */
    protected function get_header() {
        include 'templates/header.php';
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
    
    /* ===== Массив всех авторов ===== */
    protected function get_authors() {
        $query = "SELECT id, name FROM author ORDER BY name ASC";
        $authors = $this->db->queryAll($query);
        
        return $authors;
    }
    
    /* ===== Массив всех жанров ===== */
    protected function get_genres() {
        $query = "SELECT id, name FROM genre ORDER BY name ASC";
        $genres = $this->db->queryAll($query);
        
        return $genres;
    }
    
    abstract function get_content();
}
?>