<?php defined('MYBOOK') or exit('Access denied'); ?>
<div class="content">
    <h1>Список всех книг</h1>
<?php
if (isset($_SESSION['answer'])) {
    echo $_SESSION['answer'];
    unset ($_SESSION['answer']);
}
?>
	<span class="button" data-todo="add_book">Добавить</span>
    
    <table class="pages_table">
        <tr>
    		<th>№</th>
            <th>Фото</th>
    		<th>Наименование</th>
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
                <span data-id="<?=$book['id']?>" class="edit">редактировать</span>
                |
                <span data-id="<?=$book['id']?>" class="del">удалить</span>
            </td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
        <?php endif; ?>
    </table>
    
    <span class="button" data-todo="add_book">Добавить</span>
 </div>