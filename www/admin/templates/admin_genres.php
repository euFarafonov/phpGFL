<?php defined('MYBOOK') or die('Access denied'); ?>
<div class="content">
    <h1>Список жанров</h1>
<?php
if (isset($_SESSION['answer'])) {
    echo $_SESSION['answer'];
    unset ($_SESSION['answer']);
}
?>
	<a class="button" href="?view=add_genre">Добавить жанр</a>
    
    <table class="pages_table">
        <tr>
    		<th>№</th>
    		<th>Название жанра</th>
    		<th>Действие</th>
        </tr>
        <?php if($genres) : ?>
        <?php $i = 1; ?>
        <?php foreach($genres as $genre) : ?>
        <tr>
            <td><?=$i?></td>
            <td class="left"><?=$genre['name']?></td>
            <td>
                <a href="?view=edit_genre&genre_id=<?=$genre['id']?>" class="edit">редактировать</a>
                |
                <a href="?view=del_genre&genre_id=<?=$genre['id']?>" class="del">удалить</a>
            </td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
        <?php endif; ?>
    </table>
    
    <a class="button" href="?view=add_genre">Добавить жанр</a>