<?php
require 'pdo_connect.php';
require "common.php";

session_start();
//ログイン済みの場合
if (isset($_SESSION['USER'])) {
    header("Location: product_list.php");
}

$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];
$email = $_POST["email"];

if($password != $confirm_password){
    $_SESSION['error_status'] = 1;
    header('Location: pass_reset_url.php?name=' . $_SESSION['url_pass']);
}else {
    $sql = "SELECT * FROM User_Info WHERE Email_Address = ?";
    $prepare = $dbh->prepare($sql);
    $prepare->bindValue(1, $email);
    $prepare->execute();
    $row = $prepare->fetchAll(PDO::FETCH_ASSOC);

    if(empty($row)) {
        $_SESSION['error_status'] = 1;
        header("location: pass_reset_url.php");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE User_Info SET Login_Pass = ? WHERE Email_address = ?";
    $prepare = $dbh->prepare($sql);
    $prepare->execute([$hashed_password, $email]);

    $to = $email;
    $title = "パスワードをリセットしました";
    $msg = 'パスワードがリセットされました。' ;
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
    			<h1>パスワードをリセットしました</h1>
                <form  action="pass_reset_submit.php" method="post">
                    <a href="index.php" class="cancel">戻る</a>
                </form>
            </div>
		</div>
	</div>

</body>
</html>
