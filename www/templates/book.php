<?php defined('MYBOOK') or exit('Access denied');?>

<!-- MAIN CONTENT -->
<article class="article">
    <?php 
    if (isset($_SESSION['answer'])) {
        echo $_SESSION['answer'];
        unset($_SESSION['answer']);
    }
    ?>
    
    <?php if($book_info) : ?>
    <h1><?=$book_info['name']?></h1>
    <div class="book_wrap container clearfix">
        <img class="book_img" src="<?=BOOKIMG?><?=$book_info['img']?>" alt="<?=$book_info['name']?>">
        <p class="book_about"><?=$book_info['about']?></p>
        <div class="book_price">Цена книги - <span><?=$book_info['price']?> <?=CURRENCY?></span></div>
    </div>
    
    <div class="form_wrap">
        <div class="order_header">Заказать книгу</div>
        <div class="order_notice">Обратите внимание, что все поля формы обязательны для заполнения!</div>
        
        <form id="book_order" class="book_order" action="" method="post">    
            <label class="label_text">
                <input type="text" name="surname" placeholder="Фамилия">
            </label>
            <label class="label_text">
                <input type="text" name="name" placeholder="Имя">
            </label>
            <label class="label_text">
                <input type="text" name="secondname" placeholder="Отчество">
            </label>
            <label class="label_text">
                <input type="text" name="address" placeholder="Адрес доставки">
            </label>
            <label class="label_text">
                <input type="text" name="email" placeholder="Email">
            </label>
            <label class="label_cnt">
                Количество экземпляров:
                <input class="order_cnt" type="text" name="quantity" value="1">
            </label>
            <input type="submit" value="Заказать">
        </form>
    </div>
    <?php else : ?>
        <div class="not_info">Информация по данной книге пока отсутствует!</div>
    <?php endif; ?>
</article>
<script src="<?=LIB?>js/checkform.js" type="text/javascript"></script>