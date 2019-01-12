<?php

// formのajax処理のための変数定義
function add_my_ajaxurl() {
?>
    <script>
        var ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
    </script>
<?php
}
add_action( 'wp_head', 'add_my_ajaxurl', 1 );

// 登録完了メール送信
function send_register_comp(){
    $to = $_POST['user-email'];
    $subject = 'popalesアカウント登録完了のお知らせ';
    $message = $_POST['user-name-last'].$_POST['user-name-first']."さん\nご登録ありがとうございます。\n社員一同、貴方の挑戦を心から応援いたします";
    wp_mail( $to, $subject, $message ); 
    global $wpdb;
    // $wpdb->insert('wp_popales_users',array(
    //     'name_last' => $_POST['user-name-last'],
    //     'name_first' => $_POST['user-name-first'],
    //     'password' => $_POST['user-pass'],
    //     'email' => $_POST['user-email'],
    //     'status' => 0
    // ));
    // unset($_POST);
}
add_action( 'wp_ajax_register_comp', 'send_register_comp' );
add_action( 'wp_ajax_nopriv_register_comp', 'send_register_comp' );

// 認証メール送信
function send_register_mail(){
    $mail = $_POST['user-mail'];
    $subject = 'popalesアカウント登録完了のお知らせ';
    
    if(strpos($_POST['url-slag'],'chef') !== false){
        $status = 'chef';
    }elseif(strpos($_POST['url-slag'],'owner') !== false) {
        $status = 'owner';
    }
    $profile_url = create_token($mail, $status);
    $message = "メール認証ありがとうございます。以下のURLからプロフィールを入力してください。\n60分以内にアクセスが無かった場合は無効となります。\n";
    $message .= $profile_url;
    wp_mail( $mail, $subject, $message ); 
}
add_action( 'wp_ajax_register_mail', 'send_register_mail' );
add_action( 'wp_ajax_nopriv_register_mail', 'send_register_mail' );