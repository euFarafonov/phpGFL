<?php defined('MYBOOK') or exit('Access denied'); ?>

<!-- MAIN CONTENT -->
<article class="article">
    <h1><?=$page_header?></h1>
    <div class="hits_wrap container">
    <?php if($books) : ?>
        <?php foreach($books as $item) : ?>
        <a class="hits_item" href="<?=PATH?>?view=book&book_id=<?=$item['id']?>">
            <div class="hits_img">
                <img src="<?=BOOKIMG?><?=$item['img']?>" alt="<?=$item['name']?>">
            </div>
            <h2 class="hits_title"><?=$item['name']?></h2>
            <div class="hits_price"><?=$item['price']?> <?=CURRENCY?></div>
        </a>
        <?php endforeach;?>
    <?php else : ?>
        <div class="not_info">В данной категории книг пока нет!</div>
    <?php endif; ?>
    </div>
</article>