<?php

require "pdo_connect.php";
session_start();

$prepare = $dbh->prepare("SELECT * FROM User_Info WHERE User_ID=?");
$prepare->execute([$_SESSION["ID"]]);
$user = $prepare->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
	<title>会員情報</title>
	<script src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>
	<link rel="stylesheet" href="css/common.css">
	<link rel="stylesheet" href="css/popup.css">
	<link rel="stylesheet" href="css/account.css">
</head>
<body>
	<?php require 'nav.php'; ?>
	<?php require 'search_area.php'; ?>

	<div class="container">
		<div class="profile-area">
			<h3 class="profile-title">会員情報</h3>
			<div class="profile-edit-button"><a href="profile_edit.php">編集する</a></div>
			<div class="clear"></div>
			<p>ユーザー名</p>
			<p class="profile-content"><?php echo $user[0]["User_Name"] ?></p>
			<p>メールアドレス</p>
			<p class="profile-content"><?php echo $user[0]["Email_Address"] ?></p>
			<p>パスワード</p>
			<p class="profile-content">パスワードは表示されません<a href="password_reset.php" class="password-reset">パスワードを変更する</a></p>
		</div>
	</div>

	<?php if(@$_GET["name"] == "update"): ?>
        <div class="popup">
    		プロフィールを更新しました
        </div>
	<?php endif ?>
	<?php require 'footer.php'; ?>
    <script src="js/popup.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
</body>
</html>