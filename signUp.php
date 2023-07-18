<?php

require 'pdo_connect.php';

//POSTのValidate
if(!$email = filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
    echo "入力された値が不正です";
    return false;
}

//パスワードの正規表現
if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST["password"])){
    $password = password_hash($_POST["password"],PASSWORD_DEFAULT);
}else {
    echo "パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。";
    return false;
}

try {
    $stmt = $dbh->prepare("insert into User_Info(Email_Address, Login_Pass) value(?, ?)");
    $stmt->execute([$email, $password]);
    echo '登録完了';
}catch(Exception $e){
    echo '登録済みのメールアドレスです。';
}

?>