<?php defined('MYBOOK') or die('Access denied'); ?>
<div class="content">
    <h1>Новый автор</h1>
<?php
if (isset($_SESSION['add_author']['res'])) {
    echo $_SESSION['add_author']['res'];
    unset($_SESSION['add_author']);
}
?>

<form class="page_form" action="" method="post" enctype="multipart/form-data">
	<table class="pages_table">
        <tr>
            <td class="right">Имя автора:</td>
            <td><input class="left" type="text" name="name"></td>
        </tr>
    </table>
	
    <button type="submit">Добавить</button>
</form>