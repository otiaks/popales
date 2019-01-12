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
            $(".p-flow__wrap").eq(2).removeClass('is-active');
            $(".p-flow__wrap").eq(3).addClass('is-active');
            $(".p-form__title span").text("プロフィール入力");
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
        var $button = $(this).find("input[type=submit]:focus");
        event.preventDefault();
        var fd = new FormData(this);
        fd.append('action', 'register_comp');
        $.ajax({
            type: 'POST',
            url: ajaxurl, //form-send-mail.phpで定義した変数
            data: fd,
            processData: false,
            contentType: false,
            beforeSend: function(xhr, settings) {
                $button.attr("disabled", true);
            },
            complete: function(xhr, textStatus) {
                $button.attr("disabled", false);
            },
            success: function(result, textStatus, xhr) {
                $(".p-flow__wrap").eq(3).removeClass('is-active');
                $(".p-flow__wrap").eq(4).addClass('is-active');
                $("#form-basis-info").remove();
                if ($button.attr("name") == "register_tmp_btn") {
                    $(".p-form__title span").text("一時保存完了");
                    $(".p-register__temporary").css('display','flex');
                } else if ($button.attr("name") == "register_comp_btn") {
                    $(".p-form__title span").text("登録完了");
                    $(".p-register__complete").css('display', 'flex');
                }
            },
            error: function(xhr, textStatus, error) {
                alert("NG...");
            }
        });
    });


    $("#form-register-mail").submit(function (event) {
        var $button = $(this).find("input[type=submit]:focus");
        event.preventDefault();
        var formData = new FormData(this);
        /* <![CDATA[ */
        var slag = url_slag;
        /* ]]> */
        formData.append("action", "register_mail");
        formData.append("url-slag", slag);
        $.ajax({
            type: "POST",
            url: ajaxurl, //form-send-mail.phpで定義した変数,
            data: formData,
            processData: false,
            contentType: false,
        }).done(function (res) {
            console.log("ajax通信に成功しました");
            $(".p-flow__wrap")
              .eq(0)
              .removeClass("is-active");
            $(".p-flow__wrap")
              .eq(1)
              .addClass("is-active");
            $(".is-step1").remove();
            $(".is-step2").show();
        }).fail(function(xhr, textStatus, errorThrown) {
            console.log("ajax通信に失敗しました");
            console.log(xhr);
            console.log(textStatus);
            console.log(errorThrown);
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


