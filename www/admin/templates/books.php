<?php defined('MYBOOK') or die('Access denied'); ?>
<div class="content">
    <h1>Список всех книг</h1>
<?php
if (isset($_SESSION['answer'])) {
    echo $_SESSION['answer'];
    unset ($_SESSION['answer']);
}
?>
	<a class="button" href="?view=add_book">Добавить книгу</a>
    
    <table class="pages_table">
        <tr>
    		<th>№</th>
            <th>Фото</th>
    		<th>Название книги</th>
    		<th>Действие</th>
        </tr>
        <?php if($books) : ?>
        <?php $i = 1; ?>
        <?php foreach($books as $book) : ?>
        <tr>
            <td><?=$i?></td>
            <td><img src="<?=BOOKIMG?><?=$book['img']?>"></td>
            <td class="left"><?=$book['name']?></td>
            <td>
                <a href="?view=edit_book&book_id=<?=$book['id']?>" class="edit">редактировать</a>
                |
                <a href="?view=del_book&book_id=<?=$book['id']?>" class="del">удалить</a>
            </td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
        <?php endif; ?>
    </table>
    
    <a class="button" href="?view=add_book">Добавить книгу</a>