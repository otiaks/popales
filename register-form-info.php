<?php
/*
Template Name: 新規登録フォーム_基本情報
*/
?>
<?php get_header('form'); ?>

<form method="post" class="p-form__area" action="/popales/login">

    <div class="p-form__title"><span>基本情報入力</span></div>
    <div class="p-flow__area">
        <div class="p-flow__parts is-active">基本情報入力</div>
        <div class="p-flow__parts">メールアドレス認証</div>
        <div class="p-flow__parts">プロフィール入力</div>
        <div class="p-flow__parts">登録完了</div>
    </div>
    <div class="p-input__area">
        
        <!-- <div class="p-name__area">
            <input type="text" name="name_last" class="p-name__last" placeholder="姓">
            <input type="text" name="name_first" class="p-name__first" placeholder="名">
        </div>
        <input type="mail" name="mail" class="p-mail__text" placeholder="メールアドレス">
        <input type="mail" name="mail_conf" class="p-mail__text" placeholder="メールアドレス確認用">
        <input type="password" name="pass" class="p-password__text" placeholder="パスワード">
        <input type="password" name="pass_conf" class="p-password__text" placeholder="パスワード確認用"> -->
    </div>

    <!-- <input type="submit" class="p-btn__round is-form" value="登録する"> -->
</form>

<?php
        $page_data = get_page_by_path('register'); $page = get_post($page_data);
        $content = $page -> post_content;

        // 本文を表示する（自動整形含む）
        echo apply_filters('the_content', $content);
        ?>

<?php get_footer(); ?>

