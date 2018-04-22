<?php defined('MYBOOK') or die('Access denied'); ?>
<div class="content">
	<h1>Редактирование книги</h1>
<?php
if (isset($_SESSION['edit_book']['res'])) {
    echo $_SESSION['edit_book']['res'];
    unset($_SESSION['edit_book']);
}
?>
<form class="page_form" action="" method="post" enctype="multipart/form-data">
	<button type="submit">Редактировать</button>
    
    <table class="pages_table">
        <tr>
            <td class="right">Название книги:</td>
            <td><input class="left" type="text" name="name" value="<?=htmlspecialchars($book['name'])?>"></td>
        </tr>
        
        <tr>
            <td class="right">Цена, <?=CURRENCY?>:</td>
            <td><input class="left" type="text" name="price" value="<?=$book['price']?>"></td>
        </tr>
        
        <tr>
            <td class="right">Описание:</td>
            <td>
                <textarea name="about"><?=$book['about']?></textarea>
            </td>
        </tr>
        
        <tr class="right">
            <td>Авторы:</td>
            <td id="cell_authors">
                <?php foreach($authors_id_arr as $author_id) : ?>
                <select class="js_field left" name="authors[]">
                    <?php foreach($authors as $author) : ?>
                    <option value="<?=$author['id']?>" <?php if($author['id'] === $author_id) echo 'selected';?>><?=$author['name']?></option>
                    <?php endforeach; ?>
                </select>
                <?php endforeach; ?>
                <button id="add_select" type="button">Добавить поле</button>
                <button id="del_select" class="del_fields" type="button">Удалить поле</button>
            </td>
        </tr>
        
        <tr class="right">
            <td>Жанры:</td>
            <td id="cell_genres">
                <?php foreach($genres_id_arr as $genre_id) : ?>
                <select class="js_field left" name="genres[]">
                    <?php foreach($genres as $genre) : ?>
                    <option value="<?=$genre['id']?>" <?php if($genre['id'] === $genre_id) echo 'selected';?>><?=$genre['name']?></option>
                    <?php endforeach; ?>
                </select>
                <?php endforeach; ?>
                <button id="add_select" type="button">Добавить поле</button>
                <button id="del_select" class="del_fields" type="button">Удалить поле</button>
            </td>
        </tr>
        
        <tr>
            <td class="right">Фото книги:<br>
                <span class="small">Для удаления картинки кликните по ней.</span>
            </td>
            <td id="cell_img" data-idimg="<?=$book['id']?>">
                <?php if ($book['img']) : ?>
                    <img id="book_img" src="<?=BOOKIMG?><?=$book['img']?>">
                <?php else : ?>
                    <input id="butUpload" class="left" type="file" name="img">
                <?php endif; ?>
            </td>
        </tr>
        
        <tr>
            <td class="right">Превью фото:</td>
            <td>
                <img id="preview" src="">
            </td>
        </tr>
	</table>
	
	<button type="submit">Редактировать</button>
</form>

<script>
    window.onload = function() {
        var authors = new Fields({
            parent: 'cell_authors',
            maxFields: 3
        });
        
        var genres = new Fields({
            parent: 'cell_genres',
            maxFields: 3
        });
    };
</script>
<script type="text/javascript" src="<?=ADMIN_TEMPLATE?>js/loadimage.js"></script>