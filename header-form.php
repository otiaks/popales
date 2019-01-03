<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/header.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/footer.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/register-form.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<header>
    <div class="p-logo__area">
    </div>
    <div class="p-menu__area">
        <?php if(strstr($_SERVER['REQUEST_URI'],'owner')==true):?>
            <span><a href="<?php echo home_url(); ?>/chef/" rel="noopener noreferrer">レストランを借りたい方</a></span>
        <?php else:?>
            <span><a href="<?php echo home_url(); ?>/owner/" rel="noopener noreferrer">レストランを借す方</a></span>
        <?php endif?>
        <span><a href="<?php echo home_url(); ?>/chef/" rel="noopener noreferrer">メッセージ</a></span>
        <span><a href="<?php echo home_url(); ?>/chef/" rel="noopener noreferrer">ヘルプ</a></span>
        <span><a href="<?php echo home_url(); ?>/chef/" rel="noopener noreferrer">新規登録</a></span>
        <span><a href="<?php echo home_url(); ?>/login/" rel="noopener noreferrer">ログイン</a></span>
    </div>
</header>
