<?php
abstract class ACore_admin {
    protected $db,
        $authors = array(),// массив авторов
        $genres = array();// массив жанров
    
    public function __construct() {
        $this->db = new Database(HOST, USER, PASS, DB);
    }
    
    /* ===== HEADER ===== */
    protected function get_header_admin() {
        include 'templates/admin_header.php';
    }
    
    /* ===== LEFTBAR ===== */
    protected function get_aside_admin() {
        include 'templates/admin_leftbar.php';
    }
    
    /* ===== FOOTER ===== */
    protected function get_footer_admin() {
        include 'templates/admin_footer.php';
    }
    
    /* ===== MAIN CONTENT ===== */
    public function get_body() {
        $this->get_authors();
        $this->get_genres();
        
        $this->get_header_admin();
        $this->get_aside_admin();
        $this->get_content_admin();
        $this->get_footer_admin();
    }
    
    /* ===== ДИНАМИЧЕСКИЙ КОНТЕНТ ===== */
    abstract function get_content_admin();
    
    
    /* ==================== МЕТОДЫ ДЛЯ РАБОТЫ С КНИГАМИ ==================== */
    /* ===== Добавление книги в БД ===== */
    public function insert_book() {
        $name = trim($_POST['name']);
        $price = round(floatval(preg_replace("#,#", ".", $_POST['price'])), 2);
        $about = trim($_POST['about']);
        $authors = $_POST['authors'];
        $genres = $_POST['genres'];
        
        if (empty($name)) {
            $_SESSION['add_book']['res'] = "<div class='error'>У книги должно быть название!</div>";
            $_SESSION['add_book']['price'] = $price;
            $_SESSION['add_book']['about'] = $about;
            return false;
        } else {
            $name = trim(strip_tags($name));
            $about = trim(strip_tags($about));
            
            // проверка, нет ли уже такой книги
            $query = "SELECT id FROM book WHERE name = '$name'";
            
            if ($this->db->check($query)) {
                $_SESSION['add_book']['res'] = "<div class='error'>Книга с таким названием уже добавлена!</div>";
                
                return false;
            }
            
            // вставка книги в БД
            $query = "INSERT INTO book (name, about, price) VALUES ('$name', '$about', $price)";
            $id = $this->db->insert($query);// ID сохраненной книги
            
            if ($id) {
                // добавление в БД авторов книги
                $author_values = "";
                foreach ($authors as $author_id) {
                    $author_values .= " ($id, $author_id),";
                }
                $author_values = substr($author_values, 0, -1);
                $query = "INSERT INTO book_author (book_id, author_id) VALUES" . $author_values;
                $this->db->insert($query);
                
                // добавление в БД жанров книги
                $genres_values = "";
                foreach ($genres as $genre_id) {
                    $genres_values .= " ($id, $genre_id),";
                }
                $genres_values = substr($genres_values, 0, -1);
                $query = "INSERT INTO book_genre (book_id, genre_id) VALUES" . $genres_values;
                $this->db->insert($query);
                
                // добавление в БД фото книги
                $types = array("image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png"); // массив допустимых расширений картинок
                $error = "";
                
                if ($_FILES['img']['name']) {// если есть файл
                    $imgExt = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES['img']['name'])); // расширение картинки
                    $imgName = "{$id}.{$imgExt}"; // новое имя картинки
                    $imgTmpName = $_FILES['img']['tmp_name']; // временное имя картинки
                    $imgSize = $_FILES['img']['size']; // размер файла
                    $imgType = $_FILES['img']['type']; // тип файла
                    $imgError = $_FILES['img']['error']; // 0 - ОК, иначе - ошибка
                    
                    if (!in_array($imgType, $types)) {
                        $error .= "Допустимые расширения: .gif, .png, .jpg !";
                        $_SESSION['answer'] .= "<div class='error'>Ошибка при загрузке картинки {$_FILES['img']['name']}<br />{$error}</div>";
                    }
                    
                    if ($imgSize > SIZE) {
                        $error .= "Максимальный вес файла - 2 мегабайта!";
                        $_SESSION['answer'] .= "<div class='error'>Ошибка при загрузке картинки {$_FILES['img']['name']}<br />{$error}</div>";
                    }
                    
                    if ($imgError) {
                        $error .= "Возможно, файл слишком большой!";
                        $_SESSION['answer'] .= "<div class='error'>Ошибка при загрузке картинки {$_FILES['img']['name']}<br />{$error}</div>";
                    }
                    
                    if (empty($error)) {// если нет ошибок
                        if (move_uploaded_file($imgTmpName, "../userfiles/book_img/tmp/$imgName")) {
                            $this->resize("../userfiles/book_img/tmp/$imgName", "../userfiles/book_img/baseimg/$imgName", 220, 320, $imgExt);
                            unlink("../userfiles/book_img/tmp/$imgName");
                            
                            $query = "UPDATE book SET img = '$imgName' WHERE id = $id";
                            $this->db->execute($query);
                        } else {
                            $_SESSION['answer'] .= "<div class='error'>Не удалось переместить загруженную картинку! Проверьте права на папки в каталоге ../userfiles/book_img/ </div>";
                        }
                    }
                }
                
                $_SESSION['answer'] .= "<div class='success'>Книга успешно добавлена!</div>";
                
                return true;
            }else{
                $_SESSION['add_book']['res'] = "<div class='error'>Ошибка при добавлении книги!</div>";
                
                return false;
            }
        }
    }
    
    /* ===== Получение данных книги для редактирования ===== */
    public function get_book_info($id) {
        $query = "SELECT * FROM book WHERE id = $id";
        $book = $this->db->queryOne($query);
        
        return $book;  
    }
    
    /* ===== Массив всех авторов для заданной книги ===== */
    public function get_authors_id($id) {
        $query = "SELECT author_id FROM book_author WHERE book_id = $id";
        $authors_id_arr = $this->db->queryAll($query);
        
        return $authors_id_arr;
    }
    
    /* ===== Массив всех жанров для заданной книги ===== */
    public function get_genres_id($id) {
        $query = "SELECT genre_id FROM book_genre WHERE book_id = $id";
        $genre_id_arr = $this->db->queryAll($query);
        
        return $genre_id_arr;
    }
    
    /* ===== Редактирование книги ===== */
    public function change_book($id, $authors_id_arr, $genres_id_arr) {
        $name = trim($_POST['name']);
        $price = round(floatval(preg_replace("#,#", ".", $_POST['price'])), 2);
        $about = trim($_POST['about']);
        $authors = $_POST['authors'];
        $genres = $_POST['genres'];
        
        if (empty($name)) {
            $_SESSION['edit_book']['res'] = "<div class='error'>У книги должно быть название!</div>";
            
            return false;
        } else {
            $name = trim(strip_tags($name));
            $about = trim(strip_tags($about));
            
            // проверка, нет ли уже такой книги
            $query = "SELECT id FROM book WHERE name = '$name'";
            $res = $this->db->queryOne($query);
            $check_id = (int)$res['id'];
            
            if ($check_id && $check_id != $id) {
                $_SESSION['edit_book']['res'] = "<div class='error'>Книга с таким названием уже добавлена!</div>";
                
                return false;
            }
            
            $query = "UPDATE book SET name = '$name', price = $price, about = '$about' WHERE id = $id";
            $this->db->execute($query);
            
            // замена в БД авторов книги
            //-- сначала удаляю старые записи
            $query = "DELETE FROM book_author WHERE book_id = $id";
            $this->db->execute($query);
            //--теперь добавляю новые записи
            $author_values = "";
            
            foreach ($authors as $author_id) {
                $author_values .= " ($id, $author_id),";
            }
            $author_values = substr($author_values, 0, -1);
            $query = "INSERT INTO book_author (book_id, author_id) VALUES" . $author_values;
            $this->db->insert($query);
            
            // замена в БД жанров книги
            //-- сначала удаляю старые записи
            $query = "DELETE FROM book_genre WHERE book_id = $id";
            $this->db->execute($query);
            //--теперь добавляю новые записи
            $genres_values = "";
            
            foreach ($genres as $genre_id) {
                $genres_values .= " ($id, $genre_id),";
            }
            $genres_values = substr($genres_values, 0, -1);
            $query = "INSERT INTO book_genre (book_id, genre_id) VALUES" . $genres_values;
            $this->db->insert($query);
            
            $_SESSION['answer'] = "<div class='success'>Тестовые данные книги изменены!</div>";
            
            // замена в БД фото книги
            $types = array("image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png"); // массив допустимых расширений картинок
            $error = "";
            
            if ($_FILES['img']['name']) {// если есть файл
                $imgExt = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES['img']['name'])); // расширение картинки
                $imgName = "{$id}.{$imgExt}"; // новое имя картинки
                $imgTmpName = $_FILES['img']['tmp_name']; // временное имя картинки
                $imgSize = $_FILES['img']['size']; // размер файла
                $imgType = $_FILES['img']['type']; // тип файла
                $imgError = $_FILES['img']['error']; // 0 - ОК, иначе - ошибка
                
                if (!in_array($imgType, $types)) $error .= "Допустимые расширения: .gif, .png, .jpg !\n\r";
                
                if ($imgSize > SIZE) $error .= "Максимальный вес файла - 2 мегабайта!\n\r";
                
                if ($imgError) $error .= "Возможно, файл слишком большой!\n\r";
                
                if (empty($error)) {// если нет ошибок
                    if (move_uploaded_file($imgTmpName, "../userfiles/book_img/tmp/$imgName")) {
                        $this->resize("../userfiles/book_img/tmp/$imgName", "../userfiles/book_img/baseimg/$imgName", 220, 320, $imgExt);
                        unlink("../userfiles/book_img/tmp/$imgName");
                        
                        $query = "UPDATE book SET img = '$imgName' WHERE id = $id";
                        $this->db->execute($query);
                    } else {
                        $_SESSION['edit_book']['res'] = "<div class='error'>Не удалось переместить загруженную картинку! Проверьте права на папки в каталоге ../userfiles/book_img/ </div>";
                    }
                } else {
                    $_SESSION['edit_book']['res'] = "<div class='error'>Ошибка при редактировании фото книги!\n\r" . $error . "</div>";
                    
                    return false;
                }
            }
            
            $_SESSION['answer'] .= "<div class='success'>Фото книги изменено!</div>";
            
            return true;
        }
    }
    
    /*===== Удаление книги =====*/
    public function del_book($id) {
        $query = "SELECT img FROM book WHERE id = $id";
        $res = $this->db->queryOne($query);
        $img = $res['img']; // фото книги
        
        if ($img) {
            unlink("../userfiles/book_img/baseimg/$img");
        }
        
        $query = "DELETE FROM book WHERE id = $id";
        
        if ($this->db->execute($query)) {
            // удаление связанных записей об авторах
            $query = "DELETE FROM book_author WHERE book_id = $id";
            $this->db->execute($query);
            
            // удаление связанных записей о жанрах
            $query = "DELETE FROM book_genre WHERE book_id = $id";
            $this->db->execute($query);
            
            $_SESSION['answer'] = "<div class='success'>Книга удалена</div>";
        } else {
            $_SESSION['answer'] = "<div class='error'>Ошибка удаления книги!</div>";
        }
    }

    
    /* ==================== МЕТОДЫ ДЛЯ РАБОТЫ С АВТОРАМИ ==================== */
    /*===== Добавление автора =====*/
    public function insert_author() {
        $name = trim($_POST['name']);
        
        if (empty($name)) {// если нет имени автора
            $_SESSION['add_author']['res'] = "<div class='error'>Необходимо указать имя автора!</div>";
            
            return false;
        } else {
            $name = trim(strip_tags($name));
            
            // проверка, нет ли уже такого автора
            $query = "SELECT id FROM author WHERE name = '$name'";
            
            if ($this->db->queryOne($query)) {
                $_SESSION['add_author']['res'] = "<div class='error'>Автор ".$name." уже добавлен!</div>";
                
                return false;
            }
            
            // добавление автора
            $query = "INSERT INTO author (name) VALUES ('$name')";
            
            if ($this->db->insert($query)) {
                $_SESSION['answer'] = "<div class='success'>Автор успешно добавлен!</div>";
                
                return true;
            } else {
                $_SESSION['add_author']['res'] = "<div class='error'>Ошибка добавления автора!</div>";
                
                return false;
            }
        }
    }
    
    /* ===== Массив всех авторов ===== */
    public function get_authors() {
        $query = "SELECT id, name FROM author ORDER BY name ASC";
        $this->authors = $this->db->queryAll($query);
    }
    
    /*===== Имя автора =====*/
    public function get_author_name($id) {
        $query = "SELECT name FROM author WHERE id = $id";
        $res = $this->db->queryOne($query);
        
        return $res['name'];
    }
    
    /*===== Редактирование автора =====*/
    public function change_author($id) {
        $name = trim($_POST['name']);
        
        if (empty($name)) {// если нет имени
            $_SESSION['edit_author']['res'] = "<div class='error'>Должно быть имя автора!</div>";
            return false;
        } else {
            $name = trim(strip_tags($name));
            
            // проверка, нет ли уже такого автора
            $query = "SELECT id FROM author WHERE name = '$name'";
            
            if ($this->db->queryOne($query)) {
                $_SESSION['edit_author']['res'] = "<div class='error'>Автор ".$name." уже добавлен!</div>";
                
                return false;
            }
            
            $query = "UPDATE author SET name = '$name' WHERE id = $id";
            
            if ($this->db->execute($query)) {
                $_SESSION['answer'] = "<div class='success'>Автор изменен!</div>";
                
                return true;
            } else {
                $_SESSION['edit_author']['res'] = "<div class='error'>Ошибка или Вы не изменили имя!</div>";
                
                return false;
            }  
        }
    }
    
    /*===== Удаление автора =====*/
    public function del_author($id) {
        $query = "DELETE FROM author WHERE id = $id";
        
        if ($this->db->execute($query)) {
            $_SESSION['answer'] = "<div class='success'>Автор успешно удален!</div>";
            
            return true;
        } else {
            $_SESSION['del_author']['res'] = "<div class='error'>Ошибка удаления автора!</div>";
            
            return false;
        }
    }
    
    
    /* ==================== МЕТОДЫ ДЛЯ РАБОТЫ С ЖАНРАМИ ==================== */
    /*===== Добавление жанра =====*/
    public function insert_genre() {
        $name = trim($_POST['name']);
        
        if (empty($name)) {// если нет названия жанра
            $_SESSION['add_genre']['res'] = "<div class='error'>Необходимо указать название жанра!</div>";
            
            return false;
        } else {
            $name = trim(strip_tags($name));
            
            // проверка, нет ли уже такого жанра
            $query = "SELECT id FROM genre WHERE name = '$name'";
            
            if ($this->db->queryOne($query)) {
                $_SESSION['add_genre']['res'] = "<div class='error'>Жанр ".$name." уже добавлен!</div>";
                
                return false;
            }
            
            $query = "INSERT INTO genre (name) VALUES ('$name')";
            
            if ($this->db->insert($query)) {
                $_SESSION['answer'] = "<div class='success'>Жанр успешно добавлен!</div>";
                
                return true;
            } else {
                $_SESSION['add_genre']['res'] = "<div class='error'>Ошибка добавления жанра!</div>";
                
                return false;
            }
        }
    }
    
    /* ===== Массив всех жанров ===== */
    public function get_genres() {
        $query = "SELECT id, name FROM genre ORDER BY name ASC";
        $this->genres = $this->db->queryAll($query);
    }
    
    /*===== Название жанра =====*/
    public function get_genre_name($id) {
        $query = "SELECT name FROM genre WHERE id = $id";
        $res = $this->db->queryOne($query);
        
        return $res['name'];
    }
    
    /*===== Редактирование жанра =====*/
    public function change_genre($id) {
        $name = trim($_POST['name']);
        
        if (empty($name)) {// если нет названия
            $_SESSION['edit_genre']['res'] = "<div class='error'>Должно быть название жанра!</div>";
            
            return false;
        } else {
            $name = trim(strip_tags($name));
            
            // проверка, нет ли уже такого жанра
            $query = "SELECT id FROM genre WHERE name = '$name'";
            
            if ($this->db->queryOne($query)) {
                $_SESSION['edit_genre']['res'] = "<div class='error'>Жанр ".$name." уже добавлен!</div>";
                
                return false;
            }
            
            $query = "UPDATE genre SET name = '$name' WHERE id = $id";
            
            if ($this->db->execute($query)) {
                $_SESSION['answer'] = "<div class='success'>Жанр изменен!</div>";
                
                return true;
            } else {
                $_SESSION['edit_genre']['res'] = "<div class='error'>Ошибка или Вы не изменили жанр!</div>";
                
                return false;
            }  
        }
    }

    /*===== Удаление жанра =====*/
    public function del_genre($id) {
        $query = "DELETE FROM genre WHERE id = $id";
        
        if ($this->db->execute($query)) {
            $_SESSION['answer'] = "<div class='success'>Жанр успешно удален!</div>";
            
            return true;
        } else {
            $_SESSION['del_genre']['res'] = "<div class='error'>Ошибка удаления жанра!</div>";
            
            return false;
        }
    }
    
    
    /* ==================== ДОПОЛНИТЕЛЬНЫЕ МЕТОДЫ ==================== */
    /* ===== Подсвечивание активного пункта меню ===== */
    public function active_url($str = 'view=admin') {
        $uri = $_SERVER['QUERY_STRING']; // получаем параметры
        
        if (!$uri) $uri = "view=admin"; // параметр по умолчанию
        $uri = explode("&", $uri); // разбиваем строку по разделителю
        
        if (in_array($str, $uri)) {// если в массиве параметров есть строка, тогда это активный пункт меню
            return "class='active'";
        }
    }
    
    /* ===== Ресайз картинок ===== */
    public function resize($target, $dest, $wmax, $hmax, $ext) {
        /*
        $target - путь к оригинальному файлу
        $dest - путь сохранения обработанного файла
        $wmax - максимальная ширина
        $hmax - максимальная высота
        $ext - расширение файла
        */
        list($w_orig, $h_orig) = getimagesize($target);
        $ratio = $w_orig / $h_orig; // =1 - квадрат, <1 - альбомная, >1 - книжная
    
        if (($wmax / $hmax) > $ratio) {
            $wmax = $hmax * $ratio;
        } else {
            $hmax = $wmax / $ratio;
        }
    
        $img = "";
        // imagecreatefromjpeg | imagecreatefromgif | imagecreatefrompng
        switch ($ext) {
            case("gif") :
                $img = imagecreatefromgif($target);
                break;
            case("png") :
                $img = imagecreatefrompng($target);
                break;
            default :
                $img = imagecreatefromjpeg($target);    
        }
        $newImg = imagecreatetruecolor($wmax, $hmax); // создаем оболочку для новой картинки
        
        if ($ext == "png") {
            imagesavealpha($newImg, true); // сохранение альфа канала
            $transPng = imagecolorallocatealpha($newImg,0,0,0,127); // добавляем прозрачность
            imagefill($newImg, 0, 0, $transPng); // заливка  
        }
    
        imagecopyresampled($newImg, $img, 0, 0, 0, 0, $wmax, $hmax, $w_orig, $h_orig); // копируем и ресайзим изображение
        switch ($ext) {
            case("gif") :
                imagegif($newImg, $dest);
                break;
            case("png") :
                imagepng($newImg, $dest);
                break;
            default :
                imagejpeg($newImg, $dest);    
        }
        imagedestroy($newImg);
    }
    
    /* ===== Редирект ===== */
    /*
    public function redirect($http = false) {
        if ($http) {
            $redirect = $http;
        } else {
            $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
        }
        header("Location: ".$redirect);
        exit;
    }*/
}
?>