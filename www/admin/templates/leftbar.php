<?php defined('MYBOOK') or die('Access denied'); ?>

<div class="leftbar">
	<ul class="leftbar_nav">
		<li><a <?=active_url("view=books")?> href="?view=books">Каталог книг</a></li>
        <li><a <?=active_url("view=authors")?> href="?view=authors">Авторы</a></li>
        <li><a <?=active_url("view=genres")?> href="?view=genres">Жанры</a></li>
    </ul>
</div>