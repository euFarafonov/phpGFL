<?php defined('MYBOOK') or die('Access denied');

/* ===== Фильтрация входящих данных из админки ===== */
function clear_admin($var) {
    global $link;
    $var = mysqli_real_escape_string($link, $var);
    
    return $var;
}
/* ===== Фильтрация входящих данных ===== */

/* ===== Фильтрация входящих данных из админки ===== */
function clear_data($var) {
    global $link;
    $var = mysqli_real_escape_string($link, trim(strip_tags($var)));
    
    return $var;
}
/* ===== Фильтрация входящих данных ===== */

/*===== Подсвечивание активного пункта меню =====*/
function active_url($str = 'view=pages') {
    $uri = $_SERVER['QUERY_STRING']; // получаем параметры
    
    if (!$uri) $uri = "view=pages"; // параметр по умолчанию
    $uri = explode("&", $uri); // разбиваем строку по разделителю
    
    if (in_array($str, $uri)) {// если в массиве параметров есть строка, тогда это активный пункт меню
        return "class='active'";
    }
}
/*===== Подсвечивание активного пункта меню =====*/

/* ==================== ФУНКЦИИ ДЛЯ РАБОТЫ С КНИГАМИ ==================== */
/*===== Массив всех книг =====*/
function get_books() {
    global $link;
    $query = "SELECT id, name, img FROM book ORDER BY name ASC";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    $books = array();
    
    while ($row = mysqli_fetch_assoc($res)) {
        $books[] = $row;
    }
    
    return $books;
}
/*===== Массив всех книг =====*/

/* ===== Добавление книги ===== */
function add_book() {
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
        $name = clear_admin($name);
        $about = clear_admin($about);
        
        global $link;
        
        // проверка, нет ли уже такой книги
        $query = "SELECT id FROM book WHERE name = '$name'";
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        
        if (mysqli_num_rows($res) > 0) {
            $_SESSION['add_book']['res'] = "<div class='error'>Книга с таким названием уже добавлена!</div>";
            
            return false;
        }
        $query = "INSERT INTO book (name, about, price) VALUES ('$name', '$about', $price)";
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        
        if (mysqli_affected_rows($link) > 0) {
            $id = mysqli_insert_id($link); // ID сохраненной книги
            
            // добавление в БД авторов книги
            $author_values = "";
            foreach($authors as $author_id) {
                $author_values .= " ($id, $author_id),";
            }
            $author_values = substr($author_values, 0, -1);
            $query = "INSERT INTO book_author (book_id, author_id) VALUES" . $author_values;
            $res = mysqli_query($link, $query) or die(mysqli_error($link));
            
            // добавление в БД жанров книги
            $genres_values = "";
            foreach($genres as $genre_id) {
                $genres_values .= " ($id, $genre_id),";
            }
            $genres_values = substr($genres_values, 0, -1);
            $query = "INSERT INTO book_genre (book_id, genre_id) VALUES" . $genres_values;
            $res = mysqli_query($link, $query) or die(mysqli_error($link));
            
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
                        resize("../userfiles/book_img/tmp/$imgName", "../userfiles/book_img/baseimg/$imgName", 220, 320, $imgExt);
                        unlink("../userfiles/book_img/tmp/$imgName");
                        
                        mysqli_query($link, "UPDATE book SET img = '$imgName' WHERE id = $id");
                    } else {
                        $_SESSION['answer'] .= "<div class='error'>Не удалось переместить загруженную картинку! Проверьте права на папки в каталоге /userfiles/book_img/ </div>";
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
/* ===== Добавление книги ===== */

/* ===== Ресайз картинок ===== */
function resize($target, $dest, $wmax, $hmax, $ext) {
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
/* ===== Ресайз картинок ===== */

/* ===== Получение данных книги для редактирования ===== */
function get_book($id) {
    global $link;
    $query = "SELECT * FROM book WHERE id = $id";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    $book = array();
    $book = mysqli_fetch_assoc($res);
    
    return $book;  
}
/* ===== Получение данных книги для редактирования ===== */

/* ==== Удаление картинки книги ===== */
function del_img() {
    $id = (int)$_POST['img_id'];
    
    global $link;
    $query = "UPDATE book SET img = '' WHERE id = $id";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    
    if (mysqli_affected_rows($link) > 0) {
        $answer = array("state" => "OK");
    } else {
        $answer = array("state" => "ERROR");
    }
    echo json_encode($answer);
}
/* ===== Удаление картинки книги ===== */

/* ===== Массив всех авторов для заданной книги ===== */
function get_authors_id($id) {
    global $link;
    $query = "SELECT author_id FROM book_author WHERE book_id = $id";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    $authors_id_arr = array();
    
    while ($row = mysqli_fetch_assoc($res)) {
        $authors_id_arr[] = $row['author_id'];
    }
    
    return $authors_id_arr;
}
/* ===== Массив всех авторов для заданной книги ===== */

/* ===== Массив всех жанров для заданной книги ===== */
function get_genres_id($id) {
    global $link;
    $query = "SELECT genre_id FROM book_genre WHERE book_id = $id";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    $genre_id_arr = array();
    
    while ($row = mysqli_fetch_assoc($res)) {
        $genre_id_arr[] = $row['genre_id'];
    }
    
    return $genre_id_arr;
}
/* ===== Массив всех жанров для заданной книги ===== */

/* ===== Редактирование книги ===== */
function edit_book($id, $authors_id_arr, $genres_id_arr) {
    $name = trim($_POST['name']);
    $price = round(floatval(preg_replace("#,#", ".", $_POST['price'])), 2);
    $about = trim($_POST['about']);
    $authors = $_POST['authors'];
    $genres = $_POST['genres'];
    
    if (empty($name)) {
        $_SESSION['edit_book']['res'] = "<div class='error'>У книги должно быть название!</div>";
        
        return false;
    } else {
        $name = clear_admin($name);
        $about = clear_admin($about);
        
        global $link;
        
        // проверка, нет ли уже такой книги
        $query = "SELECT id FROM book WHERE name = '$name'";
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        
        if (mysqli_num_rows($res) > 0) {
            $_SESSION['edit_book']['res'] = "<div class='error'>Книга с таким названием уже добавлена!</div>";
            
            return false;
        }
        
        $query = "UPDATE book SET name = '$name', price = $price, about = '$about' WHERE id = $id";
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        
        // замена в БД авторов книги
        //-- сначала удаляю старые записи
        $query = "DELETE FROM book_author WHERE book_id = $id";
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        //--теперь добавляю новые записи
        $author_values = "";
        foreach($authors as $author_id) {
            $author_values .= " ($id, $author_id),";
        }
        $author_values = substr($author_values, 0, -1);
        $query = "INSERT INTO book_author (book_id, author_id) VALUES" . $author_values;
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        
        // замена в БД жанров книги
        //-- сначала удаляю старые записи
        $query = "DELETE FROM book_genre WHERE book_id = $id";
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        //--теперь добавляю новые записи
        $genres_values = "";
        foreach($genres as $genre_id) {
            $genres_values .= " ($id, $genre_id),";
        }
        $genres_values = substr($genres_values, 0, -1);
        $query = "INSERT INTO book_genre (book_id, genre_id) VALUES" . $genres_values;
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        
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
                    resize("../userfiles/book_img/tmp/$imgName", "../userfiles/book_img/baseimg/$imgName", 220, 320, $imgExt);
                    unlink("../userfiles/book_img/tmp/$imgName");
                    
                    mysqli_query($link, "UPDATE book SET img = '$imgName' WHERE id = $id");
                } else {
                    $_SESSION['edit_book']['res'] = "<div class='error'>Не удалось переместить загруженную картинку! Проверьте права на папки в каталоге /userfiles/book_img/ </div>";
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
/* ===== Редактирование книги ===== */

/*===== Удаление книги =====*/
function del_book($id) {
    global $link;
    $query = "SELECT img FROM book WHERE id = $id";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    $row = mysqli_fetch_assoc($res);
    
    $img = $row['img']; // фото книги
    
    if ($img) {
        unlink("../userfiles/book_img/baseimg/$img");
    }
    
    $query = "DELETE FROM book WHERE id = $id";
    mysqli_query($link, $query);
    if (mysqli_affected_rows($link) > 0) {
        // удаление связанных записей об авторах
        $query = "DELETE FROM book_author WHERE book_id = $id";
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        
        // удаление связанных записей о жанрах
        $query = "DELETE FROM book_genre WHERE book_id = $id";
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        
        $_SESSION['answer'] = "<div class='success'>Книга удалена</div>";
    } else {
        $_SESSION['answer'] = "<div class='error'>Ошибка удаления книги!</div>";
    }
}
/*===== Удаление книги =====*/

/* ==================== ФУНКЦИИ ДЛЯ РАБОТЫ С АВТОРАМИ ==================== */
/*===== Массив всех авторов =====*/
function get_authors() {
    global $link;
    $query = "SELECT id, name FROM author ORDER BY name ASC";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    $authors = array();
    
    while($row = mysqli_fetch_assoc($res)){
        $authors[] = $row;
    }
    
    return $authors;
}
/*===== Массив всех авторов =====*/

/*===== Добавление автора =====*/
function add_author() {
    $name = trim($_POST['name']);
    
    if (empty($name)) {// если нет имени автора
        $_SESSION['add_author']['res'] = "<div class='error'>Необходимо указать имя автора!</div>";
        
        return false;
    } else {
        $name = clear_admin($name);
        global $link;
        
        // проверка, нет ли уже такого автора
        $query = "SELECT id FROM author WHERE name = '$name'";
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        
        if (mysqli_num_rows($res) > 0) {
            $_SESSION['add_author']['res'] = "<div class='error'>Автор ".$name." уже добавлен!</div>";
            
            return false;
        }
        
        // добавление автора
        $query = "INSERT INTO author (name) VALUES ('$name')";
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        if (mysqli_affected_rows($link) > 0) {
            $_SESSION['answer'] = "<div class='success'>Автор успешно добавлен!</div>";
            
            return true;
        } else {
            $_SESSION['add_author']['res'] = "<div class='error'>Ошибка добавления автора!</div>";
            
            return false;
        }
    }
}
/*===== Добавление автора =====*/

/*===== Имя автора =====*/
function get_author($id) {
    global $link;
    $query = "SELECT name FROM author WHERE id = $id";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    $row = mysqli_fetch_assoc($res);
    $author = $row['name'];
    
    return $author;
}
/*===== Имя автора =====*/

/*===== Редактирование автора =====*/
function edit_author($id) {
    $name = trim($_POST['name']);
    
    if (empty($name)) {// если нет имени
        $_SESSION['edit_author']['res'] = "<div class='error'>Должно быть имя автора!</div>";
        return false;
    } else {
        $name = clear_admin($name);
        
        global $link;
        
        // проверка, нет ли уже такого автора
        $query = "SELECT id FROM author WHERE name = '$name'";
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        
        if (mysqli_num_rows($res) > 0) {
            $_SESSION['edit_author']['res'] = "<div class='error'>Автор ".$name." уже добавлен!</div>";
            
            return false;
        }
        
        $query = "UPDATE author SET name = '$name' WHERE id = $id";
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        
        if (mysqli_affected_rows($link) > 0) {
            $_SESSION['answer'] = "<div class='success'>Автор изменен!</div>";
            
            return true;
        } else {
            $_SESSION['edit_author']['res'] = "<div class='error'>Ошибка или Вы не изменили имя!</div>";
            
            return false;
        }  
    }
}
/*===== Редактирование автора =====*/

/*===== Удаление автора =====*/
function del_author($id) {
    global $link;
    $query = "DELETE FROM author WHERE id = $id";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    
    if (mysqli_affected_rows($link) > 0) {
        $_SESSION['answer'] = "<div class='success'>Автор успешно удален!</div>";
        
        return true;
    } else {
        $_SESSION['del_author']['res'] = "<div class='error'>Ошибка удаления автора!</div>";
        
        return false;
    }
}
/*===== Удаление автора =====*/

/* ==================== ФУНКЦИИ ДЛЯ РАБОТЫ С ЖАНРАМИ ==================== */
/*===== Массив всех жанров =====*/
function get_genres() {
    global $link;
    $query = "SELECT id, name FROM genre ORDER BY name ASC";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    $genres = array();
    
    while($row = mysqli_fetch_assoc($res)){
        $genres[] = $row;
    }
    
    return $genres;
}
/*===== Массив всех жанров =====*/

/*===== Добавление жанра =====*/
function add_genre() {
    $name = trim($_POST['name']);
    
    if (empty($name)) {// если нет названия жанра
        $_SESSION['add_genre']['res'] = "<div class='error'>Необходимо указать название жанра!</div>";
        
        return false;
    } else {
        $name = clear_admin($name);
        
        global $link;
        
        // проверка, нет ли уже такого жанра
        $query = "SELECT id FROM genre WHERE name = '$name'";
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        
        if (mysqli_num_rows($res) > 0) {
            $_SESSION['add_genre']['res'] = "<div class='error'>Жанр ".$name." уже добавлен!</div>";
            
            return false;
        }
        
        $query = "INSERT INTO genre (name) VALUES ('$name')";
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        if (mysqli_affected_rows($link) > 0) {
            $_SESSION['answer'] = "<div class='success'>Жанр успешно добавлен!</div>";
            
            return true;
        } else {
            $_SESSION['add_genre']['res'] = "<div class='error'>Ошибка добавления жанра!</div>";
            
            return false;
        }
    }
}
/*===== Добавление жанра =====*/

/*===== Название жанра =====*/
function get_genre($id) {
    global $link;
    $query = "SELECT name FROM genre WHERE id = $id";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    $row = mysqli_fetch_assoc($res);
    $genre = $row['name'];
    
    return $genre;
}
/*===== Название жанра =====*/

/*===== Редактирование жанра =====*/
function edit_genre($id) {
    $name = trim($_POST['name']);
    
    if (empty($name)) {// если нет названия
        $_SESSION['edit_genre']['res'] = "<div class='error'>Должно быть название жанра!</div>";
        
        return false;
    } else {
        $name = clear_admin($name);
        
        global $link;
        
        // проверка, нет ли уже такого жанра
        $query = "SELECT id FROM genre WHERE name = '$name'";
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        
        if (mysqli_num_rows($res) > 0) {
            $_SESSION['edit_genre']['res'] = "<div class='error'>Жанр ".$name." уже добавлен!</div>";
            
            return false;
        }
        
        $query = "UPDATE genre SET name = '$name' WHERE id = $id";
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        
        if (mysqli_affected_rows($link) > 0) {
            $_SESSION['answer'] = "<div class='success'>Жанр изменен!</div>";
            
            return true;
        } else {
            $_SESSION['edit_genre']['res'] = "<div class='error'>Ошибка или Вы не изменили жанр!</div>";
            
            return false;
        }  
    }
}
/*===== Редактирование жанра =====*/

/*===== Удаление жанра =====*/
function del_genre($id) {
    global $link;
    $query = "DELETE FROM genre WHERE id = $id";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    
    if (mysqli_affected_rows($link) > 0) {
        $_SESSION['answer'] = "<div class='success'>Жанр успешно удален!</div>";
        
        return true;
    } else {
        $_SESSION['del_genre']['res'] = "<div class='error'>Ошибка удаления жанра!</div>";
        
        return false;
    }
}
/*===== Удаление жанра =====*/
?>