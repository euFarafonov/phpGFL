<?php defined('MYBOOK') or die('Access denied'); ?>
<div class="content">
    <h1>Список авторов</h1>
<?php
if (isset($_SESSION['answer'])) {
    echo $_SESSION['answer'];
    unset ($_SESSION['answer']);
}
?>
	<a class="button" href="?view=add_author">Добавить автора</a>
    
    <table class="pages_table">
        <tr>
    		<th>№</th>
    		<th>Имя автора</th>
    		<th>Действие</th>
        </tr>
        <?php if($authors) : ?>
        <?php $i = 1; ?>
        <?php foreach($authors as $author) : ?>
        <tr>
            <td><?=$i?></td>
            <td class="left"><?=$author['name']?></td>
            <td>
                <a href="?view=edit_author&author_id=<?=$author['id']?>" class="edit">редактировать</a>
                |
                <a href="?view=del_author&author_id=<?=$author['id']?>" class="del">удалить</a>
            </td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
        <?php endif; ?>
    </table>
    
    <a class="button" href="?view=add_author">Добавить автора</a>