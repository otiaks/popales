<?php

//フォームメールにトークンURLを設置
add_filter('wpcf7_special_mail_tags', 'my_special_mail_tags',10,2);

function my_special_mail_tags($output, $name) { 
        //画面に入れた適当な独自のタグ名で引っ掛けて
	if($name == '_proxy') {
        $output = create_token();
	}
        //この内容が[_proxy]タグの内容となる
	return $output;
}

$tokendir = dirname( __FILE__ ). '/token/';

function create_token() {
    global $tokendir;
    $limit = (time()+1800);
    $token= rand(0,100).uniqid();//トークン
    touch($tokendir.$token.".log");//トークンファイル作成
    $url = home_url()."/register-profile"."?key=".$token;
    file_put_contents($tokendir.$token.".log", $limit, LOCK_EX);//期限保存
    delete_old_token($token);//古いトークン削除
    // //本文スタイル
    $message="登録を完了するには、以下のアドレスを開いてください。\n60分以内にアクセスが無かった場合は無効となります。\n";
    $message.=$url."\n\n";

    return $message;
}

function delete_old_token($token = NULL) {
    global $tokendir;
    if (is_dir($tokendir)) {
        if ($dh = opendir($tokendir)) {
            while (($file = readdir($dh)) !== false) {
                if(is_file($tokendir.$file) && is_null($token)){
                    $data = file_get_contents($tokendir.$file);
                    if(time() > $data) unlink($tokendir.$file);
                }else if(is_file($tokendir.$file) && !is_null($token)){
                    if(time() < (filemtime($tokendir.$token.".log")+1800) ){
                        return true;
                    }else{
                        @unlink($tokendir.$token.".log");
                        return false;
                    }
                }
            }
            closedir($dh);
        }
    }
}

function wpcf7_main_validation_filter( $result, $tag ) {
  $type = $tag['type'];
  $name = $tag['name'];
  $_POST[$name] = trim( strtr( (string) $_POST[$name], "\n", " " ) );
  if ( 'email' == $type || 'email*' == $type ) {
    if (preg_match('/(.*)_confirm$/', $name, $matches)){
      $target_name = $matches[1];
      if ($_POST[$name] != $_POST[$target_name]) {
        if (method_exists($result, 'invalidate')) {
          $result->invalidate( $tag,"メールアドレスが一致していません");
      } else {
          $result['valid'] = false;
          $result['reason'][$name] = 'メールアドレスが一致していません';
        }
      }
    }
  }
  return $result;
}

add_filter( 'wpcf7_validate_email', 'wpcf7_main_validation_filter', 11, 2 );
add_filter( 'wpcf7_validate_email*', 'wpcf7_main_validation_filter', 11, 2 );


function twpp_enqueue_scripts() {
  wp_enqueue_script( 
    'register-form-script', 
    get_template_directory_uri() . '/js/register-form.js',
    array(),
    false,
    true
  );
}
add_action( 'wp_enqueue_scripts', 'twpp_enqueue_scripts' );


function is_token_exist() {
    if(strstr($_SERVER['REQUEST_URI'],'/register-profile')): 
        if(!strstr($_SERVER['REQUEST_URI'],'?key=')):
            show_404();
        else:
            $token = explode('?key=',$_SERVER['REQUEST_URI'])[1];
            delete_old_token($token);
            global $tokendir;
            $file_name = $tokendir . $token. '.log';
            if(!is_file($file_name)):
                show_404();
            endif;
        endif;
    endif; 
}
function show_404() {
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    include( get_query_template( '404' ) );
    exit();
}
add_action( 'template_redirect', 'is_token_exist' );
