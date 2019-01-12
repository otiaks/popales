<?php
/*
Template Name: owner_新規登録フォーム_メール認証
*/
?>
<?php get_header(); ?>
<div class="p-form__area">
    <div class="p-form__title"><span>メールアドレス入力</span></div>
    <div class="p-flow__area">
        <div class="p-flow__wrap is-active"><div class="p-flow__parts">メールアドレス入力</div></div>
        <div class="p-flow__wrap"><div class="p-flow__parts">メールアドレス認証</div></div>
        <div class="p-flow__wrap"><div class="p-flow__parts">基本情報入力</div></div>
    </div>
    <div class="is-step1">  
        <form class="p-input__area is-register__mail" id="form-register-mail" action="" method="post">
            <div class="p-wrap__confirm p-mail__area">
                <input type="mail" name="user-mail" class="p-input__style" placeholder="メールアドレス" required>
                <input type="mail" name="user-mail-conf" class="p-input__style" placeholder="メールアドレス確認用" required>
            </div>
            <input type="submit" class="p-btn__round is-form" value="認証メールを送信する">
        </form>
    </div>
    <div class="is-step2">
        <div class="p-register__text">
            <div class="p-text__block">
                <span>POALESにご登録いただきまして、誠にありがとうございます。</span><br>
                <span>ご登録いただいたメールアドレスに確認メールを送信いたしました。</span><br>
            </div>
            <div class="p-text__block">
                <span>アカウント登録を完了するには、６０分以内にメールに記載のリンクを</span><br>
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