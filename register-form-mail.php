<?php
/*
Template Name: 新規登録フォーム_メール認証
*/
?>
<?php get_header('form'); ?>
<div class="p-form__area">
    <div class="is-step1">
        <div class="p-form__title" id="btn"><span>基本情報入力</span></div>
        <div class="p-flow__area">
            <!-- <div class="p-flow__wrap is-active"><div class="p-flow__parts">メールアドレス入力</div></div>
            <div class="p-flow__wrap"><div class="p-flow__parts">メールアドレス認証</div></div>
            <div class="p-flow__wrap is-active"><div class="p-flow__parts">基本情報入力</div></div>
            <div class="p-flow__wrap"><div class="p-flow__parts">プロフィール入力</div></div>
            <div class="p-flow__wrap"><div class="p-flow__parts">登録完了</div></div> -->
        </div>
            <!-- フォーム内容 -->
            <?php
                $page_data = get_page_by_path('register'); $page = get_post($page_data);
                $content = $page -> post_content;
                echo apply_filters('the_content', $content);
            ?>
    </div>
    <div class="is-step2">
        <div class="p-form__title" id="btn"><span>ご登録メールアドレスの確認</span></div>
            <div class="p-flow__area"></div>
            <div class="p-register__text">
                <div class="p-text__block">
                    <span>POALESにご登録いただきまして、誠にありがとうございます。</span><br>
                    <span>ご登録いただいたメールアドレスに確認メールを送信いたしました。</span><br>
                </div>
                <div class="p-text__block">
                    <span>アカウント登録を完了するには、３０分以内にメールに記載のリンクを</span><br>
                    <span>クリックし、アカウントを承認してください。</span><br>
                </div>
                <div class="p-text__block">                    
                    <span>届いていない場合、迷惑メールボックスに振り分けられている可能性がありますので、</span><br>
                    <span>そちらの方のご確認もお願いいたします。</span><br>
                </div>
            </div>
    </div>
</div>


<?php get_footer(); ?>