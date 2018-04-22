<?php defined('MYBOOK') or exit('Access denied');?>
<!DOCTYPE HTML>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?=TITLE?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="<?=LIB?>css/normalize.css">
    <link rel="stylesheet" href="<?=LIB?>css/style.css">
    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700&amp;subset=cyrillic" rel="stylesheet">
    <!-- SCRIPTS -->
    <script type="text/javascript">
        var path = '<?=PATH?>';
    </script>
</head>

<body>
<header class="header">
    <div class="header_wrap clearfix container">
        <div class="header_left">
            <a class="header_logo js_clear_storage" href="<?=PATH?>">
                <img src="<?=LIB?>img/logo.png" alt="logo">
            </a>
            <div class="header_slogan">Библиотека книг</div>
        </div>
        
        <div class="header_right">
            <div class="header_contact">
                <div>+38-067-111-11-11
                <br>+38-050-111-11-11</div>
                <div>email@gmail.com</div>
            </div>
            
            <!-- search -->
            <form class="header_search" action="<?=PATH?>" method="post">
                <input class="search_input" type="text" name="search" placeholder="Поиск книг">
                <ul class="search_list"></ul>
            </form>
        </div>
    </div>
</header>

<!-- MAIN -->
<div class="main container">