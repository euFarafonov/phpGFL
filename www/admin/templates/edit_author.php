<?php defined('MYBOOK') or die('Access denied'); ?>
<div class="content">
    <h1>Редактирование автора</h1>
<?php
if (isset($_SESSION['edit_author']['res'])) {
    echo $_SESSION['edit_author']['res'];
    unset($_SESSION['edit_author']['res']);
}
?>
<form class="page_form" action="" method="post">
	<table class="pages_table">
        <tr>
            <td class="left">Имя автора:</td>
            <td><input type="text" name="name" value="<?=htmlspecialchars($author)?>"></td>
        </tr>
	</table>
	
    <button type="submit">Редактировать</button>
</form>