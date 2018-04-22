<?php defined('MYBOOK') or die('Access denied'); ?>
<div class="content">
    <h1>Редактирование жанра</h1>
<?php
if (isset($_SESSION['edit_genre']['res'])) {
    echo $_SESSION['edit_genre']['res'];
    unset($_SESSION['edit_genre']['res']);
}
?>
<form class="page_form" action="" method="post">
	<table class="pages_table">
        <tr>
            <td class="left">Название жанра:</td>
            <td><input type="text" name="name" value="<?=htmlspecialchars($genre)?>"></td>
        </tr>
	</table>
	
    <button type="submit">Редактировать</button>
</form>