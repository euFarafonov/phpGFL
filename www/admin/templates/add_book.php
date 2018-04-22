<?php defined('MYBOOK') or die('Access denied'); ?>
<div class="content">
	<h1>Новая книга</h1>
<?php
if (isset($_SESSION['add_book']['res'])) {
    echo $_SESSION['add_book']['res'];
}
?>

<form class="page_form" action="" method="post" enctype="multipart/form-data">
	<table class="pages_table">
        <tr>
            <td class="right">Название книги:</td>
            <td><input class="left" type="text" name="name"></td>
        </tr>
        
        <tr>
            <td class="right">Цена, <?=CURRENCY?>:</td>
            <td><input class="left" type="text" name="price" value="<?=$_SESSION['add_book']['price']?>"></td>
        </tr>
        
        <tr class="right">
            <td>Описание:</td>
            <td>
                <textarea name="about"><?=$_SESSION['add_book']['about']?></textarea>
            </td>
        </tr>
        
        <tr class="right">
            <td>Авторы:</td>
            <td id="cell_authors">
                <select class="js_field left" name="authors[]">
                    <?php foreach($authors as $author) : ?>
                    <option value="<?=$author['id']?>"><?=$author['name']?></option>
                    <?php endforeach; ?>
                </select>
                <button id="add_select" type="button">Добавить поле</button>
                <button id="del_select" class="del_fields" type="button">Удалить поле</button>
            </td>
        </tr>
        
        <tr class="right">
            <td>Жанры:</td>
            <td id="cell_genres">
                <select class="js_field left" name="genres[]">
                    <?php foreach($genres as $genre) : ?>
                    <option value="<?=$genre['id']?>"><?=$genre['name']?></option>
                    <?php endforeach; ?>
                </select>
                <button id="add_select" type="button">Добавить поле</button>
                <button id="del_select" class="del_fields" type="button">Удалить поле</button>
            </td>
        </tr>
        
        <tr class="right">
            <td>Фото книги:</td>
            <td id="btnimg">
                <input class="left" type="file" name="img">
            </td>
        </tr>
	</table>
	
	<button type="submit">Добавить книгу</button>
</form>
<?php unset($_SESSION['add_book']); ?>

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