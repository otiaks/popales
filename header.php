<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta charset="<?php bloginfo ('charset') ; ?>"> -->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title>Document</title>
    <?php wp_head(); ?>
</head>
    <?php 
    if(strstr($_SERVER['REQUEST_URI'],'owner')):
        $home_url = '/owner';
        $link_url = '/chef';
        $link_text = 'レストランを借りたい方';
        $home_class = 'is_owner';
    else:
        $home_url = '/chef';
        $link_url = '/owner';
        $link_text = 'レストランを借す方';
        $home_class = 'is_chef';
    endif;
    ?>
<body>
<header class="<?php echo $home_class ?>">
    <div class="p-logo__area">
        <a href="<?php echo home_url(); echo $home_url; ?>/top">
            <img src="<?php echo get_template_directory_uri(); ?>/img<?php echo $home_url?>_logo.png" alt="" height="35" width="200">
            <span class="p-logo__text">owner</span>
        </a>
    </div>
    
    <div class="p-menu__area">
        <span><a href="<?php echo home_url(); echo $link_url; ?>/top" rel="noopener noreferrer"><?php echo $link_text; ?></a></span>
        <span><a href="http://" target="_blank" rel="noopener noreferrer">メッセージ</a></span>
        <span><a href="http://" target="_blank" rel="noopener noreferrer">ヘルプ</a></span>
        <span><a href="<?php echo home_url(); echo $home_url; ?>/register-mail" rel="noopener noreferrer">新規登録</a></span>
        <span><a href="<?php echo home_url(); ?>/login" rel="noopener noreferrer">ログイン</a></span>
    </div>
</header>
