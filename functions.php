<?php


//フォームメールにトークンURLを設置
add_filter('wpcf7_special_mail_tags', 'my_special_mail_tags', 10, 2);

function my_special_mail_tags($output, $name)
{
    //画面に入れた適当な独自のタグ名で引っ掛けて
    $submission = WPCF7_Submission::get_instance();
    if ($name == '_proxy') {
        if ($submission) {
            $formdata = $submission->get_posted_data();
            $email = $formdata['your_mail'];
        }
        $output = create_token($email);
    }
    //この内容が[_proxy]タグの内容となる
    return $output;
}

$tokendir = dirname(__FILE__).'/token/';
function create_token($user_email)
{
    global $tokendir;
    $token = rand(0, 100).uniqid(); //トークン
    $email_token = openssl_encrypt($user_email, 'AES-128-ECB', $token);

    touch($tokendir.$token.'.log'); //トークンファイル作成
    $url = home_url().'/register-profile'.'?key='.$token;
    file_put_contents($tokendir.$token.'.log', $email_token, LOCK_EX); //期限保存
    $message = "登録を完了するには、以下のアドレスを開いてください。\n60分以内にアクセスが無かった場合は無効となります。\n";
    $message .= $url."\n\n";

    return $message;
}

function delete_old_token($token = null)
{
    global $tokendir;
    if (is_dir($tokendir)) {
        if ($dh = opendir($tokendir)) {
            while (($file = readdir($dh)) !== false) {
                if (is_file($tokendir.$file) && is_null($token)) {
                    $data = file_get_contents($tokendir.$file);
                    if (time() > $data) {
                        unlink($tokendir.$file);
                    }
                } elseif (is_file($tokendir.$file) && !is_null($token)) {
                    if (time() < (filemtime($tokendir.$token.'.log') + 3600)) {
                        return true;
                    } else {
                        @unlink($tokendir.$token.'.log');

                        return false;
                    }
                }
            }
            closedir($dh);
        }
    }
}

function wpcf7_main_validation_filter($result, $tag)
{
    $type = $tag['type'];
    $name = $tag['name'];
    $_POST[$name] = trim(strtr((string) $_POST[$name], "\n", ' '));
    if ('email' == $type || 'email*' == $type) {
        if (preg_match('/(.*)_confirm$/', $name, $matches)) {
            $target_name = $matches[1];
            if ($_POST[$name] != $_POST[$target_name]) {
                if (method_exists($result, 'invalidate')) {
                    $result->invalidate($tag, 'メールアドレスが一致していません');
                } else {
                    $result['valid'] = false;
                    $result['reason'][$name] = 'メールアドレスが一致していません';
                }
            }
        }
    }

    return $result;
}

add_filter('wpcf7_validate_email', 'wpcf7_main_validation_filter', 11, 2);
add_filter('wpcf7_validate_email*', 'wpcf7_main_validation_filter', 11, 2);

$user_email = null;
//メール認証URLを踏んだときの有効期限チェック
function is_token_exist()
{
    if (strstr($_SERVER['REQUEST_URI'], '/register-profile')):
        if (!strstr($_SERVER['REQUEST_URI'], '?key=')):
            show_404(); else:
            $token = explode('?key=', $_SERVER['REQUEST_URI'])[1];
    delete_old_token($token);
    global $tokendir;
    $file_name = $tokendir.$token.'.log';
    if (!is_file($file_name)):
                show_404(); else:
                global $user_email;
    $fp = fopen($file_name, 'r');
    $user_email_coded = fgets($fp);
    $email = openssl_decrypt($user_email_coded, 'AES-128-ECB', $token);
    $user_email = $email;
    fclose($fp);
    endif;
    endif;
    endif;
}
function show_404()
{
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    include get_query_template('404');
    exit();
}
add_action('template_redirect', 'is_token_exist');

// 新規登録フォームへのjsファイル適用とuser-mailの受け渡し
function twpp_enqueue_scripts()
{
    if (is_page(['register_mail']) || is_page(['register_profile']) || is_page(['test'])) {
        wp_enqueue_script(
            'register-form-script',
            get_template_directory_uri().'/js/register-form.js',
            array(),
            false,
            true
        );
        global $user_email;
        wp_localize_script('register-form-script', 'user_email', $user_email);
    }
}
add_action('wp_enqueue_scripts', 'twpp_enqueue_scripts');

function add_my_ajaxurl() {
?>
    <script>
        var ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
    </script>
<?php
}
add_action( 'wp_head', 'add_my_ajaxurl', 1 );

function ajaxTestFunc(){
    $to = $_POST['user-email'];
    $subject = 'popalesアカウント登録完了のお知らせ';
    $message = $_POST['user-name-last'].$_POST['user-name-first']."さん\nご登録ありがとうございます。\n社員一同、貴方の挑戦を心から応援いたします";
    wp_mail( $to, $subject, $message ); 
    global $wpdb;
    $wpdb->insert('wp_popales_users',array(
        'name_last' => $_POST['user-name-last'],
        'name_first' => $_POST['user-name-first'],
        'password' => $_POST['user-pass'],
        'email' => $_POST['user-email'],
        'status' => 0
    ));
    unset($_POST);
}
add_action( 'wp_ajax_ajaxtest', 'ajaxTestFunc' );
add_action( 'wp_ajax_nopriv_ajaxtest', 'ajaxTestFunc' );

?>

