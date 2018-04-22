<?php
class book extends ACore {
    public function get_content() {
        // оформление заказа
        if (isset($_POST['surname'])) {
            $book_info = $_SESSION['book_info'];
            
            $surname = trim(strip_tags($_POST['surname']));
            $name = trim(strip_tags($_POST['name']));
            $secondname = trim(strip_tags($_POST['secondname']));
            $address = trim(strip_tags($_POST['address']));
            $email = trim(strip_tags($_POST['email']));
            $qnt = (int)$_POST['quantity'];
                
            // письмо покупателю
            $subject_user = "Заказ книги в библиотеке ".SITENAME;
            $mail_user = "Здравствуйте, " . $name . ".
        Благодарим Вас за заказ товара на сайте библиотеки ".SITENAME."!\r\n
        Заказанная книга: " . $book_info['name'] . ".
        Цена книги: " . $book_info['price'] . " грн.
        Количество экземпляров: " . $qnt . ".\r\n
        С уважением,
        администрация сайта ".SITENAME;
            
            $headers = "MIME-Version: 1.0 \r\n"; 
            $headers .= "Content-type: text/plain; charset=utf-8 \r\n";
        	$headers .= "FROM: ".SITENAME." <". ADMIN .">\r\n";
        	$headers .= "Reply-To: ".SITENAME." <". ADMIN .">\r\n";
            
            $send_customer = mail($email, $subject_user, $mail_user, $headers);
            
            // письмо администратору
            $subject_admin = "Заказ книги в библиотеке ".SITENAME;
            $mail_admin = "Новый заказ на сайте ".SITENAME.".\r\n
        Данные о покупателе и заказанной книге:
        - Фамилия: " . $surname . "
        - Имя: " . $name . "
        - Отчество: " . $secondname . "
        - Адрес доставки: " . $address . "
        - Email: " . $email . "\r\n
        - Заказанная книга: " . $book_info['name'] . "
        - Цена книги: " . $book_info['price'] . " грн.
        - Количество экземпляров: " . $qnt;
            
            $send_admin = mail(ADMIN, $subject_admin, $mail_admin, $headers);
            
            if ($send_customer && $send_admin) {
                $_SESSION['answer'] = '<div class="success">Ваш заказ принят! Данные о заказе отправленны на почту '.$email.'.</div>';
            } else {
                $_SESSION['answer'] = '<div class="error">Ошибка оформления заказа! Уточните детали у менеджера по телефону!</div>';
            }
        }
        
        $_SESSION['book_info'] = '';
        $book_id = (int)$_GET['book_id'];
        $query = "SELECT id, name, about, price, img FROM book WHERE id = $book_id";
        $res = mysqli_query($this->db, $query) or die(mysqli_error($this->db));
        $book_info = mysqli_fetch_assoc($res);
        $_SESSION['book_info'] = $book_info;
        
        include 'templates/book.php';
    }
}
?>