<?php

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
