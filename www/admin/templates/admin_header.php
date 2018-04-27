<?php defined('MYBOOK') or die('Access denied'); ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="lib/css/style_admin.css">
    <title>Админпанель <?=SITENAME?></title>
    <script>
        var path = '<?=PATH?>',
            currency = '<?=CURRENCY?>';
    </script>
</head>

<body>
<div class="wrapper">
	<header class="header clearfix">
		<a class="header_logo" href="<?=PATH?>admin">my-<span>shop</span>-admin</a>
        <div class="header_wrap clearfix">
            <div class="header_left"></div>
            <div class="header_right">
                <a href="<?=PATH?>" target="_blank"><?=SITENAME?></a>
            </div>
        </div>
	</header>
    
    <div class="page_wrapper">