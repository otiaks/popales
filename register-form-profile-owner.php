<?php
/*
Template Name: owner_新規登録フォーム_プロフィール
*/
?>
<?php get_header(); ?>

<div class="p-form__area">
    <!-- <div class="p-register__area"> -->
        <div class="p-form__title" id="btn"><span>基本情報入力</span></div>
        <div class="p-flow__area">
            <div class="p-flow__wrap"><div class="p-flow__parts">メールアドレス入力</div></div>
            <div class="p-flow__wrap"><div class="p-flow__parts">メールアドレス認証</div></div>
            <div class="p-flow__wrap is-active"><div class="p-flow__parts">基本情報入力</div></div>
        </div>
        <div class="p-explain__text is-profile">レストランオーナーの方に自己紹介をしましょう。（ <span class="is-required">*</span> 必須 ）</div>
        <form class="p-input__area" id="form-basis-info" action="" method="post">
            <div class="is-basis-info">
                <div class="p-form__label">
                    <span>お名前</span>
                    <span class="p-error__text is-name"></span>
                </div>
                <div class="p-name__area">
                    <input type="text" name="user-name-last" class="p-input__style" placeholder="姓" required>
                    <input type="text" name="user-name-first" class="p-input__style" placeholder="名" required>
                </div>
                
                <div class="p-form__label">
                    <span>メールアドレス</span>
                </div>
                <div class="p-email__area">
                    <input type="email" name="user-email" class="p-input__style" readonly>
                </div>
                
                <div class="p-form__label">
                    <span>パスワード</span>
                    <span class="p-error__text is-password"></span>
                </div>
                <div class="p-wrap__confirm p-passowrd__area">
                    <input type="password" name="user-pass" class="p-input__style" placeholder="パスワード" minlength="8" maxlength="12" size="12" required>
                    <input type="password" name="user-pass-conf" class="p-input__style" placeholder="パスワード確認用" minlength="8" maxlength="12" size="12" required>
                </div>
                
                <input type="button" id="next-form-btn" class="p-btn__round is-form" value="プロフィール入力画面へ">
            </div>
            <div class="is-profile">
                <div class="p-form__label">
                    <span>プロフィール画像 </span><span class="is-required">*</span>
                </div>
                <div class="p-img__area p-input__style">
                    <label class="p-post__img">
                        <input type="file" name="user-img" filetype="png jpg">
                        ファイルを選択
                    </label>
                    <div class="p-show__img"></div>
                </div>
                <div class="p-form__label">
                    <span>経歴 </span><span class="is-required">*</span>
                </div>
                <textarea name="user-textarea" class="p-input__style p-text__area" cols="40" rows="5" wrap="hard"></textarea>
                <div class="p-btn__area">
                    <div>
                        <input type="submit" name="register_tmp_btn" id="save_temp" class="p-btn__border" value="一時保存" >
                    </div>
                    <div>
                        <input type="submit" name="register_comp_btn" id="saved_comp" class="p-btn__round" value="登録する">
                    </div>
                </div>
            </div>
        </form>
        <div class="p-register__complete">
            <div class="p-register__text">
                <div class="p-text__block">
                    <span>ご登録ありがとうございます。これで登録は完了です。</span><br>
                    <span>オーナーとの連絡を実際に取れるようになりました。</span><br>
                    <span>ご登録いただいたメールアドレスに、登録完了メールを送信いたしました。</span><br>
                </div>
                <div class="p-text__block">
                    <span>社員一同、貴方の挑戦を心から応援いたします。</span><br>
                </div>
            </div>
            <div class="p-footer__btn">
                <input type="button" class="p-btn__border" value="トップページへ戻る">
            </div>
        </div>
        <div class="p-register__temporary">
            <div class="p-register__text">
                <div class="p-text__block">
                    <span>ご登録ありがとうございます。</span><br>
                    <span>ご登録いただいたメールアドレスに、登録完了メールを送信いたしました。</span><br>
                    <span>オーナーと実際に連絡を取る際、プロフィール完成が必須です。</span><br>
                    <span>その際改めて入力していただきますよう、よろしくお願いいたします。</span><br>
                </div>
                <div class="p-text__block">
                    <span>社員一同、貴方の挑戦を心から応援いたします。</span><br>
                </div>
            </div>
            <div class="p-footer__btn">
                <input type="button" class="p-btn__border" value="トップページへ戻る">
            </div>
        </div>
    <!-- </div> -->
</div>

<?php get_footer(); ?>

