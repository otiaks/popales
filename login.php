<?php
//フィルターフック
add_filter('wpcf7_special_mail_tags', 'my_special_mail_tags',10,2);

function my_special_mail_tags($output, $name) { 
        //画面に入れた適当な独自のタグ名で引っ掛けて
	if($name == '_proxy') {

	}
        //この内容が[_proxy]タグの内容となる
	return $output;
}



$tokendir = dirname( __FILE__ ). DIRECTORY_SEPARATOR ."token" . DIRECTORY_SEPARATOR;
     
if($_POST["mail"]==""){
    print "メールアドレスを入力してください";
}elseif(mb_strlen($_POST["mail"]) > 0 && !preg_match("/^([a-z0-9_]|\-|\.|\+)+@(([a-z0-9_]|\-)+\.)+[a-z]{2,6}$/i",$_POST["mail"])){
    print "メールアドレスの書式に誤りがあります。";
}else{
    print "確認メールを送信しました";
    mail_to_token($_POST["mail"]);
}
 
if(isset($_GET["key"])){
    if(delete_old_token($_GET["key"]))
        print "登録完了しました。";
    else
        print 'もう一度初めからやり直してください。';
}
 
 
function mail_to_token($address)
{
    global $tokendir;
     
    $limit = (time()+3600);
     
    $token= rand(0,100).uniqid();//トークン
     
    touch($tokendir.$token.".log");//トークンファイル作成
 
    $url = $_SERVER["HTTP_REFERER"]."?key=".$token;
     
    file_put_contents($tokendir.$token.".log", $limit, LOCK_EX);//期限保存
     
    delete_old_token($tokendir);//古いトークン削除
     
    //本文スタイル
    $message="登録を完了するには、以下のアドレスを開いてください。\n60分以内にアクセスが無かった場合は無効となります。\n";
    $message.=$url."\n\n";
     
    my_send_mail($address,'登録確認',$message);
}
 
 
function delete_old_token($token = NULL)
{
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
 
function my_send_mail($mailto, $subject, $message)
{
     
    $message = mb_convert_encoding($message, "JIS", "UTF-8");
    $subject = mb_convert_encoding($subject, "JIS", "UTF-8");
     
    $header ="From: WebTecNote <info@example.com>\n";
     
    mb_send_mail($mailto, $subject, $message, $header);
}
?>