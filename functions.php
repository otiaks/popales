<?php
//フィルターフック
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
     
    $limit = (time()+3600);
     
    $token= rand(0,100).uniqid();//トークン
     
    touch($tokendir.$token.".log");//トークンファイル作成
 
    $url = $_SERVER["HTTP_REFERER"]."?key=".$token;
     
    file_put_contents($tokendir.$token.".log", $limit, LOCK_EX);//期限保存
     
    delete_old_token($tokendir);//古いトークン削除
     
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
                    if(time() < (filemtime($tokendir.$token.".log")+3600) ){
                        @unlink($tokendir.$token.".log");
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