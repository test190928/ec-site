<?php
require 'pdo_connect.php';
require "common.php";

session_start();
//ログイン済みの場合
if (isset($_SESSION['USER'])) {
    header("Location: product_list.php");
}

$email = $_POST['email'];

//URLパスワードを作成
$url_pass = get_url_password();
$date = date('Y-m-d H:i:s');

$prepare = $dbh->prepare("SELECT * FROM User_Info WHERE Email_Address = ?");
$prepare->execute([$email]);
$row = $prepare->fetchAll(PDO::FETCH_ASSOC);

if(!empty($row)){
    $prepare = $dbh->prepare("UPDATE User_Info SET temp_pass = ?, temp_limit_time = ? WHERE Email_Address = ?");
    $prepare->execute([$url_pass, $date, $email]);

    $to = $email;
    $title = "パスワードリセット";
    $msg = '以下のアドレスからパスワードのリセットを行ってください。' . PHP_EOL;
    $msg .=  'アドレスの有効時間は１０分間です。' . PHP_EOL . PHP_EOL;
    $msg .= 'http://localhost/php_test/test_sql/pass_reset_url.php?name=' . $url_pass;
    mb_send_mail($to, $title, $msg);
}



?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

	<div class="container">
		<div class="login-area">
			<div class="align">
    			<h1>メールを送信しました</h1>
                <form  action="pass_reset_mail.php" method="post">
                    <a href="index.php" class="cancel">戻る</a>
                </form>
            </div>
		</div>
	</div>

</body>
</html>
