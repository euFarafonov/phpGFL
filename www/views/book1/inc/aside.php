<?php defined('MYBOOK') or die('Access denied'); ?>

<aside class="aside">
    <ul class="nav" id="nav">
        <li><a class="js_clear_storage" href="<?=PATH?>">Каталог книг</a></li>
        <li>
            <div class="nav_header">Авторы</div>
            <ul class="nav_inner">
            <?php if($authors) : ?>
                <?php foreach($authors as $key => $auth) : ?>
                <li><a class="js_nav_storage" id="author_<?=$key?>" data-name="author" data-id="<?=$key?>" href="<?=PATH?>?author=<?=$key?>">- <?=$auth?></a></li>
                <?php endforeach;?>
            <?php endif; ?>
            </ul>
        </li>
        <li>
            <div class="nav_header">Жанры</div>
            <ul class="nav_inner">
            <?php if($genres) : ?>
                <?php foreach($genres as $key => $genre) : ?>
                <li><a class="js_nav_storage" id="genre_<?=$key?>" data-name="genre" data-id="<?=$key?>" href="<?=PATH?>?genre=<?=$key?>">- <?=$genre?></a></li>
                <?php endforeach;?>
            <?php endif; ?>
            </ul>
        </li>
    </ul>
</aside>
<script>
window.onload = function() {
    var nav = new Accordion({
        navId: 'nav',
        navHeader: 'nav_header'
    });
};
</script>