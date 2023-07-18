<?php

require "pdo_connect.php";
session_start();

$prepare = $dbh->prepare("SELECT * FROM User_Info WHERE User_ID=?");
$prepare->execute([$_SESSION["ID"]]);
$user = $prepare->fetchAll(PDO::FETCH_ASSOC);

$error = '';
if (@$_POST['submit']) {
    $stmt = $dbh->prepare('select * from User_Info where User_ID = ?');
    $stmt->execute([$_SESSION["ID"]]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST["newPassword"])){
        echo "パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。";
    }

    if ($_POST['currentPassword'] == $_POST['newPassword']){
        echo "新しいパスワードを入力してください";
    } elseif (password_verify($_POST['currentPassword'], $row['Login_Pass'])){

        $password = password_hash($_POST["newPassword"],PASSWORD_DEFAULT);
        $prepare = $dbh->prepare("UPDATE User_Info SET Login_Pass=? WHERE User_ID = ?");
        $prepare->execute([$password,$_SESSION["ID"]]);
        header("Location: account.php");

    }else {
        echo "パスワードが間違っています";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>パスワード変更</title>
	<script src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>
	<link rel="stylesheet" href="css/common.css">
	<link rel="stylesheet" href="css/account.css">
</head>
<body>
	<?php require 'nav.php'; ?>
	<?php require 'search_area.php'; ?>

	<div class="container">

		<div class="profile-area profile-edit-area">
			<form action="password_reset.php" method="post">
    			<h3 class="profile-title">パスワード変更</h3>
    			<div class="clear"></div>
    			<p>現在のパスワード</p>
    			<input type="password" name="currentPassword" placeholder="Current Password" class="profile-edit-input">
    			<p>メールアドレス</p>
    			<input type="password" name="newPassword" placeholder="New Password" class="profile-edit-input">
    			<input type="submit" value="保存" name="submit" class="profile-edit-submit">
    			<a href="account.php" class="profile-edit-cancel">キャンセル</a>
			</form>
		</div>

	</div>

	<?php require 'footer.php'; ?>
    <script src="js/popup.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
</body>
</html>