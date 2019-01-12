<?php

function create_token($user_email, $status)
{
    global $tokendir;
    $token = rand(0, 100).uniqid(); //トークン
    $token_name = dirname(__FILE__).'/../token/'.$status.'/'.$token.'.log';
    touch($token_name); //トークンファイル作成
    $url = home_url().'/'.$status.'/register-profile'.'?key='.$token;
    $email_token = openssl_encrypt($user_email, 'AES-128-ECB', $token);
    file_put_contents($token_name, $email_token, LOCK_EX); //期限保存
    return $url;
}

function delete_old_token($token = null, $tokendir)
{
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


$user_email = null;
//メール認証URLを踏んだときの有効期限チェック
function is_token_exist()
{
    if (strpos($_SERVER['REQUEST_URI'], '/register-profile') !== false):
        if (strpos($_SERVER['REQUEST_URI'], '?key=') === false):
            show_404(); 
        else:
            $token = explode('?key=', $_SERVER['REQUEST_URI'])[1];
            $tokendir = dirname(__FILE__).'/../token/';
            if (strpos($_SERVER['REQUEST_URI'], 'owner') !== false):
                $tokendir = dirname(__FILE__).'/../token/owner/';
            elseif (strpos($_SERVER['REQUEST_URI'], 'chef') !== false):
                $tokendir = dirname(__FILE__).'/../token/chef/';
            endif;
            $file_name = $tokendir.$token.'.log';
            delete_old_token($token, $tokendir);
            if (!is_file($file_name)):
                show_404(); 
            else:
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

add_action('template_redirect', 'is_token_exist');
