<?php defined('MYBOOK') or die('Access denied'); ?>

<div class="leftbar" id="leftbar">
	<ul class="leftbar_nav">
		<li><a <?=$this->active_url("view=admin")?> href="?view=admin" data-name="Список всех книг">Каталог книг</a></li>
        <li><a <?=$this->active_url("view=admin_authors")?> href="?view=admin_authors" data-name="Список авторов">Авторы</a></li>
        <li><a <?=$this->active_url("view=admin_genres")?> href="?view=admin_genres" data-name="Список жанров">Жанры</a></li>
    </ul>
</div>
<script>
window.onload = function() {
    var lb = new Leftbar({
        lbId: 'leftbar'
    });
};
</script>