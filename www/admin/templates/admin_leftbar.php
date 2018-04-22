<?php defined('MYBOOK') or die('Access denied'); ?>

<div class="leftbar">
	<ul class="leftbar_nav">
		<li><a <?=$this->active_url("view=admin")?> href="?view=admin">Каталог книг</a></li>
        <li><a <?=$this->active_url("view=admin_authors")?> href="?view=admin_authors">Авторы</a></li>
        <li><a <?=$this->active_url("view=admin_genres")?> href="?view=admin_genres">Жанры</a></li>
    </ul>
</div>