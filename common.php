<?php

// トークンの取得
function get_csrf_token() {
    $token_legth = 16;//16*2=32byte
    $bytes = openssl_random_pseudo_bytes($token_legth);
    return bin2hex($bytes);
}

// URLの一時パスワードを作成
function get_url_password() {
    $token_length = 16;
    $bytes = openssl_random_pseudo_bytes($token_length);
    return hash("sha256", $bytes);
}

?>