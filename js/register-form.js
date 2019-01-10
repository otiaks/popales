jQuery(function ($) {
    // 新規登録のメール認証画面
    document.addEventListener('wpcf7mailsent', function () {
        $('.is-step1').remove();
        $('.is-step2').show();
    }, false);

    //基本情報のアドレス欄にアドレスを挿入
    $(document).ready(function () {
        /* <![CDATA[ */
        var email_data = user_email;
        /* ]]> */
        // form-register.phpからのemail_data取得
        $('input[name="user-email"]').val(email_data);
    });
    
    // フォームの画像選択後に表示
    $(document).ready(function () {
        $('input[name="user-img"]').change(function () {
            console.log("lja;faj");
            var file = $(this).prop('files')[0];
            var fr = new FileReader();
            $(".p-show__img").css("background-image", "none");
            fr.onload = function () {
                $(".p-show__img").css({
                    "background-image": "url(" + fr.result + ")",
                    "background-size": "cover"
                });
            }
            fr.readAsDataURL(file);
        });
    });

// フォームバリデーション
    $(".p-name__area input").on("change keyup", function () {
            form_error_text(this);
        }    
    );
    $(".p-passowrd__area input").on("change keyup", function () {
        form_error_email(this);
    });

    $("#next-form-btn").click(function () {
        var is_Filled = true;
        $(".is-basis-info input").each(function(num, result) {
          if ($(result).val().length == 0) {
            is_Filled = false;
          } else if ($(result)
              .parent()
              .prev(".p-form__label")
              .find(".p-error__text")
              .text().length != 0) {
            is_Filled = false;
          }
        });
        if (is_Filled) {
            $(".is-basis-info").hide();
            $(".is-profile").show();
        } else {
            form_error_text(".p-name__area input");
            form_error_email(".p-passowrd__area input");
        }
    });
    $(".is-basis-info input").on("keypress",function(e) {
        if (e.which == 13) {
          $("#next-form-btn").click();
          return false;
        }
    });

    $("#form-basis-info").submit(function (event) {
        $button = $(this).find("#saved_comp");
        // クリックイベントをこれ以上伝播させない
        event.preventDefault();
        // フォームデータから、サーバへ送信するデータを作成
        var fd = new FormData(this);
        // サーバー側で何の処理をするかを指定。後ほどphp側で実装する
        fd.append('action', 'ajaxtest');
        // 送信
        $.ajax({
            type: 'POST',
            url: ajaxurl, //functions.phpで定義した変数
            data: fd,
            processData: false,
            contentType: false,

            // 送信前
            beforeSend: function(xhr, settings) {
            // ボタンを無効化し、二重送信を防止
            $button.attr("disabled", true);
            },
            // 応答後
            complete: function(xhr, textStatus) {
            // ボタンを有効化し、再送信を許可
            $button.attr("disabled", false);
            },
            // 通信成功時の処理
            success: function(result, textStatus, xhr) {
            // 入力値を初期化
            $(".p-register__complete").show();
            $(".p-register__area").remove();
            },
            // 通信失敗時の処理
            error: function(xhr, textStatus, error) {
            alert("NG...");
            }
      });
    });


    function form_error_text(form_tag) {
        $(function () {
            if ($(form_tag).val().length == 0) {
              $(".p-error__text" + ".is-name").text("入力されていないものがあります。");
            } else {
              $(".p-error__text" + ".is-name").text("");
            }
        });
    }
    function form_error_email(form_tag) {
        $(function () {
            if ($(form_tag).val().length == 0) {
              $(".p-error__text" + ".is-password").text("入力されていないものがあります。");
            } else if ($(form_tag).val().length < 8) {
                     $(".p-error__text" + ".is-password").text("8文字以上入力してください。");
            } else if ($(form_tag).val() != $(form_tag).siblings().val()) {
                $(".p-error__text" + ".is-password").text("パスワードが一致していません。");
            } else {
                $(".p-error__text" + ".is-password").text("");
            }
        });
    }

});


