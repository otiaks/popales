<?php
// 共通ファイルの読み込み
function add_common_files() {
    $src = get_template_directory_uri();
    wp_enqueue_style( 'style', $src.'/style.css');
    wp_enqueue_style( 'header', $src.'/css/header.css');
    wp_enqueue_style( 'fooaater', $src.'/css/footer.css');
}
add_action( 'wp_enqueue_scripts', 'add_common_files', 50 );


function add_form_files() {
    $src = get_template_directory_uri();
    // topページに関するファイルの読み込み
    if (strstr($_SERVER['REQUEST_URI'],'top') ){
        wp_enqueue_style( 'top', $src.'/css/top-page.css' );
    } elseif (strstr($_SERVER['REQUEST_URI'],'register-mail') || strstr($_SERVER['REQUEST_URI'],'register-profile')) {
        // 新規登録に関するファイルの読み込みと変数の受け渡し
        $deps = "";
        $ver = "1.0";
        $in_footer = true;
        wp_enqueue_script( 'register-form-script', $src.'/js/register-form.js', $deps, $ver, $in_footer );
        wp_enqueue_script( 'form-validate-script', $src.'/js/form-validate.js', $deps, $ver, $in_footer );
        wp_enqueue_style( 'top', $src.'/css/register-form.css' );
        global $user_email;
        wp_localize_script('register-form-script', 'user_email', $user_email);
        wp_localize_script('register-form-script', 'url_slag', $_SERVER['REQUEST_URI']);
    }
}
add_action( 'wp_enqueue_scripts', 'add_form_files' );
?>