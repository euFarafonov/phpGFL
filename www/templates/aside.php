<?php defined('MYBOOK') or exit('Access denied'); ?>

<aside class="aside">
    <ul class="nav" id="nav">
        <li><a class="js_clear_storage" href="<?=PATH?>">Каталог книг</a></li>
        <li>
            <div class="nav_header">Авторы</div>
            <ul class="nav_inner">
            
            <?php if($authors) : ?>
                <?php foreach($authors as $auth) : ?>
                <li><a class="js_nav_storage" id="author_<?=$auth['id']?>" data-name="author" data-id="<?=$auth['id']?>" href="<?=PATH?>?author=<?=$auth['id']?>">- <?=$auth['name']?></a></li>
                <?php endforeach;?>
            <?php endif; ?>
            </ul>
        </li>
        <li>
            <div class="nav_header">Жанры</div>
            <ul class="nav_inner">
            <?php if($genres) : ?>
                <?php foreach($genres as $genre) : ?>
                <li><a class="js_nav_storage" id="genre_<?=$genre['id']?>" data-name="genre" data-id="<?=$genre['id']?>" href="<?=PATH?>?genre=<?=$genre['id']?>">- <?=$genre['name']?></a></li>
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